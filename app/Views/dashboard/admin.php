<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
        <span class="badge bg-primary d-none d-sm-inline">
            <?= date('d/m/Y') ?>
        </span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-start border-primary">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-muted">Total User</div>
                            <div class="h5 mb-0 fw-bold"><?= $total_user ?></div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-start border-success">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-muted">Total Dokumen</div>
                            <div class="h5 mb-0 fw-bold"><?= $total_dokumen ?></div>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-file-alt text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-2 g-md-3">
        <!-- User Stats -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Distribusi User</h6>
                    <a href="/users" class="btn btn-sm btn-primary">Lihat</a>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="bg-light rounded p-2 text-center">
                                <div class="h4 text-primary mb-1"><?= $total_user ?></div>
                                <div class="small text-muted">Total User</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Dokumen Terbaru</h6>
                    <a href="/iso00" class="btn btn-sm btn-primary">Lihat</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Kode</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dokumen_baru)): ?>
                                    <?php foreach ($dokumen_baru as $doc): ?>
                                        <tr>
                                            <td class="ps-3"><?= esc($doc['kode_dokumen']) ?></td>
                                            <td><?= date('d/m/y', strtotime($doc['uploaded_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">
                                            Tidak ada dokumen
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

    <!-- Recent Activity -->
    <div class="card mt-3">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Aktivitas Terbaru</h6>
            <a href="/activity" class="btn btn-sm btn-primary">Lihat</a>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php if (!empty($log_terbaru)): ?>
                    <?php foreach ($log_terbaru as $log): ?>
                        <div class="list-group-item border-0 px-3 py-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <?php
                                    $icon = 'edit';
                                    $color = 'text-muted';
                                    if (str_contains(strtolower($log['activity']), 'login')) {
                                        $icon = 'sign-in-alt';
                                        $color = 'text-success';
                                    } elseif (str_contains(strtolower($log['activity']), 'upload')) {
                                        $icon = 'upload';
                                        $color = 'text-primary';
                                    } elseif (str_contains(strtolower($log['activity']), 'scan')) {
                                        $icon = 'qrcode';
                                        $color = 'text-info';
                                    }
                                    ?>
                                    <i class="fas fa-<?= $icon ?> <?= $color ?>"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small"><?= esc($log['activity']) ?></div>
                                    <div class="text-muted smaller">
                                        <?= esc($log['fullname']) ?> • 
                                        <?= date('d/m/y H:i', strtotime($log['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-3">
                        <p class="text-muted small mb-0">Belum ada aktivitas</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
