<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
        </h1>
        <div>
            <span class="badge bg-primary">
                <i class="fas fa-calendar me-1"></i>
                <?= date('d F Y') ?>
            </span>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total User
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?= $total_user ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Dokumen
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?= $total_dokumen ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Total Scan
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Online Users
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                15
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-signal fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Distribution -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold">Distribusi User</h6>
                    <a href="/users" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-success"><?= count($dept) ?></h3>
                                    <p class="mb-0">Departemen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Documents -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold">Dokumen Terbaru</h6>
                    <a href="/iso00" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Departemen</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dokumen_baru as $doc): ?>
                                <tr>
                                    <td><?= $doc['kode_dokumen'] ?></td>
                                    <td><?= $doc['departement'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($doc['uploaded_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold">Aktivitas Terbaru</h6>
            <a href="/activity" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="timeline">
                <?php foreach ($log_terbaru as $log): ?>
                <div class="timeline-item mb-3">
                    <div class="timeline-marker bg-<?= 
                        $log['activity_type'] == 'login' ? 'success' : 
                        ($log['activity_type'] == 'upload' ? 'primary' : 
                        ($log['activity_type'] == 'scan' ? 'info' : 'warning')) ?>"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1"><?= $log['activity'] ?></h6>
                            <small class="text-muted"><?= $log['created_at'] ?></small>
                        </div>
                        <p class="text-muted mb-0">
                            <i class="fas fa-user me-1"></i>
                            <?= $log['fullname'] ?> (<?= $log['role'] ?>)
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -8px;
        top: 6px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #007bff;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 5px;
        border-left: 3px solid;
    }
</style>
<?= $this->endSection() ?>