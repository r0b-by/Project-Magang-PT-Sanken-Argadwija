<?php namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table      = 'departments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'kode_dept',
        'nama_dept',
        'status',       // ditambahkan
        'created_at',   // timestamps
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /* =======================
     |     QUERY SIAP PAKAI
     ======================= */

    /**
     * Ambil semua departemen (aktif & nonaktif)
     */
    public function getAll()
    {
        return $this->orderBy('kode_dept', 'ASC')->findAll();
    }

    /**
     * Ambil semua departemen aktif
     */
    public function getActive()
    {
        return $this->where('status', 'active')
                    ->orderBy('kode_dept', 'ASC')
                    ->findAll();
    }

    /**
     * Ambil dept berdasarkan kode
     */
    public function getByKode(string $kode)
    {
        return $this->where('kode_dept', $kode)->first();
    }

    /**
     * Ambil dept berdasarkan ID
     */
    public function getById(int $id)
    {
        return $this->find($id);
    }

    /**
     * Cek apakah kode dept valid
     */
    public function isValidKode(string $kode): bool
    {
        return $this->where('kode_dept', $kode)->countAllResults() > 0;
    }

    /**
     * Update status departemen
     */
    public function setStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return false;
        }
        return $this->update($id, ['status' => $status]);
    }
}
