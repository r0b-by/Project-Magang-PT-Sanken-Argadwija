<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="dashboard-container" style="background: #F8FAFC; min-height: 100vh;">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-1 fw-bold" style="color: #0F172A;">Dashboard</h1>
                        <p class="mb-0 small" style="color: #64748B;">Selamat datang di Aplikasi Arsip Digital</p>
                    </div>
                    <div class="text-end">
                        <span class="date-badge" style="background: #FFFFFF; border: 1px solid #E2E8F0; color: #0F172A;">
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
                <div class="card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box" style="background: rgba(37, 99, 235, 0.1);">
                                    <i class="fas fa-users" style="color: #2563EB;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1" style="color: #64748B;">Total User</div>
                                <h3 class="mb-0 fw-bold" style="color: #2563EB;"><?= $total_user ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Dokumen Card -->
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box" style="background: rgba(37, 99, 235, 0.1);">
                                    <i class="fas fa-file-alt" style="color: #2563EB;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1" style="color: #64748B;">Total Dokumen</div>
                                <h3 class="mb-0 fw-bold" style="color: #2563EB;"><?= $total_dokumen ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Dokumen Card -->
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box" style="background: rgba(37, 99, 235, 0.1);">
                                    <i class="fas fa-folder" style="color: #2563EB;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1" style="color: #64748B;">Kategori</div>
                                <h3 class="mb-0 fw-bold" style="color: #2563EB;"><?= $total_kategori ?? '0' ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Aktivitas Hari Ini Card -->
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card-dashboard">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="icon-box" style="background: rgba(37, 99, 235, 0.1);">
                                    <i class="fas fa-chart-line" style="color: #2563EB;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1" style="color: #64748B;">Aktivitas Hari Ini</div>
                                <h3 class="mb-0 fw-bold" style="color: #2563EB;"><?= $aktivitas_hari_ini ?? '0' ?></h3>
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
                <div class="card-dashboard mb-3">
                    <div class="card-header py-3" style="background: #FFFFFF; border-bottom: 1px solid #E2E8F0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold" style="color: #0F172A;">
                                <i class="fas fa-history me-2" style="color: #2563EB;"></i>Aktivitas Terbaru
                            </h6>
                            <a href="/activity" class="btn btn-sm" style="background: #FFFFFF; border: 1px solid #E2E8F0; color: #2563EB;">
                                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($log_terbaru)): ?>
                            <div class="activity-list">
                                <?php foreach ($log_terbaru as $index => $log): ?>
                                    <div class="activity-item <?= $index < count($log_terbaru) - 1 ? 'border-bottom' : '' ?>" style="border-color: #E2E8F0;">
                                        <div class="d-flex align-items-start p-3">
                                            <div class="flex-shrink-0">
                                                <div class="activity-icon" style="background: rgba(37, 99, 235, 0.1);">
                                                    <?php
                                                    $icon = 'history';
                                                    if (str_contains(strtolower($log['activity']), 'login')) {
                                                        $icon = 'sign-in-alt';
                                                    } elseif (str_contains(strtolower($log['activity']), 'upload')) {
                                                        $icon = 'upload';
                                                    } elseif (str_contains(strtolower($log['activity']), 'scan')) {
                                                        $icon = 'qrcode';
                                                    } elseif (str_contains(strtolower($log['activity']), 'delete')) {
                                                        $icon = 'trash-alt';
                                                    } elseif (str_contains(strtolower($log['activity']), 'download')) {
                                                        $icon = 'download';
                                                    }
                                                    ?>
                                                    <i class="fas fa-<?= $icon ?>" style="color: #2563EB;"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="activity-content">
                                                    <p class="mb-1 fw-medium" style="color: #0F172A;"><?= esc($log['activity']) ?></p>
                                                    <div class="d-flex flex-wrap align-items-center small" style="color: #64748B;">
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
                                    <i class="fas fa-inbox fa-3x mb-3" style="color: #94A3B8;"></i>
                                    <p class="mb-0" style="color: #64748B;">Belum ada aktivitas</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-12 col-xl-4">
                <!-- User Stats Card -->
                <div class="card-dashboard mb-3">
                    <div class="card-header py-3" style="background: #FFFFFF; border-bottom: 1px solid #E2E8F0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold" style="color: #0F172A;">
                                <i class="fas fa-chart-pie me-2" style="color: #2563EB;"></i>Statistik User
                            </h6>
                            <a href="/users" class="btn btn-sm" style="background: #FFFFFF; border: 1px solid #E2E8F0; color: #2563EB;">
                                Kelola <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="user-stats-circle mx-auto mb-3">
                            <div class="circle-content">
                                <i class="fas fa-users fa-2x mb-2" style="color: #2563EB;"></i>
                                <h2 class="fw-bold mb-0" style="color: #2563EB;"><?= $total_user ?></h2>
                            </div>
                        </div>
                        <p class="mb-0" style="color: #64748B;">Total User Terdaftar</p>
                    </div>
                </div>

                <!-- Recent Documents Card -->
                <div class="card-dashboard">
                    <div class="card-header py-3" style="background: #FFFFFF; border-bottom: 1px solid #E2E8F0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold" style="color: #0F172A;">
                                <i class="fas fa-file-alt me-2" style="color: #2563EB;"></i>Dokumen Terbaru
                            </h6>
                            <a href="/iso00" class="btn btn-sm" style="background: #FFFFFF; border: 1px solid #E2E8F0; color: #2563EB;">
                                Lihat <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($dokumen_baru)): ?>
                            <div class="document-list">
                                <?php foreach ($dokumen_baru as $index => $doc): ?>
                                    <div class="document-item <?= $index < count($dokumen_baru) - 1 ? 'border-bottom' : '' ?> p-3" style="border-color: #E2E8F0;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="doc-icon" style="background: rgba(37, 99, 235, 0.1);">
                                                    <i class="fas fa-file" style="color: #2563EB;"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="doc-title fw-medium mb-1" style="color: #0F172A;">
                                                    <?= esc($doc['kode_dokumen']) ?>
                                                </div>
                                                <div class="doc-date small" style="color: #64748B;">
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
                                    <i class="fas fa-folder-open fa-2x mb-2" style="color: #94A3B8;"></i>
                                    <p class="small mb-0" style="color: #64748B;">Tidak ada dokumen</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===========================
   Dashboard Styles
   Sesuai panduan desain
   =========================== */

