<?php

namespace App\Controllers;

use App\Models\Iso00Model;
use App\Models\IsoAccessHolderModel;
use App\Models\ActivityLogModel;

class DashboardDeptController extends BaseController
{
    protected $iso00;
    protected $holder;
    protected $log;

    public function __construct()
    {
        $this->iso00  = new Iso00Model();
        $this->holder = new IsoAccessHolderModel();
        $this->log    = new ActivityLogModel();
    }

    public function index()
    {
        $deptID = session()->get('user_id');

        // Ambil dokumen yang dept punya akses
        $access = $this->holder->where('user_id', $deptID)->findAll();
        $docIds = array_column($access, 'dokumen_id');

        $dokumen_saya = [];
        if (!empty($docIds)) {
            $dokumen_saya = $this->iso00
                ->whereIn('id', $docIds)
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // Ambil log terbaru
        $log_saya = $this->log
            ->where('user_id', $deptID)
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->findAll();

        return view('dashboard/dept', [
            'dokumen_saya' => $dokumen_saya,
            'log_saya'     => $log_saya,
        ]);
    }
}
