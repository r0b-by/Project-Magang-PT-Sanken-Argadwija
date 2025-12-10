<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-3 mb-md-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Detail Dokumen
        </h1>
        <div>
            <a href="/iso00" class="btn btn-secondary btn-sm btn-md">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    
    <!-- Document Details -->
    <div class="row g-3 g-md-4">
        <!-- Main Content -->
        <div class="col-lg-8 order-2 order-lg-1">
            <!-- Document Information Card -->
            <div class="card shadow-sm mb-3 mb-md-4">
                <div class="card-header bg-primary text-white py-2 py-md-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 d-none d-md-inline"></i>
                        <span class="fs-5 fs-md-4">Informasi Dokumen</span>
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">
                        <!-- Kode Dokumen -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-hashtag me-1"></i>Kode Dokumen
                                </label>
                                <div class="h5 h4-md fw-bold text-primary"><?= esc($dokumen['kode_dokumen']) ?></div>
                            </div>
                        </div>
                        
                        <!-- Departemen -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-building me-1"></i>Departemen
                                </label>
                                <div class="h5 h4-md fw-bold"><?= esc($dokumen['departement']) ?></div>
                            </div>
                        </div>
                        
                        <!-- Nama File -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-file me-1"></i>Nama File
                                </label>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-file-pdf text-danger me-2 fs-4"></i>
                                    <div class="text-break"><?= esc($dokumen['nama_file']) ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-circle me-1"></i>Status
                                </label>
                                <div class="mt-2">
                                    <span class="badge bg-<?= 
                                        $dokumen['status'] == 'approved' ? 'success' : 
                                        ($dokumen['status'] == 'pending' ? 'warning' : 'info') ?> fs-6">
                                        <?= ucfirst($dokumen['status']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Barcode -->
                        <?php if ($dokumen['barcode']): ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-barcode me-1"></i>Barcode
                                </label>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-barcode me-2 fs-4 text-muted"></i>
                                    <div class="h5 fw-bold font-monospace"><?= esc($dokumen['barcode']) ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-sticky-note me-1"></i>Keterangan
                                </label>
                                <div class="card bg-light mt-2">
                                    <div class="card-body p-3">
                                        <?= nl2br(esc($dokumen['keterangan'] ?? '-')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- File Actions Card -->
            <div class="card shadow-sm mb-3 mb-md-4">
                <div class="card-header bg-info text-white py-2 py-md-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-file-pdf me-2 d-none d-md-inline"></i>
                        <span class="fs-5 fs-md-4">File Dokumen</span>
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <!-- File Info -->
                        <div class="d-flex align-items-center w-100 w-md-auto">
                            <div class="position-relative me-3">
                                <i class="fas fa-file-pdf text-danger" style="font-size: 3rem;"></i>
                                <div class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                                    PDF
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1 text-break"><?= esc($dokumen['nama_file']) ?></h5>
                                <?php 
                                $filePath = WRITEPATH . 'uploads/' . $dokumen['nama_file'];
                                if (file_exists($filePath)) {
                                    $fileSize = round(filesize($filePath) / 1024, 2);
                                    echo "<small class='text-muted d-block'><i class='fas fa-hdd me-1'></i>Ukuran: {$fileSize} KB</small>";
                                } else {
                                    echo "<small class='text-danger d-block'><i class='fas fa-exclamation-triangle me-1'></i>File tidak ditemukan</small>";
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-grid d-md-flex gap-2 w-100 w-md-auto">
                            <a href="/iso00/view/<?= $dokumen['id'] ?>" 
                               class="btn btn-primary btn-lg btn-md" 
                               target="_blank">
                                <i class="fas fa-eye me-1"></i>
                                <span>Lihat PDF</span>
                            </a>
                            <a href="/iso00/download/<?= $dokumen['id'] ?>" 
                               class="btn btn-success btn-lg btn-md">
                                <i class="fas fa-download me-1"></i>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4 order-1 order-lg-2">
            <!-- Uploader Card -->
            <div class="card shadow-sm mb-3 mb-md-4">
                <div class="card-header bg-success text-white py-2 py-md-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-upload me-2 d-none d-md-inline"></i>
                        <span class="fs-5 fs-md-4">Uploader</span>
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <?php if (!empty($dokumen['uploader_foto'])): ?>
                                <img src="/uploads/foto_user/<?= esc($dokumen['uploader_foto']) ?>" 
                                     class="rounded-circle border border-3 border-success"
                                     width="90" height="90"
                                     alt="Foto Uploader"
                                     style="object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                     style="width: 90px; height: 90px;">
                                    <i class="fas fa-user text-white" style="font-size: 2.5rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1 border border-2 border-white">
                                <i class="fas fa-check text-white" style="font-size: 0.8rem;"></i>
                            </div>
                        </div>
                        
                        <h5 class="mt-3 mb-1"><?= esc($dokumen['uploader_name'] ?? 'Unknown') ?></h5>
                        <p class="text-muted mb-3">
                            <i class="fas fa-user-tag me-1"></i>
                            <?= ucfirst($dokumen['uploader_role'] ?? 'Unknown') ?>
                        </p>
                    </div>
                    
                    <!-- Upload Details -->
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-alt text-success me-2"></i>
                                <span class="text-muted">Tanggal Upload</span>
                            </div>
                            <span class="fw-bold"><?= date('d/m/Y H:i', strtotime($dokumen['uploaded_at'])) ?></span>
                        </div>
                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-clock text-success me-2"></i>
                                <span class="text-muted">Waktu</span>
                            </div>
                            <span class="fw-bold"><?= date('H:i', strtotime($dokumen['uploaded_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Updater Card (jika ada) -->
            <?php if (!empty($dokumen['updated_by'])): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-2 py-md-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-edit me-2 d-none d-md-inline"></i>
                        <span class="fs-5 fs-md-4">Terakhir Diupdate</span>
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <!-- Updater Info -->
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <?php if (!empty($dokumen['updater_foto'])): ?>
                                <img src="/uploads/foto_user/<?= esc($dokumen['updater_foto']) ?>" 
                                     class="rounded-circle border border-3 border-warning"
                                     width="70" height="70"
                                     alt="Foto Updater"
                                     style="object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                     style="width: 70px; height: 70px;">
                                    <i class="fas fa-user text-white" style="font-size: 1.8rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute bottom-0 end-0 bg-warning rounded-circle p-1 border border-2 border-white">
                                <i class="fas fa-sync-alt text-white" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                        
                        <h6 class="mt-3 mb-1"><?= esc($dokumen['updater_name'] ?? 'Unknown') ?></h6>
                        <p class="text-muted mb-3 small">
                            <i class="fas fa-user-tag me-1"></i>
                            <?= ucfirst($dokumen['updater_role'] ?? 'Unknown') ?>
                        </p>
                    </div>
                    
                    <!-- Update Details -->
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-alt text-warning me-2"></i>
                                <span class="text-muted">Tanggal Update</span>
                            </div>
                            <span class="fw-bold"><?= date('d/m/Y H:i', strtotime($dokumen['updated_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="card shadow-sm mt-3 mt-md-4">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3">
                <a href="/iso00" class="btn btn-secondary btn-lg btn-md flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i>
                    <span>Kembali ke Daftar</span>
                </a>
                
                <?php if (session()->get('user_id') == $dokumen['uploaded_by'] || session()->get('role') == 'admin'): ?>
                <a href="/iso00/edit/<?= $dokumen['id'] ?>" class="btn btn-warning btn-lg btn-md flex-fill flex-md-grow-0">
                    <i class="fas fa-edit me-1"></i>
                    <span>Edit Dokumen</span>
                </a>
                <?php endif; ?>
                
                <?php if (session()->get('role') == 'admin'): ?>
                <a href="/iso00/delete/<?= $dokumen['id'] ?>" 
                   class="btn btn-danger btn-lg btn-md flex-fill flex-md-grow-0"
                   onclick="return confirm('Yakin menghapus dokumen ini?')">
                    <i class="fas fa-trash me-1"></i>
                    <span>Hapus Dokumen</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for responsive design */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .card-header {
            padding: 0.75rem 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        h1 {
            font-size: 1.5rem;
        }
        
        .h5 {
            font-size: 1.1rem;
        }
        
        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }
        
        .btn-md {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .list-group-item {
            padding: 0.75rem 0;
        }
    }
    
    @media (max-width: 575.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .card-header {
            padding: 0.5rem 0.75rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .row.g-3 > [class*="col-"] {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .btn-lg {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }
        
        .btn-md {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
        }
    }
    
    /* Desktop styles */
    @media (min-width: 768px) {
        .h4-md {
            font-size: 1.3rem;
        }
        
        .fs-4-md {
            font-size: 1.1rem;
        }
        
        .btn-lg {
            padding: 0.5rem 1rem;
        }
        
        .btn-md {
            padding: 0.375rem 0.75rem;
        }
    }
    
    /* Utility classes */
    .text-break {
        word-break: break-word;
    }
    
    .font-monospace {
        font-family: 'Courier New', monospace;
    }
    
    .flex-fill {
        flex: 1 1 0%;
    }
    
    .flex-md-grow-0 {
        flex-grow: 0 !important;
    }
    
    /* Card hover effect */
    .card.shadow-sm:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }
</style>

<script>
    // Add interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for delete action
        const deleteBtn = document.querySelector('a[href*="/iso00/delete/"]');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                if (!confirm('Yakin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.')) {
                    e.preventDefault();
                }
            });
        }
        
        // Add file size formatting
        const fileSizeElements = document.querySelectorAll('.text-muted');
        fileSizeElements.forEach(el => {
            if (el.textContent.includes('KB')) {
                const size = parseFloat(el.textContent);
                if (size > 1024) {
                    const mbSize = (size / 1024).toFixed(2);
                    el.innerHTML = el.innerHTML.replace(`${size} KB`, `${mbSize} MB`);
                }
            }
        });
        
        // Make cards clickable (optional enhancement)
        const viewBtn = document.querySelector('a[href*="/iso00/view/"]');
        if (viewBtn && window.innerWidth < 768) {
            document.querySelector('.card.shadow-sm').style.cursor = 'pointer';
            document.querySelector('.card.shadow-sm').addEventListener('click', function() {
                viewBtn.click();
            });
        }
    });
</script>
<?= $this->endSection() ?>