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

    /**
     * Ambil dokumen user via join dengan iso_access_holders & iso_00
     */
    public function getDocumentsByUser(int $userId)
    {
        return $this->select('
                iso_00.id AS dokumen_id,
                iso_00.kode_dokumen,
                iso_00.nama_dokumen_internal,
                iso_access_holders.holder_code
            ')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id', 'left')
            ->where('iso_access_users.user_id', $userId)
            ->orderBy('iso_00.id', 'DESC')
            ->findAll();
    }

    /**
     * Cek apakah user punya akses ke dokumen tertentu
     */
    public function userHasAccessToDocument(int $userId, int $dokumenId): bool
    {
        $access = $this->select('iso_access_users.id')
            ->join('iso_access_holders', 'iso_access_holders.id = iso_access_users.holder_id')
            ->where('iso_access_users.user_id', $userId)
            ->where('iso_access_holders.dokumen_id', $dokumenId)
            ->first();

        return $access ? true : false;
    }

    /**
     * Alias supaya bisa dipanggil dengan nama userHasAccess
     */
    public function userHasAccess(int $userId, int $dokumenId): bool
    {
        return $this->userHasAccessToDocument($userId, $dokumenId);
    }

    /**
     * Ambil user berdasarkan holder (untuk detail holder)
     */
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

    /**
     * Assign user ke holder tanpa duplikat
     */
    public function assignUserToHolder(int $holderId, int $userId)
    {
        if (!$this->where('holder_id', $holderId)->where('user_id', $userId)->first()) {
            return $this->insert([
                'holder_id' => $holderId,
                'user_id'   => $userId
            ]);
        }

        // Sudah ada akses, tidak perlu insert
        return false;
    }
}
