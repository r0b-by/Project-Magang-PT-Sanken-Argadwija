<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Generate QR Code Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .disabled-qrcode,
    .disabled-link {
        pointer-events: none;
        cursor: default;
        color: #6c757d !important;
        text-decoration: none !important;
    }
    
    .table-checkbox th:first-child,
    .table-checkbox td:first-child {
        width: 50px;
        text-align: center;
    }
    
    .qrcode-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 2px;
        background: white;
    }
</style>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Generate QR Code Dokumen</h1>
            <p class="text-muted small mb-0">Kelola QR Code untuk dokumen ISO</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="toggleAllCheckboxes()">
                <i class="fas fa-check-square me-2"></i>Pilih Semua
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- ================================ -->
    <!-- FORM GENERATE MASSAL -->
    <!-- ================================ -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light border-0 py-3">
            <h5 class="mb-0 fw-semibold text-dark">
                <i class="fas fa-file-circle-plus text-primary me-2"></i>Dokumen Belum Memiliki QR Code
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($belumBarcode)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted mb-0">Semua dokumen sudah memiliki QR Code</p>
                </div>
            <?php else: ?>
                <form action="/barcode/generate-bulk" method="post">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-checkbox">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 text-center">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th class="py-3 text-muted fw-semibold small">Kode Dokumen</th>
                                    <th class="py-3 text-muted fw-semibold small d-none d-md-table-cell">Nama File</th>
                                    <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">Uploader</th>
                                    <th class="py-3 text-center text-muted fw-semibold small" width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($belumBarcode as $dok): ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="dokumen[]" value="<?= $dok['id'] ?>" class="form-check-input dok-checkbox">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($dok['kode_dokumen']) ?></div>
                                        <?php if (!empty($dok['nama_dokumen_internal'])): ?>
                                            <div class="text-muted small">
                                                <?= esc($dok['nama_dokumen_internal']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <div class="text-truncate" style="max-width: 200px;">
                                                <?= esc($dok['nama_file']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 28px; height: 28px; min-width: 28px;">
                                                <i class="fas fa-user" style="font-size: 12px;"></i>
                                            </div>
                                            <div class="text-truncate" style="max-width: 120px;">
                                                <?= esc($dok['fullname'] ?? 'Unknown') ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="/barcode/generate/<?= $dok['id'] ?>" 
                                               class="btn btn-outline-primary" title="Generate QR Code">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <a href="/scan/detail/<?= $dok['id'] ?>" 
                                               class="btn btn-outline-info" title="Cek Data">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small" id="selectedCount">0 dokumen dipilih</span>
                        </div>
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="fas fa-bolt me-2"></i>Generate QR Code Massal
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================================ -->
    <!-- DOKUMEN SUDAH QR -->
    <!-- ================================ -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
            <h5 class="mb-0 fw-semibold text-dark">
                <i class="fas fa-qrcode text-success me-2"></i>Dokumen Sudah Memiliki QR Code
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small">Kode Dokumen</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-md-table-cell">QR Code</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">Link</th>
                            <th class="py-3 text-muted fw-semibold small">Status</th>
                            <th class="pe-4 py-3 text-center text-muted fw-semibold small" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sudahBarcode)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada dokumen dengan QR Code</p>
                                    <p class="text-muted small">Generate QR Code dari daftar di atas</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($sudahBarcode as $dok): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark"><?= esc($dok['kode_dokumen']) ?></div>
                                    <?php if (!empty($dok['nama_dokumen_internal'])): ?>
                                        <div class="text-muted small">
                                            <?= esc($dok['nama_dokumen_internal']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php if (!empty($dok['barcodeBase64'])): ?>
                                        <div class="disabled-qrcode d-inline-block">
                                            <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" 
                                                 alt="QR Code" 
                                                 class="qrcode-img">
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">Tidak tersedia</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <div class="text-truncate" style="max-width: 200px;">
                                        <a class="text-muted disabled-link small"><?= esc($dok['barcode'] ?? '-') ?></a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-success">
                                        <i class="fas fa-check me-1"></i> Generated
                                    </span>
                                    <?php if ($dok['updated_at']): ?>
                                        <div class="text-muted small mt-1">
                                            <?= date('d/m/Y', strtotime($dok['updated_at'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/barcode/print/<?= $dok['id'] ?>" 
                                           target="_blank" 
                                           class="btn btn-outline-success" 
                                           title="Download PNG">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="/scan/detail/<?= $dok['id'] ?>" 
                                           class="btn btn-outline-info" 
                                           title="Cek Data">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/barcode/generate/<?= $dok['id'] ?>" 
                                           class="btn btn-outline-warning" 
                                           title="Generate Ulang">
                                            <i class="fas fa-redo"></i>
                                        </a>
                                        <a href="/barcode/delete/<?= $dok['id'] ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Hapus QR Code"
                                           onclick="return confirm('Yakin ingin menghapus QR Code untuk dokumen ini?')">
                                            <i class="fas fa-trash-alt"></i>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle semua checkbox
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.dok-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    
    function updateSelectedCount() {
        const checked = document.querySelectorAll('.dok-checkbox:checked').length;
        selectedCount.textContent = `${checked} dokumen dipilih`;
    }
    
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedCount();
        });
        
        // Update checkAll status jika ada checkbox yang diubah
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked) {
                    checkAll.checked = false;
                } else {
                    // Cek apakah semua checkbox tercentang
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    checkAll.checked = allChecked;
                }
                updateSelectedCount();
            });
        });
        
        // Initial count
        updateSelectedCount();
    }
    
    function toggleAllCheckboxes() {
        if (checkAll) {
            checkAll.checked = !checkAll.checked;
            const event = new Event('change');
            checkAll.dispatchEvent(event);
        }
    }
    
    // Auto-hide alert setelah 5 detik
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

// Global function untuk tombol "Pilih Semua"
function toggleAllCheckboxes() {
    const checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.checked = !checkAll.checked;
        const event = new Event('change');
        checkAll.dispatchEvent(event);
    }
}
</script>

<?= $this->endSection() ?>