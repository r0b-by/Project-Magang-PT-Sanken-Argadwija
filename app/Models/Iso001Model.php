<?php

namespace App\Models;

use CodeIgniter\Model;

class Iso001Model extends Model
{
    protected $table = 'iso_001';
    protected $primaryKey = 'id';
    protected $useTimestamps = false; // Karena kita menyimpan sendiri uploaded_at / updated_at
    protected $allowedFields = [
        'iso00_id',
        'kode_dokumen',
        'departement',
        'nama_file',
        'upload_dokumen',
        'keterangan',
        'status',
        'uploaded_by',
        'uploader_name',
        'uploaded_at',
        'barcode',
    ];

    // Bisa ditambahkan relasi ke user uploader
    public function getUploader($id)
    {
        return $this->select('iso_001.*, users.fullname, users.role, users.foto')
                    ->join('users', 'users.id = iso_001.uploaded_by')
                    ->where('iso_001.id', $id)
                    ->first();
    }

    // Ambil semua revisi untuk dokumen tertentu
    public function getHistory($iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
