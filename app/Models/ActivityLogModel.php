<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $allowedFields = [
        'user_id',
        'username',
        'fullname',
        'role',
        'activity',
        'ip_address',
        'created_at'
    ];
}
