<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Barcode Dokumen Saya<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-3 mb-md-0 text-gray-800">
            <i class="fas fa-qrcode me-2"></i>Barcode Dokumen Saya
        </h1>
    </div>

    <!-- Barcode Cards -->
    <?php if (empty($barcodes)): ?>
        <div class="text-center py-5">
            <i class="fas fa-barcode fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Belum ada dokumen dengan barcode yang tersedia.</p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($barcodes as $dok): ?>
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-2 text-truncate"><?= $dok['kode_dokumen'] ?></h6>
                            <?php if (!empty($dok['nama_dokumen_internal'])): ?>
                                <p class="text-primary small mb-2"><?= $dok['nama_dokumen_internal'] ?></p>
                            <?php endif; ?>

                            <?php if (!empty($dok['barcodeBase64'])): ?>
                                <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" alt="Barcode <?= $dok['kode_dokumen'] ?>" class="img-fluid mb-2">
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="<?= base_url('barcode/print/'.$dok['id']) ?>" target="_blank" class="btn btn-sm btn-success me-1">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-muted small mt-3">Belum digenerate admin</div>
                            <?php endif; ?>

                            <div class="small text-muted mt-2">
                                <i class="fas fa-user me-1"></i> <?= $dok['uploader_name'] ?? 'Unknown' ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .card img { max-width: 150px; height: auto; margin: 0 auto; }
</style>
<?= $this->endSection() ?>
