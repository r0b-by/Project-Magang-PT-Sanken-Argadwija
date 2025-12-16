<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Activity Log User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-user-clock me-2"></i>Riwayat Login & Logout
        </h1>
        <span class="text-muted small">
            Riwayat 7 hari terakhir
        </span>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">#</th>
                            <th>Aktivitas</th>
                            <th class="d-none d-md-table-cell">Status</th>
                            <th class="d-none d-md-table-cell">Last Active</th>
                            <th width="120">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($logs)) : ?>
                        <?php $no = 1; foreach ($logs as $row) : ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>

                                <!-- ACTIVITY -->
                                <td>
                                    <?php if ($row['activity'] === 'login') : ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-sign-in-alt me-1"></i> Login
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                                        </span>
                                    <?php endif ?>

                                    <div class="small text-muted">
                                        IP: <?= esc($row['ip_address'] ?? '-') ?>
                                    </div>
                                </td>

                                <!-- STATUS -->
                                <td class="d-none d-md-table-cell">
                                    <?php if ($row['is_online']) : ?>
                                        <span class="badge bg-success">Online</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Offline</span>
                                    <?php endif ?>
                                </td>

                                <!-- LAST ACTIVE -->
                                <td class="d-none d-md-table-cell">
                                    <?= $row['last_active_at']
                                        ? date('d M Y H:i', strtotime($row['last_active_at']))
                                        : '-' ?>
                                </td>

                                <!-- TIME -->
                                <td>
                                    <div><?= date('d M Y', strtotime($row['created_at'])) ?></div>
                                    <small class="text-muted"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-1"></i>
                                Belum ada aktivitas login / logout
                            </td>
                        </tr>
                    <?php endif ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
