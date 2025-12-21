<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessDocumentModel extends Model
{
    protected $table      = 'iso_access_documents';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'holder_id',
        'iso00_id',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = null;

    /* =====================================
     * AMBIL DOKUMEN BERDASARKAN HOLDER
     * (PASTI SATU DATA)
     * ===================================== */
    public function getDokumenByHolder(int $holderId): ?array
    {
        return $this->select([
                'iso_00.id AS iso00_id',
                'iso_00.kode_dokumen',
                'iso_00.nama_dokumen_internal'
            ])
            ->join('iso_00', 'iso_00.id = iso_access_documents.iso00_id')
            ->where('iso_access_documents.holder_id', $holderId)
            ->first();
    }

    /* =====================================
     * AMBIL HOLDER BERDASARKAN DOKUMEN
     * ===================================== */
    public function getHolderByDokumen(int $iso00Id): ?array
    {
        return $this->where('iso00_id', $iso00Id)->first();
    }

    /* =====================================
     * ASSIGN 1 DOKUMEN KE 1 HOLDER
     * (REPLACE, AMAN UNIQUE)
     * ===================================== */
    public function assignDocumentToHolder(int $holderId, int $iso00Id): bool
    {
        $this->db->transStart();

        // hapus relasi lama (1 holder = 1 dokumen)
        $this->where('holder_id', $holderId)->delete();

        // insert baru
        $this->insert([
            'holder_id' => $holderId,
            'iso00_id'  => $iso00Id,
        ]);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /* =====================================
     * VALIDASI: CEK HOLDER SUDAH DIPAKAI?
     * ===================================== */
    public function holderAlreadyUsed(int $holderId): bool
    {
        return $this->where('holder_id', $holderId)->countAllResults() > 0;
    }

    /* =====================================
     * VALIDASI: CEK DOKUMEN SUDAH ADA HOLDER?
     * ===================================== */
    public function dokumenAlreadyHasHolder(int $iso00Id): bool
    {
        return $this->where('iso00_id', $iso00Id)->countAllResults() > 0;
    }
}
