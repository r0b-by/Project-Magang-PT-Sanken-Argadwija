<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\UserModel;

class ActivityLogController extends BaseController
{
    protected $log;
    protected $user;

    public function __construct()
    {
        $this->log  = new ActivityLogModel();
        $this->user = new UserModel();
    }

    // ===================================================
    // SEMUA LOG LOGIN / LOGOUT
    // ===================================================
    public function index()
    {
        $data['logs'] = $this->log
            ->select('
                activity_logs.activity,
                activity_logs.ip_address,
                activity_logs.created_at,
                users.username,
                users.fullname,
                users.role,
                users.is_online,
                users.last_active_at
            ')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->whereIn('activity_logs.activity', ['login', 'logout'])
            ->orderBy('activity_logs.created_at', 'DESC')
            ->findAll();

        return view('activity_log/index', $data);
    }

    // ===================================================
    // LOG LOGIN / LOGOUT USER TERTENTU
    // ===================================================
    public function userLog($userId)
    {
        $data['logs'] = $this->log
            ->select('
                activity_logs.activity,
                activity_logs.ip_address,
                activity_logs.created_at,
                users.username,
                users.fullname,
                users.role,
                users.is_online,
                users.last_active_at
            ')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->where('activity_logs.user_id', $userId)
            ->whereIn('activity_logs.activity', ['login', 'logout'])
            ->orderBy('activity_logs.created_at', 'DESC')
            ->findAll();

        return view('activity_log/user', $data);
    }

    // ===================================================
    // AUTO DELETE LOG > 7 HARI
    // ===================================================
    public function clearOldLogs()
    {
        $this->log
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->delete();

        return true;
    }
}
