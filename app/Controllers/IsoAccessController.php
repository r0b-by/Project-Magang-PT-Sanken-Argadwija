<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IsoAccessHolderModel;
use App\Models\UserModel;
use App\Models\Iso00Model;

class IsoAccessController extends BaseController
{
    protected $accessModel;
    protected $userModel;
    protected $dokumenModel;

    public function __construct()
    {
        $this->accessModel  = new IsoAccessHolderModel();
        $this->userModel    = new UserModel();
        $this->dokumenModel = new Iso00Model();
    }

    // --------------------------------------------------------
    // LIST HAK AKSES (ADMIN)
    // --------------------------------------------------------
    public function index()
    {
        $data['akses'] = $this->accessModel
            ->select('iso_access_holders.*, users.fullname, users.username, iso_00.kode_dokumen, iso_00.nama_dokumen_internal')
            ->join('users', 'users.id = iso_access_holders.user_id')
            ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id')
            ->orderBy('iso_access_holders.id', 'DESC')
            ->findAll();

        return view('access/index', $data);
    }

    // --------------------------------------------------------
    // FORM TAMBAH HAK AKSES
    // --------------------------------------------------------
    public function create()
    {
        $data['users']   = $this->userModel->where('status_akun', 'aktif')->findAll();
        $data['dokumen'] = $this->dokumenModel->findAll();

        return view('access/create', $data);
    }

    // --------------------------------------------------------
    // SIMPAN
    // --------------------------------------------------------
    public function store()
    {
        $userId     = $this->request->getPost('user_id');
        $dokumenId  = $this->request->getPost('dokumen_id');
        $holderCode = strtoupper($this->request->getPost('holder_code'));

        // Validasi
        if (!$this->validate([
            'user_id'     => 'required|numeric',
            'dokumen_id'  => 'required|numeric',
            'holder_code' => 'required|min_length[1]|max_length[10]',
        ])) {
            return redirect()->back()->with('error', 'Form tidak valid.');
        }

        // Cek duplikasi
        if ($this->accessModel->exists($userId, $dokumenId)) {
            return redirect()->back()->with('error', 'User sudah memiliki akses ke dokumen ini.');
        }

        // Simpan
        $this->accessModel->insert([
            'user_id'     => $userId,
            'dokumen_id'  => $dokumenId,
            'holder_code' => $holderCode,
        ]);

        return redirect()->to('/access')->with('success', 'Hak akses berhasil ditambahkan!');
    }

    // --------------------------------------------------------
    // DELETE
    // --------------------------------------------------------
    public function delete($id)
    {
        $this->accessModel->delete($id);
        return redirect()->back()->with('success', 'Hak akses berhasil dihapus.');
    }

    // --------------------------------------------------------
    // SEARCH HOLDER CODE
    // --------------------------------------------------------
    public function search()
    {
        // Hindari error LIKE null
        $keyword = trim($this->request->getGet('q') ?? '');

        if ($keyword === '') {
            return view('access/search', [
                'results' => [],
                'keyword' => ''
            ]);
        }

        $data['results'] = $this->accessModel->searchByHolder($keyword);
        $data['keyword'] = $keyword;

        return view('access/search', $data);
    }

    // --------------------------------------------------------
    // LIST DOKUMEN USER
    // --------------------------------------------------------
    public function userDocuments($userId)
    {
        $data['dokumen'] = $this->accessModel->getByUser($userId);

        return view('user/documents', $data);
    }
}
