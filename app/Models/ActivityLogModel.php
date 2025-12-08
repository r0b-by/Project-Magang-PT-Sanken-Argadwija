<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';   // <-- WAJIB pakai S (sesuai migration)
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'activity',
        'ip_address',
        'created_at',
        'updated_at'
    ];
}
