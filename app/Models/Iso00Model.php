<?php

namespace App\Models;

use CodeIgniter\Model;

class Iso00Model extends Model
{
    protected $table            = 'iso_00';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = false; // kita pakai uploaded_at / updated_at manual

    protected $allowedFields = [
        'kode_internal',
        'kode_dept',
        'kode_running',
        'kode_dokumen',
        'departement',
        'nama_file',
        'upload_dokumen',
        'keterangan',
        'tanggal_efektif',
        'halaman',
        'ruang_lingkup',
        'tujuan',
        'holder',
        'status',
        'uploaded_by',
        'uploader_name',
        'uploader_role',
        'uploader_foto',
        'uploaded_at',
        'updated_by',
        'updated_at',
        'barcode'
    ];

    // Cari dokumen berdasarkan kode dokumen lengkap
    public function findByKode($kode)
    {
        return $this->where('kode_dokumen', $kode)->first();
    }

    // Ambil dokumen terbaru
    public function getRecentDocuments($limit = 50)
    {
        return $this->orderBy('uploaded_at', 'DESC')->findAll($limit);
    }

    // Update status dokumen
    public function updateStatus($id, $status)
    {
        return $this->update($id, [
            'status'      => $status,
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
