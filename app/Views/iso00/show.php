<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Detail Dokumen
        </h1>
        <div>
            <a href="/iso00" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    
    <!-- Document Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Dokumen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Kode Dokumen</label>
                            <p class="h5"><?= esc($dokumen['kode_dokumen']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Departemen</label>
                            <p class="h5"><?= esc($dokumen['departement']) ?></p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nama File</label>
                            <p>
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <?= esc($dokumen['nama_file']) ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Status</label>
                            <p>
                                <span class="badge bg-<?= 
                                    $dokumen['status'] == 'approved' ? 'success' : 
                                    ($dokumen['status'] == 'pending' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($dokumen['status']) ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Keterangan</label>
                        <p><?= nl2br(esc($dokumen['keterangan'] ?? '-')) ?></p>
                    </div>
                    
                    <?php if ($dokumen['barcode']): ?>
                    <div class="mb-3">
                        <label class="form-label text-muted">Barcode</label>
                        <p>
                            <i class="fas fa-barcode me-2"></i>
                            <?= esc($dokumen['barcode']) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- File Actions -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-pdf me-2"></i>File Dokumen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-pdf fa-3x text-danger me-3"></i>
                            <div>
                                <h5><?= esc($dokumen['nama_file']) ?></h5>
                                <?php 
                                $filePath = WRITEPATH . 'uploads/' . $dokumen['nama_file'];
                                if (file_exists($filePath)) {
                                    $fileSize = round(filesize($filePath) / 1024, 2);
                                    echo "<small class='text-muted'>Ukuran: {$fileSize} KB</small>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="/iso00/view/<?= $dokumen['id'] ?>" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-eye me-1"></i>Lihat PDF
                            </a>
                            <a href="/iso00/download/<?= $dokumen['id'] ?>" 
                               class="btn btn-success">
                                <i class="fas fa-download me-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar - Uploader Info -->
        <div class="col-lg-4">
            <!-- Uploader Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2"></i>Uploader
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <?php if (!empty($dokumen['uploader_foto'])): ?>
                            <img src="/uploads/foto_user/<?= esc($dokumen['uploader_foto']) ?>" 
                                 class="rounded-circle mb-3" 
                                 width="100" height="100"
                                 alt="Foto Uploader">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-user text-white fa-3x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h5><?= esc($dokumen['uploader_name'] ?? 'Unknown') ?></h5>
                        <p class="text-muted">
                            <i class="fas fa-user-tag me-1"></i>
                            <?= ucfirst($dokumen['uploader_role'] ?? 'Unknown') ?>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>Tanggal Upload
                        </label>
                        <p><?= date('d/m/Y H:i', strtotime($dokumen['uploaded_at'])) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Updater Card (jika ada) -->
            <?php if (!empty($dokumen['updated_by'])): ?>
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Terakhir Diupdate
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <?php if (!empty($dokumen['updater_foto'])): ?>
                            <img src="/uploads/foto_user/<?= esc($dokumen['updater_foto']) ?>" 
                                 class="rounded-circle mb-3" 
                                 width="80" height="80"
                                 alt="Foto Updater">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h6><?= esc($dokumen['updater_name'] ?? 'Unknown') ?></h6>
                        <p class="text-muted">
                            <i class="fas fa-user-tag me-1"></i>
                            <?= ucfirst($dokumen['updater_role'] ?? 'Unknown') ?>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>Tanggal Update
                        </label>
                        <p><?= date('d/m/Y H:i', strtotime($dokumen['updated_at'])) ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="card">
        <div class="card-body text-center">
            <div class="btn-group" role="group">
                <a href="/iso00" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                </a>
                
                <?php if (session()->get('user_id') == $dokumen['uploaded_by'] || session()->get('role') == 'admin'): ?>
                <a href="/iso00/edit/<?= $dokumen['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit Dokumen
                </a>
                <?php endif; ?>
                
                <?php if (session()->get('role') == 'admin'): ?>
                <a href="/iso00/delete/<?= $dokumen['id'] ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Yakin menghapus dokumen ini?')">
                    <i class="fas fa-trash me-1"></i>Hapus Dokumen
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>