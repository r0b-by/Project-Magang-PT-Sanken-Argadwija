<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-lg-4 py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-1 fw-bold text-dark">Dashboard</h1>
                    <p class="text-muted mb-0 small">Selamat datang di Aplikasi Arsip Digital</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        <i class="far fa-calendar me-2"></i><?= date('d M Y') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Total User Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-primary-subtle">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Total User</div>
                            <h3 class="mb-0 fw-bold"><?= $total_user ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Dokumen Card -->
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="icon-box bg-success-subtle">
                                <i class="fas fa-file-alt text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Total Dokumen</div>
                            <h3 class="mb-0 fw-bold"><?= $total_dokumen ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-3">
        <!-- Left Column - Recent Activity -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-history text-primary me-2"></i>Aktivitas Terbaru
                        </h6>
                        <a href="/activity" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($log_terbaru)): ?>
                        <div class="activity-list">
                            <?php foreach ($log_terbaru as $index => $log): ?>
                                <?php
                                $icon = 'edit';
                                $colorClass = 'secondary';
                                if (str_contains(strtolower($log['activity']), 'login')) {
                                    $icon = 'sign-in-alt';
                                    $colorClass = 'success';
                                } elseif (str_contains(strtolower($log['activity']), 'upload')) {
                                    $icon = 'upload';
                                    $colorClass = 'primary';
                                } elseif (str_contains(strtolower($log['activity']), 'scan')) {
                                    $icon = 'qrcode';
                                    $colorClass = 'info';
                                } elseif (str_contains(strtolower($log['activity']), 'delete')) {
                                    $icon = 'trash-alt';
                                    $colorClass = 'danger';
                                } elseif (str_contains(strtolower($log['activity']), 'download')) {
                                    $icon = 'download';
                                    $colorClass = 'warning';
                                }
                                ?>
                                <div class="activity-item <?= $index < count($log_terbaru) - 1 ? 'border-bottom' : '' ?>">
                                    <div class="d-flex align-items-start p-3">
                                        <div class="flex-shrink-0">
                                            <div class="activity-icon bg-<?= $colorClass ?>-subtle">
                                                <i class="fas fa-<?= $icon ?> text-<?= $colorClass ?>"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="activity-content">
                                                <p class="mb-1 fw-medium"><?= esc($log['activity']) ?></p>
                                                <div class="d-flex flex-wrap align-items-center text-muted small">
                                                    <span class="me-3">
                                                        <i class="fas fa-user me-1"></i><?= esc($log['fullname']) ?>
                                                    </span>
                                                    <span>
                                                        <i class="far fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada aktivitas</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-12 col-xl-4">
            <!-- User Stats Card -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-chart-pie text-primary me-2"></i>Statistik User
                        </h6>
                        <a href="/users" class="btn btn-sm btn-outline-primary">
                            Kelola <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body text-center py-4">
                    <div class="user-stats-circle mx-auto mb-3">
                        <div class="circle-content">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h2 class="fw-bold mb-0"><?= $total_user ?></h2>
                        </div>
                    </div>
                    <p class="text-muted mb-0">Total User Terdaftar</p>
                </div>
            </div>

            <!-- Recent Documents Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-file-alt text-success me-2"></i>Dokumen Terbaru
                        </h6>
                        <a href="/iso00" class="btn btn-sm btn-outline-primary">
                            Lihat <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($dokumen_baru)): ?>
                        <div class="document-list">
                            <?php foreach ($dokumen_baru as $index => $doc): ?>
                                <div class="document-item <?= $index < count($dokumen_baru) - 1 ? 'border-bottom' : '' ?> p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="doc-icon">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="doc-title text-dark fw-medium mb-1">
                                                <?= esc($doc['kode_dokumen']) ?>
                                            </div>
                                            <div class="doc-date text-muted small">
                                                <i class="far fa-calendar me-1"></i>
                                                <?= date('d/m/Y', strtotime($doc['uploaded_at'] ?? $doc['created_at'] ?? '')) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                                <p class="text-muted small mb-0">Tidak ada dokumen</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===========================
   Modern Dashboard Styles
   =========================== */

/* Card Hover Effects */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
}

/* Icon Box Styles */
.icon-box {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-box i {
    font-size: 24px;
}

/* Background Colors */
.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-info-subtle {
    background-color: rgba(13, 202, 240, 0.1);
}

.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-danger-subtle {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-secondary-subtle {
    background-color: rgba(108, 117, 125, 0.1);
}

/* Activity List Styles */
.activity-list {
    max-height: 480px;
    overflow-y: auto;
}

.activity-item {
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background-color: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.activity-icon i {
    font-size: 18px;
}

/* User Stats Circle */
.user-stats-circle {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(13, 110, 253, 0.2);
}

.circle-content {
    text-align: center;
}

/* Document List Styles */
.document-list {
    max-height: 380px;
    overflow-y: auto;
}

.document-item {
    transition: background-color 0.2s ease;
}

.document-item:hover {
    background-color: #f8f9fa;
}

.doc-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff3f3;
    border-radius: 8px;
}

.doc-icon i {
    font-size: 18px;
}

.doc-title {
    font-size: 14px;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Empty State */
.empty-state {
    padding: 2rem 1rem;
}

/* Custom Scrollbar */
.activity-list::-webkit-scrollbar,
.document-list::-webkit-scrollbar {
    width: 6px;
}

.activity-list::-webkit-scrollbar-track,
.document-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb,
.document-list::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb:hover,
.document-list::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Button Styles */
.btn-outline-primary {
    border-color: rgba(13, 110, 253, 0.3);
    color: #0d6efd;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

/* Card Header */
.card-header {
    padding: 1rem 1.25rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .icon-box {
        width: 48px;
        height: 48px;
    }
    
    .icon-box i {
        font-size: 20px;
    }
    
    .activity-list {
        max-height: 350px;
    }
    
    .document-list {
        max-height: 300px;
    }
    
    .user-stats-circle {
        width: 120px;
        height: 120px;
    }
}

/* Firefox Scrollbar */
.activity-list,
.document-list {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f1f1f1;
}

/* Card Border Radius */
.card {
    border-radius: 12px;
    overflow: hidden;
}

/* Shadow Utilities */
.shadow-sm {
    box-shadow: 0 .125rem .5rem rgba(0, 0, 0, 0.08) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk activity dan document list
    const scrollContainers = document.querySelectorAll('.activity-list, .document-list');
    scrollContainers.forEach(container => {
        if (container) {
            container.style.scrollBehavior = 'smooth';
        }
    });
    
    // Auto-hide scrollbar when not hovering
    scrollContainers.forEach(container => {
        container.addEventListener('mouseenter', function() {
            this.style.overflowY = 'auto';
        });
        
        container.addEventListener('mouseleave', function() {
            this.style.overflowY = 'auto';
        });
    });
    
    // Add animation to cards on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
<?= $this->endSection() ?>