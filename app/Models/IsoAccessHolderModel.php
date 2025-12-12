<?php

namespace App\Models;

use CodeIgniter\Model;

class IsoAccessHolderModel extends Model
{
    protected $table            = 'iso_access_holders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'dokumen_id',
        'holder_code',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ----------------------------------------------------
    // GET: Ambil semua akses user terhadap dokumen
    // ----------------------------------------------------
    public function getByUser($userId)
    {
        return $this->select('iso_00.*, iso_access_holders.holder_code')
            ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id')
            ->where('iso_access_holders.user_id', $userId)
            ->orderBy('iso_00.kode_dokumen', 'ASC')
            ->findAll();
    }

    // ----------------------------------------------------
    // GET: Ambil semua user yang punya akses ke sebuah dokumen
    // ----------------------------------------------------
    public function getUsersByDokumen($dokumenId)
    {
        return $this->select('users.fullname, users.username, iso_access_holders.holder_code')
            ->join('users', 'users.id = iso_access_holders.user_id')
            ->where('iso_access_holders.dokumen_id', $dokumenId)
            ->orderBy('iso_access_holders.holder_code', 'ASC')
            ->findAll();
    }

    // ----------------------------------------------------
    // GET: Cari dokumen berdasarkan Holder Code
    // ----------------------------------------------------
    public function searchByHolder($keyword)
    {
        if (!$keyword || trim($keyword) === '') {
            return [];
        }

        return $this->select('iso_access_holders.*, users.fullname, users.username, iso_00.kode_dokumen')
            ->join('users', 'users.id = iso_access_holders.user_id')
            ->join('iso_00', 'iso_00.id = iso_access_holders.dokumen_id')
            ->like('holder_code', $keyword)
            ->orderBy('iso_access_holders.id', 'DESC')
            ->findAll();
    }

    // ----------------------------------------------------
    // Cek apakah akses sudah ada (hindari duplikasi)
    // ----------------------------------------------------
    public function exists($userId, $dokumenId)
    {
        return $this->where('user_id', $userId)
                    ->where('dokumen_id', $dokumenId)
                    ->first();
    }
}
