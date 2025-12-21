<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Daftar QR Code Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<?php $role = session()->get('role'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Daftar QR Code Dokumen</h1>
            <p class="text-muted small mb-0">Dokumen yang sudah memiliki QR Code</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-primary fs-6">
                Total: <?= !empty($sudahBarcode) ? count($sudahBarcode) : '0' ?> QR Code
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header dengan Search -->
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari berdasarkan kode atau nama dokumen...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Kode Dokumen</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa;">QR Code</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Link</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Status</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:180px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sudahBarcode)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                                        <p class="text-muted fs-5 mb-2">Belum ada QR Code</p>
                                        <p class="text-muted small">Semua QR Code yang digenerate akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($sudahBarcode as $dok): ?>
                            <tr class="hover-highlight">
                                <!-- Kode Dokumen -->
                                <td class="py-3 border-end">
                                    <div class="fw-semibold text-dark mb-1">
                                        <i class="fas fa-barcode text-primary me-2" style="font-size: 14px;"></i>
                                        <?= esc($dok['kode_dokumen']) ?>
                                    </div>
                                    <?php if (!empty($dok['nama_dokumen_internal'])): ?>
                                    <div class="text-muted small">
                                        <i class="fas fa-file-alt me-1" style="font-size: 10px;"></i>
                                        <?= esc($dok['nama_dokumen_internal']) ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($dok['versi'])): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-code-branch me-1" style="font-size: 10px;"></i>
                                        Versi: <?= esc($dok['versi']) ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Mobile QR Code Preview -->
                                    <div class="d-md-none mt-2">
                                        <div class="d-flex align-items-center">
                                            <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" 
                                                 width="60" 
                                                 height="60" 
                                                 class="border rounded me-2"
                                                 alt="QR Code">
                                            <div class="small">
                                                <div class="text-muted">QR Code</div>
                                                <div class="text-truncate" style="max-width: 180px;">
                                                    <?= esc($dok['barcode']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- QR Code Image (Desktop) -->
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" 
                                             width="80" 
                                             height="80" 
                                             class="border rounded"
                                             alt="QR Code">
                                        <div class="ms-3 small">
                                            <div class="text-muted mb-1">Generated:</div>
                                            <?php if (!empty($dok['updated_at'])): ?>
                                                <div class="fw-semibold">
                                                    <?= date('d/m/Y', strtotime($dok['updated_at'])) ?>
                                                </div>
                                                <div class="text-muted">
                                                    <?= date('H:i', strtotime($dok['updated_at'])) ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Link (Desktop) -->
                                <td class="py-3 border-end d-none d-lg-table-cell">
                                    <div class="text-truncate" style="max-width: 200px;" 
                                         title="<?= esc($dok['barcode']) ?>">
                                        <?= esc($dok['barcode']) ?>
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-external-link-alt me-1" style="font-size: 10px;"></i>
                                        Klik QR untuk akses
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-3 border-end">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fs-6 px-3 py-2 d-inline-flex align-items-center">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Generated
                                        </span>
                                    </div>
                                    <?php if (!empty($dok['tanggal_efektif'])): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-calendar-check me-1" style="font-size: 10px;"></i>
                                        <?= date('d/m/Y', strtotime($dok['tanggal_efektif'])) ?>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Aksi -->
                                <td class="text-center py-3">
                                    <!-- Desktop Actions -->
                                    <div class="btn-group btn-group-sm d-none d-md-flex">
                                        <!-- Download -->
                                        <a href="/barcode/print/<?= $dok['id'] ?>" 
                                           target="_blank" 
                                           class="btn btn-outline-success border"
                                           title="Download QR Code"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <?php if ($role === 'admin'): ?>
                                            <!-- Generate Ulang -->
                                            <a href="/barcode/generate/<?= $dok['id'] ?>" 
                                               class="btn btn-outline-warning border"
                                               title="Generate Ulang"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top">
                                                <i class="fas fa-redo"></i>
                                            </a>

                                            <!-- Delete -->
                                            <button type="button" 
                                                    class="btn btn-outline-danger border dropdown-toggle"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    title="Opsi Lainnya">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-eye text-muted me-2"></i>
                                                        Preview
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-print text-muted me-2"></i>
                                                        Cetak Label
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="/barcode/delete/<?= $dok['id'] ?>" 
                                                       class="dropdown-item text-danger"
                                                       onclick="return confirm('Hapus QR Code ini?')">
                                                        <i class="fas fa-trash-alt me-2"></i>
                                                        Hapus QR Code
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Mobile Actions -->
                                    <div class="d-md-none">
                                        <div class="btn-group-vertical btn-group-sm w-100">
                                            <a href="/barcode/print/<?= $dok['id'] ?>" 
                                               target="_blank" 
                                               class="btn btn-outline-success border">
                                                <i class="fas fa-download me-2"></i>Download
                                            </a>

                                            <?php if ($role === 'admin'): ?>
                                                <a href="/barcode/generate/<?= $dok['id'] ?>" 
                                                   class="btn btn-outline-warning border">
                                                    <i class="fas fa-redo me-2"></i>Regenerate
                                                </a>
                                                <a href="/barcode/delete/<?= $dok['id'] ?>" 
                                                   class="btn btn-outline-danger border"
                                                   onclick="return confirm('Hapus QR Code ini?')">
                                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($role === 'dept'): ?>
                                            <div class="text-muted small mt-2 text-center">
                                                <i class="fas fa-lock me-1"></i>Hanya admin dapat mengubah QR
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        <?php if (!empty($sudahBarcode)) : ?>
                            Menampilkan <strong>1-<?= count($sudahBarcode) ?></strong> dari <strong><?= count($sudahBarcode) ?></strong> QR Code
                        <?php else: ?>
                            <strong>0</strong> QR Code ditemukan
                        <?php endif ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Styles untuk tampilan seperti Excel */
.card {
    border-radius: 0.5rem;
    overflow: hidden;
}

.card-header {
    padding: 1.25rem 1.5rem;
}

.table {
    border-collapse: collapse;
    margin-bottom: 0;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table thead th {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.875rem 0.75rem;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border: 1px solid #dee2e6;
}

.table tbody tr:last-child td {
    border-bottom: 1px solid #dee2e6;
}

/* Border kanan untuk semua kolom kecuali terakhir */
.table tbody td:not(:last-child) {
    border-right: 1px solid #dee2e6;
}

/* Warna header lebih gelap di sisi kanan */
.table thead th:not(:last-child) {
    border-right: 1px solid #dee2e6;
}

/* Hover effect */
.hover-highlight:hover {
    background-color: #f8fafc !important;
    cursor: pointer;
}

.btn-group .btn {
    border: 1px solid #e9ecef;
    background-color: #fff;
}

.btn-group .btn:hover {
    background-color: #f8f9fa;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
    border-radius: 0.375rem;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.text-muted {
    color: #6c757d !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

/* Tooltip customization */
[data-bs-toggle="tooltip"] {
    cursor: pointer;
}

/* Excel-like grid lines */
.table-bordered td, .table-bordered th {
    border-color: #dee2e6;
}

/* Alternating row colors */
.table tbody tr:nth-child(even) {
    background-color: #fcfcfc;
}

.table tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Border yang lebih jelas untuk header */
.table thead th {
    border-top: 1px solid #dee2e6;
    border-bottom: 2px solid #dee2e6;
}

/* Garis vertikal yang lebih tegas */
.border-end {
    border-right: 1px solid #dee2e6 !important;
}

/* Pagination styling */
.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.125rem;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Badge styling */
.badge.bg-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: #198754 !important;
}

/* QR Code image styling */
img[src*="base64"] {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

img[src*="base64"]:hover {
    transform: scale(1.05);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .btn-group-vertical {
        width: 100%;
    }
    
    .btn-group-vertical .btn {
        justify-content: flex-start;
        text-align: left;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    // QR Code click to open link
    document.querySelectorAll('img[src*="base64"]').forEach(qr => {
        qr.addEventListener('click', function() {
            const row = this.closest('tr');
            const linkElement = row.querySelector('.text-truncate');
            if (linkElement && linkElement.textContent) {
                const url = linkElement.textContent.trim();
                if (url.startsWith('http')) {
                    window.open(url, '_blank');
                }
            }
        });
        
        qr.style.cursor = 'pointer';
        qr.title = 'Klik untuk membuka link QR Code';
    });
});
</script>
<?= $this->endSection() ?>