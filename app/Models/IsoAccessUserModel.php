<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessUserModel extends Model
{
    protected $table      = 'iso_access_users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'holder_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    /* =====================================================
     * AMBIL DOKUMEN YANG BISA DIAKSES USER
     * ===================================================== */
    public function getDocumentsByUser(int $userId)
    {
        return $this->select('
                iso_00.id AS dokumen_id,
                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
                iso_access_holders.holder_code
            ')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->join('iso_access_documents', 'iso_access_documents.holder_id = iso_access_holders.id')
            ->join('iso_00', 'iso_00.id = iso_access_documents.iso00_id')
            ->where('iso_access_users.user_id', $userId)
            ->groupBy('iso_00.id')
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();
    }

    /* =====================================================
     * CEK APAKAH USER PUNYA AKSES KE DOKUMEN
     * ===================================================== */
    public function userHasAccessToDocument(int $userId, int $dokumenId): bool
    {
        return $this->join(
                'iso_access_documents',
                'iso_access_documents.holder_id = iso_access_users.holder_id'
            )
            ->where('iso_access_users.user_id', $userId)
            ->where('iso_access_documents.iso00_id', $dokumenId)
            ->countAllResults() > 0;
    }

    /* =====================================================
     * ALIAS
     * ===================================================== */
    public function userHasAccess(int $userId, int $dokumenId): bool
    {
        return $this->userHasAccessToDocument($userId, $dokumenId);
    }

    /* =====================================================
     * AMBIL USER DALAM HOLDER
     * ===================================================== */
    public function getUsersByHolder(int $holderId)
    {
        return $this->select('
                iso_access_users.id AS access_id,
                users.id AS user_id,
                users.fullname,
                users.username
            ')
            ->join('users', 'users.id = iso_access_users.user_id')
            ->where('iso_access_users.holder_id', $holderId)
            ->orderBy('users.fullname', 'ASC')
            ->findAll();
    }

    /* =====================================================
     * ASSIGN USER KE HOLDER (ANTI DUPLIKAT)
     * ===================================================== */
    public function assignUserToHolder(int $holderId, int $userId)
    {
        if (!$this->where('holder_id', $holderId)->where('user_id', $userId)->first()) {
            return $this->insert([
                'holder_id' => $holderId,
                'user_id'   => $userId,
            ]);
        }

        return false;
    }
}
