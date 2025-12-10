<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard Departemen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Dashboard
        </h1>
        <a href="/iso00/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Upload
        </a>
    </div>
    
    <!-- Welcome -->
    <div class="card bg-primary text-white mb-3">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="h6 mb-1">Halo, <?= session()->get('fullname') ?>!</div>
                    <div class="small opacity-75">
                        Role: <?= ucfirst(session()->get('role')) ?>
                    </div>
                </div>
                <div class="ms-2">
                    <i class="fas fa-user-circle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="row g-2 mb-3">
        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body p-2 text-center">
                    <i class="fas fa-file-alt text-primary mb-1"></i>
                    <div class="h5 mb-0"><?= count($dokumen_saya) ?></div>
                    <div class="small text-muted">Dokumen</div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body p-2 text-center">
                    <i class="fas fa-check-circle text-success mb-1"></i>
                    <div class="h5 mb-0">12</div>
                    <div class="small text-muted">Terverifikasi</div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body p-2 text-center">
                    <i class="fas fa-clock text-warning mb-1"></i>
                    <div class="h5 mb-0">3</div>
                    <div class="small text-muted">Review</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- My Documents -->
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0 fw-bold">Dokumen Saya</h6>
        </div>
        <div class="card-body p-0">
            <?php if (empty($dokumen_saya)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-folder-open text-muted mb-2"></i>
                    <p class="text-muted small mb-3">Belum ada dokumen</p>
                    <a href="/iso00/create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Upload Pertama
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="ps-3">#</th>
                                <th>Kode</th>
                                <th class="d-none d-sm-table-cell">Status</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen_saya as $doc): ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>
                                <td>
                                    <div>
                                        <i class="fas fa-file-pdf text-danger me-1"></i>
                                        <?= $doc['kode_dokumen'] ?>
                                    </div>
                                    <div class="text-muted small d-block d-sm-none">
                                        <?= $doc['departement'] ?>
                                        <span class="mx-1">•</span>
                                        <span class="badge bg-<?= 
                                            $doc['status'] == 'approved' ? 'success' : 
                                            ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                            <?= $doc['status'] == 'approved' ? '✓' : 
                                               ($doc['status'] == 'pending' ? '⏳' : '📄') ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="badge bg-<?= 
                                        $doc['status'] == 'approved' ? 'success' : 
                                        ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                        <?= ucfirst($doc['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/barcode/detail/<?= $doc['id'] ?>" 
                                           class="btn btn-outline-info"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                           class="btn btn-outline-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header py-2">
            <h6 class="mb-0 fw-bold">Aktivitas Terbaru</h6>
        </div>
        <div class="card-body p-0">
            <?php if (empty($log_saya)): ?>
                <div class="text-center py-4">
                    <p class="text-muted small">Belum ada aktivitas</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($log_saya as $log): ?>
                    <div class="list-group-item border-0 px-3 py-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <?php
                                $activity = strtolower($log['activity']);
                                if (str_contains($activity, 'login')) {
                                    $icon = 'sign-in-alt';
                                    $color = 'text-success';
                                } elseif (str_contains($activity, 'upload')) {
                                    $icon = 'upload';
                                    $color = 'text-primary';
                                } elseif (str_contains($activity, 'scan')) {
                                    $icon = 'qrcode';
                                    $color = 'text-info';
                                } else {
                                    $icon = 'edit';
                                    $color = 'text-warning';
                                }
                                ?>
                                <i class="fas fa-<?= $icon ?> <?= $color ?>"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="small"><?= $log['activity'] ?></div>
                                <div class="text-muted smaller">
                                    <?= date('d/m/y H:i', strtotime($log['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>