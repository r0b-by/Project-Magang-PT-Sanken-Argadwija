<?php namespace App\Models;

use CodeIgniter\Model;

class Iso001Model extends Model
{
    protected $table      = 'iso_001';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // History → INSERT ONLY
    protected $useTimestamps = true;
    protected $createdField  = 'uploaded_at'; // 🔹 sesuaikan dengan migrasi
    protected $updatedField  = ''; // ❗ history tidak pernah diupdate

    protected $allowedFields = [
        'iso00_id',
        'versi',
        'revision_note',

        // snapshot dari iso_00
        'kode_dokumen',
        'nama_dokumen_internal',
        'nama_file',
        'file_path',
        'file_size',
        'mime_type',
        'tanggal_efektif',
        'halaman_dokumen',
        'ruang_lingkup',
        'tujuan',
        'status',

        // user snapshot
        'uploaded_by',
        'uploader_name',
        'uploader_role',
    ];

    /* =====================================================
     * BUSINESS LOGIC
     * ===================================================*/

    /**
     * Tambah revisi (snapshot dari iso_00)
     */
    public function addRevision(array $master, array $extra = [])
    {
        $last = $this->where('iso00_id', $master['id'])
                     ->orderBy('id', 'DESC')
                     ->first();

        $nextVersion = 'Rev-1';
        if ($last) {
            $num = (int) str_replace('Rev-', '', $last['versi']);
            $nextVersion = 'Rev-' . ($num + 1);
        }

        $data = [
            'iso00_id' => $master['id'],
            'versi'    => $nextVersion,

            // snapshot dokumen
            'kode_dokumen' => $master['kode_dokumen'],
            'nama_dokumen_internal' => $master['nama_dokumen_internal'],
            'nama_file' => $master['nama_file'],
            'file_path' => $master['file_path'],
            'file_size' => $master['file_size'],
            'mime_type' => $master['mime_type'],
            'tanggal_efektif' => $master['tanggal_efektif'],
            'halaman_dokumen' => $master['halaman_dokumen'],
            'ruang_lingkup' => $master['ruang_lingkup'],
            'tujuan' => $master['tujuan'],
            'status' => 'revisi',

            // snapshot user
            'uploaded_by' => session()->get('user_id'),
            'uploader_name' => session()->get('fullname'),
            'uploader_role' => session()->get('role'),
        ];

        $data = array_merge($data, $extra);

        return $this->insert($data);
    }

    /**
     * Ambil semua history satu dokumen
     */
    public function getRevisionsByMaster(int $iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil 1 revisi spesifik
     */
    public function getRevision(int $id)
    {
        return $this->find($id);
    }
}
