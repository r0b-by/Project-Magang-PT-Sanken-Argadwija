<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\ActivityLogModel;

class DashboardDeptController extends BaseController
{
    protected $iso00;
    protected $log;

    public function __construct()
    {
        $this->iso00 = new Iso00Model();
        $this->log   = new ActivityLogModel();
    }

    public function index()
    {
        $deptID = session()->get('user_id');

        $data = [
            'dokumen_saya' => $this->iso00
                ->where('uploaded_by', $deptID)
                ->orderBy('id', 'DESC')
                ->findAll(),

            'log_saya' => $this->log
                ->where('user_id', $deptID)
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->find(),
        ];

        return view('dashboard/dept', $data);
    }
}
