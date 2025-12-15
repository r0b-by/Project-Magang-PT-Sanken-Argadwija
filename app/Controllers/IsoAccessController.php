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
        $data['access']  = $this->accessModel->findAll(); // semua akses existing

        return view('access/create', $data);
    }

    // --------------------------------------------------------
    // SIMPAN (Bisa multiple)
    // --------------------------------------------------------
    public function store()
    {
        $userIds     = $this->request->getPost('user_id');      // array
        $dokumenIds  = $this->request->getPost('dokumen_id');   // array
        $holderCodes = $this->request->getPost('holder_code');  // array

        if (!$userIds || !is_array($userIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu user.');
        }

        foreach ($userIds as $i => $userId) {
            $dokumenId  = $dokumenIds[$i] ?? null;
            $holderCode = strtoupper($holderCodes[$i] ?? null);

            if (!$dokumenId || !$holderCode) continue;

            // Cek duplikasi: user + dokumen
            $exists = $this->accessModel
                ->where('user_id', $userId)
                ->where('dokumen_id', $dokumenId)
                ->first();

            if (!$exists) {
                $this->accessModel->insert([
                    'user_id'     => $userId,
                    'dokumen_id'  => $dokumenId,
                    'holder_code' => $holderCode
                ]);
            }
        }

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
        $keyword = trim($this->request->getGet('q') ?? '');
        $data['results'] = $keyword ? $this->accessModel->searchByHolder($keyword) : [];
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
