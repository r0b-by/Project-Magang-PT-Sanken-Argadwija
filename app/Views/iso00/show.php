
<!-- ========================================== -->
<!-- 2. HALAMAN DETAIL DOKUMEN ISO -->
<!-- ========================================== -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Detail Dokumen ISO<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Detail Dokumen</h1>
            <p class="text-muted small mb-0">Informasi lengkap dokumen ISO</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <!-- Info Dokumen -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Dokumen
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-hashtag me-1"></i>Kode Dokumen
                            </label>
                            <div class="h5 fw-bold text-primary mb-2"><?= esc($dokumen['kode_dokumen']) ?></div>
                            <?php if ($dokumen['barcode']): ?>
                                <small class="text-muted">
                                    <i class="fas fa-barcode me-1"></i><?= esc($dokumen['barcode']) ?>
                                </small>
                            <?php endif; ?>
                            <?php if (!empty($dokumen['nama_dokumen_internal'])): ?>
                                <div class="mt-2">
                                    <span class="badge bg-primary bg-gradient">
                                        <i class="fas fa-tag me-1"></i><?= esc($dokumen['nama_dokumen_internal']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-file-alt me-1"></i>Halaman / Ruang Lingkup
                            </label>
                            <div>
                                <span class="fw-semibold"><?= esc($dokumen['halaman_dokumen'] ?? '-') ?></span>
                                <span class="text-muted mx-2">|</span>
                                <span><?= esc($dokumen['ruang_lingkup'] ?? '-') ?></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-bullseye me-1"></i>Tujuan
                            </label>
                            <div><?= esc($dokumen['tujuan'] ?? '-') ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-circle me-1"></i>Status
                            </label>
                            <div>
                                <span class="badge rounded-pill bg-<?= 
                                    $dokumen['status'] == 'approved' ? 'success' : 
                                    ($dokumen['status'] == 'save' ? 'info' : 'warning') ?> px-3 py-2">
                                    <?= ucfirst($dokumen['status']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>Tanggal Efektif
                            </label>
                            <div><?= $dokumen['tanggal_efektif'] ? date('d/m/Y', strtotime($dokumen['tanggal_efektif'])) : '-' ?></div>
                        </div>

                        <div class="col-12">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="fas fa-file-pdf me-1"></i>File Dokumen
                            </label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-2 fs-3"></i>
                                <div>
                                    <div><?= esc($dokumen['nama_file']) ?></div>
                                    <?php 
                                    $filePath = WRITEPATH . 'uploads/' . $dokumen['nama_file'];
                                    if (file_exists($filePath)) {
                                        echo "<small class='text-muted'>Ukuran: " 
                                             . round(filesize($filePath) / 1024, 2) . " KB</small>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Actions -->
            <?php if (session()->get('role') == 'admin'): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="/iso00/view/<?= $dokumen['id'] ?>" class="btn btn-primary flex-fill" target="_blank">
                            <i class="fas fa-eye me-2"></i>Lihat PDF
                        </a>
                        <a href="/iso00/download/<?= $dokumen['id'] ?>" class="btn btn-success flex-fill">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Uploader -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-upload text-success me-2"></i>Uploader
                    </h6>
                </div>
                <div class="card-body p-4 text-center">
                    <?php if (!empty($dokumen['uploader_foto'])): ?>
                        <img src="/uploads/foto_user/<?= esc($dokumen['uploader_foto']) ?>" 
                             class="rounded-circle mb-3" width="80" height="80" 
                             style="object-fit: cover; border: 3px solid #f0f0f0;">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary bg-gradient mb-3 d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user text-white fs-3"></i>
                        </div>
                    <?php endif; ?>
                    <h6 class="fw-bold"><?= esc($dokumen['uploader_name']) ?></h6>
                    <p class="text-muted small mb-2"><?= ucfirst($dokumen['uploader_role']) ?></p>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?= date('d/m/Y H:i', strtotime($dokumen['uploaded_at'])) ?>
                    </small>
                </div>
            </div>

            <!-- Updater -->
            <?php if (!empty($dokumen['updated_by'])): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit text-warning me-2"></i>Terakhir Diupdate
                    </h6>
                </div>
                <div class="card-body p-4 text-center">
                    <?php if (!empty($dokumen['updater_foto'])): ?>
                        <img src="/uploads/foto_user/<?= esc($dokumen['updater_foto']) ?>" 
                             class="rounded-circle mb-3" width="60" height="60" 
                             style="object-fit: cover; border: 3px solid #f0f0f0;">
                    <?php else: ?>
                        <div class="rounded-circle bg-warning bg-gradient mb-3 d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user text-white fs-5"></i>
                        </div>
                    <?php endif; ?>
                    <h6 class="fw-semibold small"><?= esc($dokumen['updater_name']) ?></h6>
                    <p class="text-muted small mb-2"><?= ucfirst($dokumen['updater_role']) ?></p>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        <?= date('d/m/Y H:i', strtotime($dokumen['updated_at'])) ?>
                    </small>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-3">
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                <a href="/iso00" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <?php if (session()->get('user_id') == $dokumen['uploaded_by'] || session()->get('role') == 'admin'): ?>
                <a href="/iso00/edit/<?= $dokumen['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-pen me-2"></i>Edit
                </a>
                <?php endif; ?>
                <?php if (session()->get('role') == 'admin'): ?>
                <a href="/iso00/delete/<?= $dokumen['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                    <i class="fas fa-trash-alt me-2"></i>Hapus
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>