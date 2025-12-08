<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Dokumen<?= $this->endSection() ?>

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
            <a href="/uploads/dokumen/<?= $dokumen['nama_file'] ?>" 
               target="_blank" 
               class="btn btn-primary">
                <i class="fas fa-download me-1"></i>Download
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Document Info -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Informasi Dokumen
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Kode Dokumen</label>
                            <p class="fw-bold"><?= $dokumen['kode_dokumen'] ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Departemen</label>
                            <p class="fw-bold"><?= $dokumen['departement'] ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nama File</label>
                            <p class="fw-bold">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <?= $dokumen['nama_file'] ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Ukuran File</label>
                            <p class="fw-bold">
                                <?php if (file_exists('uploads/dokumen/' . $dokumen['nama_file'])): ?>
                                    <?= round(filesize('uploads/dokumen/' . $dokumen['nama_file']) / 1024, 2) ?> KB
                                <?php else: ?>
                                    <span class="text-danger">File tidak ditemukan</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Keterangan</label>
                            <p><?= nl2br($dokumen['keterangan']) ?: '-' ?></p>
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Barcode</label>
                            <p class="fw-bold">
                                <i class="fas fa-barcode me-2"></i>
                                <?= $dokumen['barcode'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PDF Viewer -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-file-pdf me-2"></i>Preview Dokumen
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (pathinfo($dokumen['nama_file'], PATHINFO_EXTENSION) == 'pdf'): ?>
                        <iframe src="/uploads/dokumen/<?= $dokumen['nama_file'] ?>" 
                                style="width: 100%; height: 600px;" 
                                frameborder="0">
                        </iframe>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-file fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Preview tidak tersedia untuk format file ini</p>
                            <a href="/uploads/dokumen/<?= $dokumen['nama_file'] ?>" 
                               target="_blank" 
                               class="btn btn-primary">
                                <i class="fas fa-download me-1"></i>Download File
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Uploader & History -->
        <div class="col-lg-4">
            <!-- Uploader Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-user-upload me-2"></i>Informasi Uploader
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <?php if ($dokumen['uploader_foto']): ?>
                            <img src="/uploads/foto_user/<?= $dokumen['uploader_foto'] ?>" 
                                 class="rounded-circle mb-3" 
                                 style="width: 100px; height: 100px; object-fit: cover;" 
                                 alt="Foto Uploader">
                        <?php else: ?>
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 100px; height: 100px;">
                                <span style="font-size: 2rem;">
                                    <?= strtoupper(substr($dokumen['uploader_name'], 0, 1)) ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <h5><?= $dokumen['uploader_name'] ?></h5>
                        <span class="badge bg-primary"><?= $dokumen['uploader_role'] ?></span>
                    </div>
                    
                    <div class="mt-3">
                        <label class="form-label text-muted">Waktu Upload</label>
                        <p class="fw-bold">
                            <i class="fas fa-calendar me-2"></i>
                            <?= date('d F Y', strtotime($dokumen['uploaded_at'])) ?>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            <?= date('H:i', strtotime($dokumen['uploaded_at'])) ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Scan History -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-history me-2"></i>Riwayat Scan
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($scan_history)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($scan_history as $scan): ?>
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <?php if ($scan['scanned_foto']): ?>
                                        <img src="/uploads/foto_user/<?= $scan['scanned_foto'] ?>" 
                                             class="rounded-circle me-3" 
                                             style="width: 40px; height: 40px; object-fit: cover;" 
                                             alt="Foto Scanner">
                                    <?php else: ?>
                                        <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <?= strtoupper(substr($scan['scanned_name'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-grow-1">
                                        <p class="mb-1"><?= $scan['scanned_name'] ?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('d/m/Y H:i', strtotime($scan['scan_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">Belum ada riwayat scan</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>