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
                                <?php if ($dokumen['barcode']): ?>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-barcode me-1"></i><?= esc($dokumen['barcode']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Halaman & Ruang Lingkup -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-file-alt me-1"></i>Halaman / Ruang Lingkup
                                </label>
                                <div class="mt-2">
                                    <span class="fw-bold"><?= esc($dokumen['halaman_dokumen'] ?? '-') ?></span> | 
                                    <span><?= esc($dokumen['ruang_lingkup'] ?? '-') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tujuan -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-bullseye me-1"></i>Tujuan
                                </label>
                                <div class="mt-2"><?= esc($dokumen['tujuan'] ?? '-') ?></div>
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
                                        ($dokumen['status'] == 'save' ? 'info' : 'warning') ?> fs-6">
                                        <?= ucfirst($dokumen['status']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Efektif -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-calendar-alt me-1"></i>Tanggal Efektif
                                </label>
                                <div class="mt-2"><?= $dokumen['tanggal_efektif'] ? date('d/m/Y', strtotime($dokumen['tanggal_efektif'])) : '-' ?></div>
                            </div>
                        </div>

                        <!-- Nama File -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-muted small fw-bold mb-1">
                                    <i class="fas fa-file-pdf me-1"></i>File Dokumen
                                </label>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-file-pdf text-danger me-2 fs-4"></i>
                                    <div class="text-break"><?= esc($dokumen['nama_file']) ?></div>
                                </div>
                                <?php 
                                $filePath = WRITEPATH . 'uploads/' . $dokumen['nama_file'];
                                if (file_exists($filePath)) {
                                    $fileSize = round(filesize($filePath) / 1024, 2);
                                    echo "<small class='text-muted d-block mt-1'><i class='fas fa-hdd me-1'></i>Ukuran: {$fileSize} KB</small>";
                                }
                                ?>
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
                <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center w-100 w-md-auto">
                        <i class="fas fa-file-pdf text-danger me-3" style="font-size: 3rem;"></i>
                        <div>
                            <h5 class="mb-1 text-break"><?= esc($dokumen['nama_file']) ?></h5>
                        </div>
                    </div>
                    <div class="d-grid d-md-flex gap-2 w-100 w-md-auto">
                        <a href="/iso00/view/<?= $dokumen['id'] ?>" class="btn btn-primary btn-lg btn-md" target="_blank">
                            <i class="fas fa-eye me-1"></i>Lihat PDF
                        </a>
                        <a href="/iso00/download/<?= $dokumen['id'] ?>" class="btn btn-success btn-lg btn-md">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
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
                <div class="card-body p-3 p-md-4 text-center">
                    <?php if (!empty($dokumen['uploader_foto'])): ?>
                        <img src="/uploads/foto_user/<?= esc($dokumen['uploader_foto']) ?>" 
                             class="rounded-circle mb-2" width="90" height="90" style="object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary mb-2 d-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                            <i class="fas fa-user text-white fs-3"></i>
                        </div>
                    <?php endif; ?>
                    <h5 class="mt-2 mb-1"><?= esc($dokumen['uploader_name'] ?? 'Unknown') ?></h5>
                    <p class="text-muted mb-2"><?= ucfirst($dokumen['uploader_role'] ?? 'Unknown') ?></p>
                    <small class="text-muted d-block">Tanggal Upload: <?= date('d/m/Y H:i', strtotime($dokumen['uploaded_at'])) ?></small>
                </div>
            </div>

            <!-- Updater Card -->
            <?php if (!empty($dokumen['updated_by'])): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-2 py-md-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-edit me-2 d-none d-md-inline"></i>
                        <span class="fs-5 fs-md-4">Terakhir Diupdate</span>
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4 text-center">
                    <?php if (!empty($dokumen['updater_foto'])): ?>
                        <img src="/uploads/foto_user/<?= esc($dokumen['updater_foto']) ?>" 
                             class="rounded-circle mb-2" width="70" height="70" style="object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary mb-2 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-user text-white fs-4"></i>
                        </div>
                    <?php endif; ?>
                    <h6 class="mt-2 mb-1"><?= esc($dokumen['updater_name'] ?? 'Unknown') ?></h6>
                    <p class="text-muted mb-2 small"><?= ucfirst($dokumen['updater_role'] ?? 'Unknown') ?></p>
                    <small class="text-muted d-block">Tanggal Update: <?= date('d/m/Y H:i', strtotime($dokumen['updated_at'])) ?></small>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card shadow-sm mt-3 mt-md-4">
        <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3">
            <a href="/iso00" class="btn btn-secondary btn-lg btn-md flex-fill flex-md-grow-0">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
            </a>
            <?php if (session()->get('user_id') == $dokumen['uploaded_by'] || session()->get('role') == 'admin'): ?>
            <a href="/iso00/edit/<?= $dokumen['id'] ?>" class="btn btn-warning btn-lg btn-md flex-fill flex-md-grow-0">
                <i class="fas fa-edit me-1"></i>Edit Dokumen
            </a>
            <?php endif; ?>
            <?php if (session()->get('role') == 'admin'): ?>
            <a href="/iso00/delete/<?= $dokumen['id'] ?>" class="btn btn-danger btn-lg btn-md flex-fill flex-md-grow-0"
               onclick="return confirm('Yakin menghapus dokumen ini?')">
                <i class="fas fa-trash me-1"></i>Hapus Dokumen
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
