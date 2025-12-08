<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\Iso00Model;
use App\Models\Iso001Model;
use App\Models\ActivityLogModel;

class DashboardAdminController extends BaseController
{
    protected $user;
    protected $iso00;
    protected $iso001;
    protected $log;

    public function __construct()
    {
        $this->user   = new UserModel();
        $this->iso00  = new Iso00Model();
        $this->log    = new ActivityLogModel();
    }

    public function index()
    {
        // Ambil log dengan JOIN + PAGINATION
        $logQuery = $this->log
            ->select('activity_logs.*, users.fullname AS user_fullname, users.role AS user_role')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.id', 'DESC');

        $data = [
            'total_user'      => $this->user->countAll(),
            'total_dokumen'   => $this->iso00->countAll(),
            'dokumen_baru'    => $this->iso00->orderBy('id', 'DESC')->limit(6)->find(),
            'dept'            => $this->user->where('role', 'dept')->findAll(),

            // Hasil JOIN + pagination
            'log_terbaru'     => $logQuery->paginate(5, 'log'),
            'pager'           => $this->log->pager
        ];

        return view('dashboard/admin', $data);
    }
}
