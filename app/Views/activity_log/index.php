<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Activity Log<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-list me-2"></i>Activity Log</h3>
        <form action="/activity/deleteAll" method="post" onsubmit="return confirm('Apakah yakin ingin menghapus semua aktivitas?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash me-1"></i> Hapus History
            </button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Aktivitas</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>IP Address</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($logs)): ?>
                        <?php $no = 1; foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($log['activity']) ?></td>
                            <td><?= esc($log['user_fullname'] ?? 'Unknown') ?></td>
                            <td><?= esc($log['user_role'] ?? '-') ?></td>
                            <td><?= esc($log['ip_address'] ?? '-') ?></td>
                            <td><?= esc($log['created_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada aktivitas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>
<?= $this->endSection() ?>
