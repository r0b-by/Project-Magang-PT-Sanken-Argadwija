<?php

namespace App\Models;

use CodeIgniter\Model;

class Iso00Model extends Model
{
    protected $table      = 'iso_00';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType    = 'array';
    protected $useTimestamps = false; // kita pakai uploaded_at & updated_at manual

    protected $allowedFields = [
        'kode_dokumen',
        'departement',
        'nama_file',
        'upload_dokumen',
        'status',
        'tanggal_efektif',
        'halaman_dokumen',
        'ruang_lingkup',
        'tujuan',
        'uploaded_by',
        'uploader_name',
        'uploader_role',
        'uploader_foto',
        'uploaded_at',
        'updated_by',
        'updated_at',
        'barcode'
    ];

    // Fungsi tambahan: cari dokumen berdasarkan kode/barcode
    public function findByKode($kode)
    {
        return $this->where('kode_dokumen', $kode)->first();
    }

    // Fungsi tambahan: dokumen terbaru
    public function getRecentDocuments($limit = 50)
    {
        return $this->orderBy('uploaded_at', 'DESC')->findAll($limit);
    }

    // Optional: update status dokumen
    public function updateStatus($id, $status)
    {
        return $this->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    // Fungsi tambahan: cari dokumen berdasarkan departemen
    public function findByDepartement($departement)
    {
        return $this->where('departement', $departement)->orderBy('uploaded_at', 'DESC')->findAll();
    }

    // Fungsi tambahan: dokumen efektif pada tanggal tertentu
    public function findByTanggalEfektif($tanggal)
    {
        return $this->where('tanggal_efektif', $tanggal)->findAll();
    }
}
