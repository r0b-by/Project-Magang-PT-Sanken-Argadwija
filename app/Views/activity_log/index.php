<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Log Aktifitas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>Log Aktifitas Sistem
        </h1>
        <div>
            <button type="button" class="btn btn-danger" onclick="clearOldLogs()">
                <i class="fas fa-trash me-1"></i>Hapus Log Lama
            </button>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="" method="get">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="<?= isset($filters['start_date']) ? esc($filters['start_date']) : '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="<?= isset($filters['end_date']) ? esc($filters['end_date']) : '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">User</label>
                        <select class="form-select" name="user_id">
                            <option value="">Semua User</option>
                            <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" 
                                <?= (isset($filters['user_id']) && $filters['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                <?= esc($user['fullname']) ?> (<?= esc($user['role']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipe Aktifitas</label>
                        <select class="form-select" name="activity_type">
                            <option value="">Semua Aktifitas</option>
                            <option value="login" <?= (isset($filters['activity_type']) && $filters['activity_type'] == 'login') ? 'selected' : '' ?>>Login</option>
                            <option value="upload" <?= (isset($filters['activity_type']) && $filters['activity_type'] == 'upload') ? 'selected' : '' ?>>Upload</option>
                            <option value="edit" <?= (isset($filters['activity_type']) && $filters['activity_type'] == 'edit') ? 'selected' : '' ?>>Edit</option>
                            <option value="delete" <?= (isset($filters['activity_type']) && $filters['activity_type'] == 'delete') ? 'selected' : '' ?>>Hapus</option>
                            <option value="error" <?= (isset($filters['activity_type']) && $filters['activity_type'] == 'error') ? 'selected' : '' ?>>Error</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <a href="/activity" class="btn btn-secondary">
                                <i class="fas fa-sync me-1"></i>Reset
                            </a>
                            <button type="button" class="btn btn-success" onclick="exportLogs()">
                                <i class="fas fa-file-export me-1"></i>Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2 col-6">
            <div class="card bg-primary text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($total_logs) ? number_format($total_logs) : '0' ?></h5>
                    <small>Total Log</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($today_logs) ? number_format($today_logs) : '0' ?></h5>
                    <small>Hari Ini</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-info text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($login_count) ? number_format($login_count) : '0' ?></h5>
                    <small>Login</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-warning text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($upload_count) ? number_format($upload_count) : '0' ?></h5>
                    <small>Upload</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-danger text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($error_count) ? number_format($error_count) : '0' ?></h5>
                    <small>Error</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-dark text-white">
                <div class="card-body text-center p-3">
                    <h5 class="mb-0"><?= isset($unique_users) ? number_format($unique_users) : '0' ?></h5>
                    <small>User Aktif</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Activity Log Table -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 fw-bold">
                <i class="fas fa-list me-2"></i>Daftar Log Aktifitas
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($logs)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data log</h5>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Aktifitas</th>
                                <th>IP Address</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($log['foto'])): ?>
                                            <img src="/uploads/foto_user/<?= esc($log['foto']) ?>" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 32px; height: 32px; object-fit: cover;" 
                                                 alt="Foto User">
                                        <?php else: ?>
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px;">
                                                <?= !empty($log['fullname']) ? strtoupper(substr($log['fullname'], 0, 1)) : '?' ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold"><?= !empty($log['fullname']) ? esc($log['fullname']) : 'System' ?></div>
                                            <small class="text-muted"><?= !empty($log['role']) ? esc($log['role']) : 'System' ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= esc($log['activity']) ?></div>
                                </td>
                                <td>
                                    <code><?= esc($log['ip_address'] ?? 'Tidak diketahui') ?></code>
                                </td>
                                <td>
                                    <?php if (!empty($log['created_at'])): ?>
                                        <div><?= date('d/m/Y', strtotime($log['created_at'])) ?></div>
                                        <small class="text-muted"><?= date('H:i:s', strtotime($log['created_at'])) ?></small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan <?= count($logs) ?> dari <?= $pager->getTotal() ?> data
                    </div>
                    <nav>
                        <?= $pager->links() ?>
                    </nav>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Activity Chart -->
    <?php if (!empty($activity_chart)): ?>
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="m-0 fw-bold">
                <i class="fas fa-chart-line me-2"></i>Statistik Aktifitas 30 Hari Terakhir
            </h6>
        </div>
        <div class="card-body">
            <canvas id="activityChart" height="100"></canvas>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activity Chart
    <?php if (!empty($activity_chart)): ?>
    const ctx = document.getElementById('activityChart').getContext('2d');
    const activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_keys($activity_chart)) ?>,
            datasets: [{
                label: 'Jumlah Aktifitas',
                data: <?= json_encode(array_values($activity_chart)) ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Trend Aktifitas Harian'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    <?php endif; ?>
});

function clearOldLogs() {
    if (confirm('Hapus log yang berumur lebih dari 90 hari? Tindakan ini tidak dapat dibatalkan.')) {
        fetch('/activity/clear-old', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus log');
        });
    }
}

function exportLogs() {
    const params = new URLSearchParams(window.location.search);
    window.open('/activity/export?' + params.toString(), '_blank');
}
</script>
<?= $this->endSection() ?>