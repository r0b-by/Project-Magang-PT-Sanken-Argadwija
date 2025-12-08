<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class ActivityLogController extends BaseController
{
    protected $log;

    public function __construct()
    {
        $this->log = new ActivityLogModel();
    }

    // ============================================
    // LIST ALL ACTIVITY LOG
    // ============================================
    public function index()
    {
        $logs = $this->log
            ->select('activity_logs.*, users.fullname AS user_fullname, users.role AS user_role')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll();

        // Fallback jika user sudah dihapus
        foreach ($logs as &$log) {
            $log['user_fullname'] = $log['user_fullname'] ?: 'Unknown User';
            $log['user_role']     = $log['user_role'] ?: '-';
        }

        return view('activity_log/index', [
            'logs' => $logs
        ]);
    }

    // ============================================
    // LIST LOG BY USER
    // ============================================
    public function userLog($id)
    {
        $logs = $this->log
            ->select('activity_logs.*, users.fullname AS user_fullname, users.role AS user_role')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->where('activity_logs.user_id', $id)
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll();

        // fallback tetap diperlukan
        foreach ($logs as &$log) {
            $log['user_fullname'] = $log['user_fullname'] ?: 'Unknown User';
            $log['user_role']     = $log['user_role'] ?: '-';
        }

        return view('activity_log/user_log', [
            'logs' => $logs
        ]);
    }
}
