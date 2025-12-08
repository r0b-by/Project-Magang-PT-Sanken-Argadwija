<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'iso_00';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode_dokumen',
        'tanggal_upload',
        'departement',
        'nama_file',
        'keterangan',
        'status',
        'user_update',
        'jam_update',
        'tanggal_update'
    ];

    // Get list unique departements
    public function getDepartements()
    {
        return $this->select('DISTINCT departement')->findAll();
    }
}
