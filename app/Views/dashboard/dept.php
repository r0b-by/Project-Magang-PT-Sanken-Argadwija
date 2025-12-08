<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard Departemen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Dashboard Departemen
        </h1>
        <div>
            <a href="/iso00/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Upload Dokumen
            </a>
        </div>
    </div>
    
    <!-- Welcome Card -->
    <div class="card bg-gradient-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-2">Selamat datang, <?= session()->get('fullname') ?>!</h4>
                    <p class="mb-0">Anda login sebagai <strong><?= ucfirst(session()->get('role')) ?></strong></p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-building fa-4x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                    <h3><?= count($dokumen_saya) ?></h3>
                    <p class="mb-0">Total Dokumen</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h3>3</h3>
                    <p class="mb-0">Menunggu Review</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Documents -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">Dokumen Saya</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($dokumen_saya)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada dokumen</p>
                            <a href="/iso00/create" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Upload Dokumen Pertama
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Kode Dokumen</th>
                                        <th>Departemen</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dokumen_saya as $doc): ?>
                                    <tr>
                                        <td>
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <?= $doc['kode_dokumen'] ?>
                                        </td>
                                        <td><?= $doc['departement'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= 
                                                $doc['status'] == 'approved' ? 'success' : 
                                                ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                                <?= ucfirst($doc['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($doc['uploaded_at'])) ?></td>
                                        <td>
                                            <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($log_saya)): ?>
                        <p class="text-muted text-center py-3">Belum ada aktivitas</p>
                    <?php else: ?>
                        <div class="list-group list-group-flush">

                            <?php foreach ($log_saya as $log): ?>
                            <?php
                                // ---- FIXED ICON DETECTION (tanpa activity_type) ----
                                $activity = strtolower($log['activity']);
                                if (str_contains($activity, 'login')) {
                                    $icon = 'sign-in-alt';
                                } elseif (str_contains($activity, 'upload')) {
                                    $icon = 'upload';
                                } elseif (str_contains($activity, 'scan')) {
                                    $icon = 'qrcode';
                                } else {
                                    $icon = 'edit';
                                }
                            ?>
                            
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-<?= $icon ?> text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1"><?= $log['activity'] ?></p>
                                        <small class="text-muted"><?= $log['created_at'] ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>  