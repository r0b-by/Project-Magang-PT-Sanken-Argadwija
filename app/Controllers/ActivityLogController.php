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

    // Menampilkan semua log
    public function index()
    {
        $data['logs'] = $this->log
            ->select('activity_logs.*, users.username')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll();

        return view('activity_log/index', $data);
    }

    // Log milik user tertentu
    public function userLog($id)
    {
        $data['logs'] = $this->log
            ->select('activity_logs.*, users.username')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->where('user_id', $id)
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll();

        return view('activity_log/user', $data);
    }
}
