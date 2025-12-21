<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessHolderModel extends Model
{
    protected $table      = 'iso_access_holders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'holder_code',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    /* =====================================================
     * AMBIL SEMUA HOLDER + TOTAL USER + TOTAL DOKUMEN
     * ===================================================== */
    public function getAllHolders()
    {
        return $this->select('
                iso_access_holders.id,
                iso_access_holders.holder_code,
                COUNT(DISTINCT iso_access_users.id) AS total_users,
                COUNT(DISTINCT iso_access_documents.iso00_id) AS total_dokumen
            ')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id', 'left')
            ->join('iso_access_documents', 'iso_access_documents.holder_id = iso_access_holders.id', 'left')
            ->groupBy('iso_access_holders.id')
            ->orderBy('iso_access_holders.holder_code', 'ASC')
            ->findAll();
    }

    /* =====================================================
     * AMBIL HOLDER BESERTA USER BERDASARKAN DOKUMEN
     * ===================================================== */
    public function getHolderWithUsersByDokumen(int $docId)
    {
        return $this->select('
                iso_access_holders.id AS holder_id,
                iso_access_holders.holder_code,
                users.id AS user_id,
                users.fullname
            ')
            ->join('iso_access_documents', 'iso_access_documents.holder_id = iso_access_holders.id')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id', 'left')
            ->join('users', 'users.id = iso_access_users.user_id', 'left')
            ->where('iso_access_documents.iso00_id', $docId)
            ->orderBy('users.fullname', 'ASC')
            ->findAll();
    }

    /* =====================================================
     * AMBIL HOLDER BERDASARKAN KODE
     * ===================================================== */
    public function getByHolderCode(string $holderCode)
    {
        return $this->where('holder_code', $holderCode)->first();
    }

    /* =====================================================
     * AMBIL USER YANG TERDAFTAR DI HOLDER
     * ===================================================== */
    public function getUsersByHolder(int $holderId)
    {
        return $this->db->table('iso_access_users')
            ->select('users.id, users.fullname, users.username, users.email')
            ->join('users', 'users.id = iso_access_users.user_id')
            ->where('iso_access_users.holder_id', $holderId)
            ->orderBy('users.fullname', 'ASC')
            ->get()
            ->getResultArray();
    }

    /* =====================================================
     * AMBIL DOKUMEN MILIK HOLDER
     * ===================================================== */
    public function getDokumenByHolder(int $holderId)
    {
        return $this->db->table('iso_access_documents')
            ->select('iso_00.id, iso_00.kode_dokumen, iso_00.nama_dokumen_internal')
            ->join('iso_00', 'iso_00.id = iso_access_documents.iso00_id')
            ->where('iso_access_documents.holder_id', $holderId)
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->get()
            ->getResultArray();
    }

    /* =====================================================
     * CEK APAKAH DOKUMEN SUDAH DIPAKAI HOLDER LAIN
     * ===================================================== */
    public function isDokumenUsed(int $dokumenId, ?int $excludeHolderId = null): bool
    {
        $builder = $this->db->table('iso_access_documents')
            ->where('iso00_id', $dokumenId);

        if ($excludeHolderId !== null) {
            $builder->where('holder_id !=', $excludeHolderId);
        }

        return $builder->countAllResults() > 0;
    }
}