/* Base Container */
.dashboard-container {
    background: #F8FAFC;
}

/* Card Dashboard */
.card-dashboard {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card-dashboard:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

/* Icon Box */
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

/* Date Badge */
.date-badge {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
}

/* Activity List */
.activity-list {
    max-height: 480px;
    overflow-y: auto;
}

.activity-item {
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background-color: #F8FAFC;
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
    background: rgba(37, 99, 235, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(37, 99, 235, 0.1);
}

.circle-content {
    text-align: center;
}

/* Document List */
.document-list {
    max-height: 380px;
    overflow-y: auto;
}

.document-item {
    transition: background-color 0.2s ease;
}

.document-item:hover {
    background-color: #F8FAFC;
}

.doc-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
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
    background: #F1F5F9;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb,
.document-list::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb:hover,
.document-list::-webkit-scrollbar-thumb:hover {
    background: #94A3B8;
}

/* Button Styles */
.btn {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    background: rgba(37, 99, 235, 0.1);
    border-color: #2563EB;
}

/* Card Header */
.card-header {
    padding: 1rem 1.25rem;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
}

.fw-semibold {
    font-weight: 600;
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
    scrollbar-color: #CBD5E1 #F1F5F9;
}

/* Smooth transitions */
.card-dashboard,
.activity-item,
.document-item,
.btn {
    transition: all 0.2s ease-in-out;
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
    
    // Add subtle animation to cards on load
    const cards = document.querySelectorAll('.card-dashboard');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
    
    // Add hover effect to activity and document items
    const items = document.querySelectorAll('.activity-item, .document-item');
    items.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#F8FAFC';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});
</script>
<?= $this->endSection() ?>