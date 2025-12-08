<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\UserModel;

class ActivityLogController extends BaseController
{
    protected $log;
    protected $userModel;

    public function __construct()
    {
        $this->log = new ActivityLogModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ambil parameter filter dari request
        $request = service('request');
        $startDate = $request->getGet('start_date');
        $endDate = $request->getGet('end_date');
        $userId = $request->getGet('user_id');
        $activityType = $request->getGet('activity_type');
        
        // Build query
        $builder = $this->log
            ->select('activity_logs.*, users.fullname, users.foto, users.role')
            ->join('users', 'users.id = activity_logs.user_id', 'left');
        
        // Apply filters
        if ($startDate) {
            $builder->where('DATE(activity_logs.created_at) >=', $startDate);
        }
        
        if ($endDate) {
            $builder->where('DATE(activity_logs.created_at) <=', $endDate);
        }
        
        if ($userId) {
            $builder->where('activity_logs.user_id', $userId);
        }
        
        // Filter berdasarkan teks dalam kolom 'activity'
        if ($activityType && $activityType !== '') {
            $builder->like('activity_logs.activity', $activityType);
        }
        
        // Order and paginate
        $perPage = 20;
        $data['logs'] = $builder->orderBy('activity_logs.id', 'DESC')->paginate($perPage);
        $data['pager'] = $this->log->pager;
        
        // Get all users for dropdown
        $data['users'] = $this->userModel->orderBy('fullname', 'ASC')->findAll();
        
        // Send filter values to view
        $data['filters'] = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
            'activity_type' => $activityType
        ];
        
        // Stats data
        $data['total_logs'] = $this->log->countAll();
        $data['today_logs'] = $this->log->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
        
        // Hitung berdasarkan teks dalam kolom 'activity'
        $data['login_count'] = $this->log->like('activity', 'login')->countAllResults();
        $data['upload_count'] = $this->log->like('activity', 'upload')->orLike('activity', 'unggah')->countAllResults();
        $data['error_count'] = $this->log->like('activity', 'error')->orLike('activity', 'gagal')->countAllResults();
        $data['edit_count'] = $this->log->like('activity', 'edit')->orLike('activity', 'ubah')->countAllResults();
        $data['delete_count'] = $this->log->like('activity', 'delete')->orLike('activity', 'hapus')->countAllResults();
        
        // Get unique users count
        $data['unique_users'] = $this->log->select('COUNT(DISTINCT user_id) as count')->first()['count'] ?? 0;
        
        // Activity chart data (last 30 days)
        $data['activity_chart'] = $this->getActivityChartData();
        
        return view('activity_log/index', $data);
    }
    
    private function getActivityChartData()
    {
        $chartData = [];
        $today = date('Y-m-d');
        
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days", strtotime($today)));
            $count = $this->log->where('DATE(created_at)', $date)->countAllResults();
            $chartData[$date] = $count;
        }
        
        return $chartData;
    }
    
    public function clearOld()
    {
        // Clear logs older than 90 days
        $ninetyDaysAgo = date('Y-m-d', strtotime('-90 days'));
        $this->log->where('DATE(created_at) <', $ninetyDaysAgo)->delete();
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Log berusia lebih dari 90 hari telah dihapus'
        ]);
    }
    
    public function export()
    {
        // Ambil semua log
        $logs = $this->log
            ->select('activity_logs.*, users.fullname, users.role')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.id', 'DESC')
            ->findAll();
        
        // Header CSV
        $csvData = "No,User,Role,Aktifitas,IP Address,Waktu\n";
        
        $no = 1;
        foreach ($logs as $log) {
            $csvData .= $no++ . ",";
            $csvData .= '"' . str_replace('"', '""', $log['fullname'] ?? 'System') . '",';
            $csvData .= '"' . str_replace('"', '""', $log['role'] ?? 'System') . '",';
            $csvData .= '"' . str_replace('"', '""', $log['activity']) . '",';
            $csvData .= '"' . str_replace('"', '""', $log['ip_address'] ?? '') . '",';
            $csvData .= '"' . date('d/m/Y H:i:s', strtotime($log['created_at'])) . '"';
            $csvData .= "\n";
        }
        
        // Download file
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"')
            ->setBody($csvData);
    }
}