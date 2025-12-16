<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessHolderModel extends Model
{
    protected $table      = 'iso_access_holders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'holder_code',
        'dokumen_id',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    /**
     * Ambil semua holder + dokumen + total user
     */
    public function getAllHolders()
    {
        return $this->select('
                iso_access_holders.id,
                iso_access_holders.holder_code,
                iso_00.kode_dokumen,
                COUNT(iso_access_users.id) AS total_users
            ')
            ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id', 'left')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id', 'left')
            ->groupBy('iso_access_holders.id')
            ->orderBy('iso_access_holders.holder_code', 'ASC')
            ->findAll();
    }

    public function getByHolderCode(string $holderCode)
    {
        return $this->select('
                    iso_access_holders.*,
                    iso_00.kode_dokumen,
                    iso_00.nama_dokumen_internal
                ')
                ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id', 'left')
                ->where('iso_access_holders.holder_code', $holderCode)
                ->first();
    }

    /**
     * Validasi dokumen hanya boleh 1 holder
     */
    public function isDokumenUsed($dokumenId, $currentHolderId = null)
    {
        $builder = $this->where('dokumen_id', $dokumenId);

        if ($currentHolderId) {
            $builder->where('id !=', $currentHolderId);
        }

        return $builder->countAllResults() > 0;
    }
    
    public function getHolderWithUsersByDokumen(int $dokumenId)
    {
        return $this->select('
                iso_access_holders.id AS holder_id,
                iso_access_holders.holder_code,
                users.id AS user_id,
                users.fullname
            ')
            ->join('iso_access_users', 'iso_access_users.holder_id = iso_access_holders.id', 'left')
            ->join('users', 'users.id = iso_access_users.user_id', 'left')
            ->where('iso_access_holders.dokumen_id', $dokumenId)
            ->orderBy('users.fullname', 'ASC')
            ->findAll();
    }

}
