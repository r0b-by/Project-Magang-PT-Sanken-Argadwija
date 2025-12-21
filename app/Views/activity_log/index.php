<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Activity Log<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">
                <i class="fas fa-user-clock me-2"></i>Aktivitas Login & Logout
            </h1>
            <p class="text-muted small mb-0">Riwayat aktivitas login dan logout pengguna sistem</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-info fs-6">
                Total: <?= !empty($logs) ? count($logs) : '0' ?> Aktivitas
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header dengan Search -->
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group" style="max-width: 400px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari berdasarkan nama atau username...">
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>Data otomatis terhapus setiap 7 hari
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:50px">#</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">User</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Aktivitas</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa;">Status</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa;">Last Active</th>
                            <th class="text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:150px">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)) : ?>
                            <?php $no = 1; foreach ($logs as $row) : ?>
                            <tr class="hover-highlight">
                                <!-- No Urut -->
                                <td class="text-center text-muted fw-medium py-3 border-end"><?= $no++ ?></td>

                                <!-- User Info -->
                                <td class="py-3 border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <?= strtoupper(substr($row['fullname'] ?? $row['username'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-1">
                                                <?= esc($row['fullname'] ?? $row['username']) ?>
                                            </div>
                                            <div class="text-muted small">
                                                <span class="badge bg-<?= 
                                                    ($row['role'] ?? 'user') == 'admin' ? 'danger' : 
                                                    (($row['role'] ?? 'user') == 'dept' ? 'primary' : 'info') 
                                                ?> bg-opacity-10 text-<?= 
                                                    ($row['role'] ?? 'user') == 'admin' ? 'danger' : 
                                                    (($row['role'] ?? 'user') == 'dept' ? 'primary' : 'info') 
                                                ?> border-0 px-2 py-1">
                                                    <i class="fas fa-<?= 
                                                        ($row['role'] ?? 'user') == 'admin' ? 'user-shield' : 
                                                        (($row['role'] ?? 'user') == 'dept' ? 'user-tie' : 'user') 
                                                    ?> me-1" style="font-size: 10px;"></i>
                                                    <?= ucfirst($row['role'] ?? 'user') ?>
                                                </span>
                                            </div>
                                            <div class="text-muted small mt-1">
                                                <i class="fas fa-user me-1" style="font-size: 10px;"></i>
                                                @<?= esc($row['username']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Activity -->
                                <td class="py-3 border-end">
                                    <?php if (($row['activity'] ?? 'login') === 'login') : ?>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 36px; height: 36px; min-width: 36px;">
                                                <i class="fas fa-sign-in-alt" style="font-size: 14px;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-success">Login Success</div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-network-wired me-1" style="font-size: 10px;"></i>
                                                    IP: <?= esc($row['ip_address'] ?? '-') ?>
                                                </div>
                                                <?php if (!empty($row['user_agent'])): ?>
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-desktop me-1" style="font-size: 10px;"></i>
                                                    <?= $this->getBrowser($row['user_agent']) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 36px; height: 36px; min-width: 36px;">
                                                <i class="fas fa-sign-out-alt" style="font-size: 14px;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-secondary">Logout</div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-network-wired me-1" style="font-size: 10px;"></i>
                                                    IP: <?= esc($row['ip_address'] ?? '-') ?>
                                                </div>
                                                <?php if (!empty($row['user_agent'])): ?>
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-desktop me-1" style="font-size: 10px;"></i>
                                                    <?= $this->getBrowser($row['user_agent']) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </td>

                                <!-- Status (Desktop) -->
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <?php if ($row['is_online'] ?? false) : ?>
                                            <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 28px; height: 28px; min-width: 28px;">
                                                <i class="fas fa-circle" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-success">Online</div>
                                                <div class="text-muted small">Saat ini aktif</div>
                                            </div>
                                        <?php else : ?>
                                            <div class="bg-secondary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 28px; height: 28px; min-width: 28px;">
                                                <i class="fas fa-circle" style="font-size: 8px;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-secondary">Offline</div>
                                                <div class="text-muted small">Tidak aktif</div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </td>

                                <!-- Last Active (Desktop) -->
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <?php if (!empty($row['last_active_at'])) : ?>
                                        <div class="fw-semibold text-dark">
                                            <?= date('d M Y', strtotime($row['last_active_at'])) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= date('H:i', strtotime($row['last_active_at'])) ?>
                                        </div>
                                        <?php 
                                        $lastActive = strtotime($row['last_active_at']);
                                        $now = time();
                                        $diffHours = floor(($now - $lastActive) / 3600);
                                        $diffMinutes = floor(($now - $lastActive) / 60);
                                        
                                        if ($diffHours < 1) {
                                            $timeAgo = $diffMinutes . ' menit lalu';
                                            $badgeClass = 'bg-success';
                                        } elseif ($diffHours < 24) {
                                            $timeAgo = $diffHours . ' jam lalu';
                                            $badgeClass = 'bg-info';
                                        } else {
                                            $timeAgo = floor($diffHours / 24) . ' hari lalu';
                                            $badgeClass = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> bg-opacity-10 text-dark mt-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-clock me-1"></i><?= $timeAgo ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>

                                <!-- Time -->
                                <td class="py-3">
                                    <div class="text-center">
                                        <div class="fw-semibold text-dark">
                                            <?= date('d M Y', strtotime($row['created_at'] ?? $row['login_time'])) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= date('H:i:s', strtotime($row['created_at'] ?? $row['login_time'])) ?>
                                        </div>
                                        <?php 
                                        $createdAt = strtotime($row['created_at'] ?? $row['login_time']);
                                        $now = time();
                                        $diffMinutes = floor(($now - $createdAt) / 60);
                                        
                                        if ($diffMinutes < 60) {
                                            $timeAgo = $diffMinutes . ' menit lalu';
                                            $badgeClass = 'bg-warning';
                                        } elseif ($diffMinutes < 1440) {
                                            $timeAgo = floor($diffMinutes / 60) . ' jam lalu';
                                            $badgeClass = 'bg-info';
                                        } else {
                                            $timeAgo = floor($diffMinutes / 1440) . ' hari lalu';
                                            $badgeClass = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> bg-opacity-10 text-dark mt-2" style="font-size: 0.7rem;">
                                            <i class="fas fa-history me-1"></i><?= $timeAgo ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                        <p class="text-muted fs-5 mb-2">Belum ada aktivitas login/logout</p>
                                        <p class="text-muted small">Riwayat aktivitas pengguna akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        <?php if (!empty($logs)) : ?>
                            Menampilkan <strong>1-<?= count($logs) ?></strong> dari <strong><?= count($logs) ?></strong> aktivitas
                        <?php else: ?>
                            <strong>0</strong> aktivitas ditemukan
                        <?php endif ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Styles untuk tampilan seperti Excel */
.card {
    border-radius: 0.5rem;
    overflow: hidden;
}

.card-header {
    padding: 1.25rem 1.5rem;
}

.table {
    border-collapse: collapse;
    margin-bottom: 0;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table thead th {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.875rem 0.75rem;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border: 1px solid #dee2e6;
}

.table tbody tr:last-child td {
    border-bottom: 1px solid #dee2e6;
}

/* Border kanan untuk semua kolom kecuali terakhir */
.table tbody td:not(:last-child) {
    border-right: 1px solid #dee2e6;
}

/* Warna header lebih gelap di sisi kanan */
.table thead th:not(:last-child) {
    border-right: 1px solid #dee2e6;
}

/* Hover effect */
.hover-highlight:hover {
    background-color: #f8fafc !important;
    cursor: pointer;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
    border-radius: 0.375rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.text-muted {
    color: #6c757d !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

/* Excel-like grid lines */
.table-bordered td, .table-bordered th {
    border-color: #dee2e6;
}

/* Alternating row colors */
.table tbody tr:nth-child(even) {
    background-color: #fcfcfc;
}

.table tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Border yang lebih jelas untuk header */
.table thead th {
    border-top: 1px solid #dee2e6;
    border-bottom: 2px solid #dee2e6;
}

/* Garis vertikal yang lebih tegas */
.border-end {
    border-right: 1px solid #dee2e6 !important;
}

/* Pagination styling */
.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.125rem;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Badge styling */
.badge.bg-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: #198754 !important;
}

.badge.bg-secondary {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: #6c757d !important;
}

.badge.bg-info {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

.badge.bg-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
    color: #ffc107 !important;
}

.badge.bg-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
    color: #dc3545 !important;
}

.badge.bg-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

/* Gradient backgrounds */
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-success.bg-gradient {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.bg-secondary.bg-gradient {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
}

.bg-primary.bg-gradient {
    background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%) !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .card-header .input-group {
        max-width: 100% !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh untuk melihat aktivitas terbaru
    let refreshInterval = 300000; // 5 menit
    
    function refreshData() {
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.querySelector('.table-responsive');
            if (newTable) {
                document.querySelector('.table-responsive').innerHTML = newTable.innerHTML;
                console.log('Data aktivitas diperbarui');
            }
        })
        .catch(error => console.error('Error refreshing data:', error));
    }
    
    // Set auto-refresh jika halaman visible
    if (!document.hidden) {
        setInterval(refreshData, refreshInterval);
    }
    
    // Pause refresh ketika tab tidak aktif
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            refreshInterval = setInterval(refreshData, 300000);
        } else {
            clearInterval(refreshInterval);
        }
    });
});
</script>
<?= $this->endSection() ?>