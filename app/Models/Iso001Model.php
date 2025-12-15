<?php

namespace App\Models;

use CodeIgniter\Model;

class Iso001Model extends Model
{
    protected $table            = 'iso_001';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType    = 'array';
    protected $useTimestamps = false; // pakai uploaded_at manual

    protected $allowedFields = [
        'iso00_id',
        'versi',
        'nama_file',
        'upload_dokumen',
        'keterangan',
        'status',
        'uploaded_by',
        'uploader_name',
        'uploader_role',
        'uploaded_at',
        'barcode',
    ];

    /* =========================================================
     * RELASI & QUERY TAMBAHAN
     * ========================================================= */

    /**
     * Ambil satu data revisi + data dokumen master (iso_00)
     */
    public function getDetailWithMaster($id)
    {
        return $this->select('
                iso_001.*,
                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
                iso_00.tanggal_efektif,
                iso_00.status AS status_master
            ')
            ->join('iso_00', 'iso_00.id = iso_001.iso00_id')
            ->where('iso_001.id', $id)
            ->first();
    }

    /**
     * Ambil histori revisi berdasarkan dokumen master
     */
    public function getHistoryByIso00($iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil revisi terbaru dari satu dokumen
     */
    public function getLatestRevision($iso00_id)
    {
        return $this->where('iso00_id', $iso00_id)
                    ->orderBy('uploaded_at', 'DESC')
                    ->first();
    }

    /**
     * Ambil data revisi + info uploader (users)
     */
    public function getWithUploader($id)
    {
        return $this->select('
                iso_001.*,
                users.fullname,
                users.role,
                users.foto
            ')
            ->join('users', 'users.id = iso_001.uploaded_by')
            ->where('iso_001.id', $id)
            ->first();
    }

    /**
     * Ambil semua revisi berdasarkan status (draft/approved/rejected)
     */
    public function getByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }

    /**
     * Simpan revisi baru (helper)
     */
    public function saveRevision(array $data)
    {
        $data['uploaded_at'] = $data['uploaded_at'] ?? date('Y-m-d H:i:s');
        return $this->insert($data);
    }
}
