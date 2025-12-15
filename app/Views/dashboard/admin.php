<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-lg-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-semibold text-dark">
            <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
        </h1>
        <span class="badge rounded-pill bg-light text-dark border d-none d-sm-inline px-3 py-2">
            <i class="far fa-calendar-alt me-1"></i><?= date('d M Y') ?>
        </span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small mb-1">Total User</p>
                            <h4 class="mb-0 fw-bold text-dark"><?= $total_user ?></h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users fa-lg text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small mb-1">Total Dokumen</p>
                            <h4 class="mb-0 fw-bold text-dark"><?= $total_dokumen ?></h4>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-file-alt fa-lg text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-3">
        <!-- Left Column -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Aktivitas Terbaru</h6>
                        <a href="/activity" class="btn btn-sm btn-light rounded-pill px-3">
                            Lihat Semua <i class="fas fa-arrow-right ms-1 small"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($log_terbaru)): ?>
                            <?php foreach ($log_terbaru as $log): ?>
                                <div class="list-group-item border-0 px-3 py-3 hover-bg-light">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <?php
                                            $icon = 'edit';
                                            $color = 'secondary';
                                            if (str_contains(strtolower($log['activity']), 'login')) {
                                                $icon = 'sign-in-alt';
                                                $color = 'success';
                                            } elseif (str_contains(strtolower($log['activity']), 'upload')) {
                                                $icon = 'upload';
                                                $color = 'primary';
                                            } elseif (str_contains(strtolower($log['activity']), 'scan')) {
                                                $icon = 'qrcode';
                                                $color = 'info';
                                            }
                                            ?>
                                            <div class="bg-<?= $color ?> bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-<?= $icon ?> text-<?= $color ?>"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 text-dark"><?= esc($log['activity']) ?></p>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-user me-1"></i><?= esc($log['fullname']) ?> • 
                                                <i class="far fa-clock ms-2 me-1"></i><?= date('d/m/y H:i', strtotime($log['created_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada aktivitas</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <div class="row g-3">
                <!-- User Stats -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Distribusi User</h6>
                                <a href="/users" class="btn btn-sm btn-light rounded-pill px-3">
                                    Lihat <i class="fas fa-arrow-right ms-1 small"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center py-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1"><?= $total_user ?></h2>
                            <p class="text-muted small mb-0">Total User Aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Documents -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Dokumen Terbaru</h6>
                                <a href="/iso00" class="btn btn-sm btn-light rounded-pill px-3">
                                    Lihat <i class="fas fa-arrow-right ms-1 small"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr class="border-bottom">
                                            <th class="ps-3 py-2 text-muted fw-normal small">Kode</th>
                                            <th class="py-2 text-muted fw-normal small">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($dokumen_baru)): ?>
                                            <?php foreach ($dokumen_baru as $doc): ?>
                                                <tr class="border-bottom">
                                                    <td class="ps-3 py-2 text-dark"><?= esc($doc['kode_dokumen']) ?></td>
                                                    <td class="py-2 text-muted small"><?= date('d/m/y', strtotime($doc['uploaded_at'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2" class="text-center py-4">
                                                    <i class="fas fa-file-alt fa-2x text-muted mb-2 d-block"></i>
                                                    <p class="text-muted small mb-0">Tidak ada dokumen</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-bg-light:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}

.btn-light {
    border: 1px solid #e9ecef;
}

.btn-light:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}
</style>
<?= $this->endSection() ?>