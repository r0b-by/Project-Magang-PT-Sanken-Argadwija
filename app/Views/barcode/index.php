<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Daftar QR Code Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="h4 fw-bold text-dark">Daftar QR Code Dokumen</h1>
        <p class="text-muted small mb-0">Dokumen yang sudah memiliki QR Code</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Kode Dokumen</th>
                            <th class="d-none d-md-table-cell">QR Code</th>
                            <th class="d-none d-lg-table-cell">Link</th>
                            <th>Status</th>
                            <th class="pe-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (empty($sudahBarcode)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-qrcode fa-3x mb-3"></i>
                                <p>Belum ada QR Code</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($sudahBarcode as $dok): ?>
                        <tr>
                            <td class="ps-4">
                                <strong><?= esc($dok['kode_dokumen']) ?></strong><br>
                                <small class="text-muted"><?= esc($dok['nama_dokumen_internal']) ?></small>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" width="80">
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <small class="text-muted"><?= esc($dok['barcode']) ?></small>
                            </td>
                            <td>
                                <span class="badge bg-success">Generated</span>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="/barcode/print/<?= $dok['id'] ?>" target="_blank" class="btn btn-outline-success">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="/barcode/generate/<?= $dok['id'] ?>" class="btn btn-outline-warning">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                    <a href="/barcode/delete/<?= $dok['id'] ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Hapus QR Code ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
