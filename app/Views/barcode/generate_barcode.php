<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Generate QR Code Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Generate QR Code Dokumen</h1>
            <p class="text-muted small mb-0">Generate QR Code untuk dokumen ISO yang belum memiliki</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-warning fs-6">
                <?= !empty($belumBarcode) ? count($belumBarcode) : '0' ?> Dokumen Tersedia
            </span>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Generate Form Card -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header -->
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    <i class="fas fa-file-circle-plus text-primary me-2"></i>Dokumen Belum Memiliki QR Code
                </h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleAllCheckboxes()">
                    <i class="fas fa-check-square me-2"></i>Pilih Semua
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($belumBarcode)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted fs-5 mb-2">Semua dokumen sudah memiliki QR Code</p>
                    <p class="text-muted small">Tidak ada dokumen yang perlu digenerate</p>
                    <a href="/barcode/list" class="btn btn-primary mt-3">
                        <i class="fas fa-list me-2"></i>Lihat Daftar QR Code
                    </a>
                </div>
            <?php else: ?>

            <form action="/barcode/generate-bulk" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:50px">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Kode Dokumen</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa;">Nama File</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Uploader</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Uploaded</th>
                                <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($belumBarcode as $dok): ?>
                            <tr class="hover-highlight">
                                <!-- Checkbox -->
                                <td class="text-center py-3 border-end">
                                    <input type="checkbox" name="dokumen[]" value="<?= $dok['id'] ?>" class="dok-checkbox form-check-input">
                                </td>
                                
                                <!-- Kode Dokumen -->
                                <td class="py-3 border-end">
                                    <div class="fw-semibold text-dark mb-1">
                                        <i class="fas fa-file text-primary me-2" style="font-size: 14px;"></i>
                                        <?= esc($dok['kode_dokumen']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= esc($dok['nama_dokumen_internal']) ?>
                                    </div>
                                    <?php if (!empty($dok['versi'])): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-code-branch me-1" style="font-size: 10px;"></i>
                                        Versi: <?= esc($dok['versi']) ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Nama File -->
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            <?= esc($dok['nama_file']) ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($dok['halaman_dokumen'])): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-file-alt me-1" style="font-size: 10px;"></i>
                                        <?= esc($dok['halaman_dokumen']) ?> halaman
                                    </div>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Uploader -->
                                <td class="py-3 border-end d-none d-lg-table-cell">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 28px; height: 28px; min-width: 28px; font-size: 12px;">
                                            <?= !empty($dok['fullname']) ? strtoupper(substr($dok['fullname'], 0, 1)) : '?' ?>
                                        </div>
                                        <div class="text-truncate" style="max-width: 120px;">
                                            <?= esc($dok['fullname'] ?? '-') ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($dok['role'])): ?>
                                    <div class="text-muted small mt-1">
                                        <?= ucfirst($dok['role']) ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Uploaded Date -->
                                <td class="py-3 border-end d-none d-lg-table-cell">
                                    <?php if (!empty($dok['uploaded_at'])): ?>
                                        <div class="fw-semibold small">
                                            <?= date('d/m/Y', strtotime($dok['uploaded_at'])) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= date('H:i', strtotime($dok['uploaded_at'])) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Aksi -->
                                <td class="text-center py-3">
                                    <a href="/barcode/generate/<?= $dok['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary border"
                                       title="Generate QR Code untuk dokumen ini"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form Footer -->
                <div class="card-footer bg-white border-top">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="text-muted small me-3" id="selectedCount">0 dokumen dipilih</span>
                                <span class="badge bg-info">
                                    Total: <?= count($belumBarcode) ?> dokumen
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-bolt me-2"></i>Generate Massal
                            </button>
                            <a href="/barcode/list" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-list me-2"></i>Lihat QR Code
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <?php endif; ?>
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

/* Checkbox styling */
.form-check-input {
    width: 1.1em;
    height: 1.1em;
    margin-top: 0.15em;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Alert styling */
.alert {
    border: 1px solid transparent;
    border-radius: 0.5rem;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .card-footer .row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .card-footer .col-md-6 {
        width: 100%;
        text-align: center !important;
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
    
    // Checkbox functionality
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.dok-checkbox');
    const counter = document.getElementById('selectedCount');
    
    if (checkAll) {
        checkAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            updateCount();
        });
    }
    
    checkboxes.forEach(cb => cb.addEventListener('change', updateCount));
    
    function updateCount() {
        if (!counter) return;
        const total = [...checkboxes].filter(cb => cb.checked).length;
        counter.innerText = total + ' dokumen dipilih';
        
        // Update checkAll state
        if (checkAll) {
            checkAll.checked = total === checkboxes.length;
            checkAll.indeterminate = total > 0 && total < checkboxes.length;
        }
    }
    
    function toggleAllCheckboxes() {
        if (checkAll) {
            checkAll.checked = !checkAll.checked;
            checkAll.dispatchEvent(new Event('change'));
        }
    }
    
    // Make rows clickable (for better UX)
    document.querySelectorAll('.hover-highlight').forEach(row => {
        const checkbox = row.querySelector('.dok-checkbox');
        if (checkbox) {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on buttons or links
                if (!e.target.closest('a') && !e.target.closest('button')) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        }
    });
    
    // Initial count update
    updateCount();
    
    // Expose function to global scope for button onclick
    window.toggleAllCheckboxes = toggleAllCheckboxes;
});
</script>
<?= $this->endSection() ?>s