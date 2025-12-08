<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table      = 'activity_logs';  // sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'activity',
        'ip_address',
        'created_at'
    ];

    protected $useTimestamps = true;
}
