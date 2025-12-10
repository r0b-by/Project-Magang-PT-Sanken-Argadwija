<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Activity Log User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>Aktivitas User
        </h1>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">#</th>
                            <th>Aktivitas</th>
                            <th width="90">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($logs)): ?>
                            <?php $no = 1; foreach ($logs as $row): ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($row['activity']) ?></div>
                                    <div class="text-muted small">
                                        <?= esc($row['ip_address'] ?? '-') ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <?= date('d/m/y', strtotime($row['created_at'])) ?>
                                    </div>
                                    <div class="text-muted smaller">
                                        <?= date('H:i', strtotime($row['created_at'])) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada aktivitas
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if(!empty($logs) && count($logs) > 10): ?>
        <div class="card-footer py-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total: <?= count($logs) ?> aktivitas</span>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>