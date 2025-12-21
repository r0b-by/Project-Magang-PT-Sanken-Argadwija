<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>History Revisi Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">
                <i class="fas fa-history me-2"></i>History Revisi Dokumen
            </h1> 
            <p class="text-muted small mb-0">Riwayat semua revisi dokumen sistem</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-primary fs-6">
                Total: <?= !empty($all_history) ? count($all_history) : '0' ?> Revisi
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
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari dokumen atau uploader...">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:50px">#</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Dokumen</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa; width:120px">Status</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_history)) : ?>
                            <?php $no = 1; foreach ($all_history as $row) : ?>
                            <tr class="hover-highlight">
                                <!-- No Urut -->
                                <td class="text-center text-muted fw-medium py-3 border-end"><?= $no++ ?></td>
                                
                                <!-- Info Dokumen -->
                                <td class="py-3 border-end">
                                    <!-- Header Info -->
                                    <div class="fw-semibold text-dark mb-1">
                                        <i class="fas fa-file-pdf text-danger me-1" style="font-size: 14px;"></i>
                                        <?= esc($row['kode_dokumen']) ?>
                                        <span class="text-muted mx-1">-</span>
                                        <span class="text-primary"><?= esc($row['nama_file']) ?></span>
                                    </div>
                                    
                                    <!-- Metadata -->
                                    <div class="text-muted small mb-2">
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-code-branch me-1" style="font-size: 10px;"></i>
                                                Versi <?= esc($row['versi'] ?? '-') ?>
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-user me-1" style="font-size: 10px;"></i>
                                                <?= esc($row['uploader_name'] ?? 'Unknown') ?>
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-calendar me-1" style="font-size: 10px;"></i>
                                                <?= !empty($row['uploaded_at']) ? date('d/m/Y', strtotime($row['uploaded_at'])) : '-' ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Detail Tambahan -->
                                    <?php if (!empty($row['ruang_lingkup']) || !empty($row['tujuan'])) : ?>
                                        <div class="border-top pt-2 mt-2 small">
                                            <?php if (!empty($row['ruang_lingkup'])) : ?>
                                                <div class="mb-1">
                                                    <span class="fw-semibold text-dark">Ruang Lingkup:</span>
                                                    <span class="text-muted"><?= esc($row['ruang_lingkup']) ?></span>
                                                </div>
                                            <?php endif ?>
                                            <?php if (!empty($row['tujuan'])) : ?>
                                                <div>
                                                    <span class="fw-semibold text-dark">Tujuan:</span>
                                                    <span class="text-muted"><?= esc($row['tujuan']) ?></span>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                    
                                    <!-- Mobile Status -->
                                    <div class="d-block d-md-none mt-2">
                                        <?php if ($row['status'] === 'save'): ?>
                                            <span class="badge bg-success fs-6 px-2 py-1">
                                                <i class="fas fa-check-circle me-1"></i>Save
                                            </span>
                                        <?php elseif ($row['status'] === 'non-save'): ?>
                                            <span class="badge bg-secondary fs-6 px-2 py-1">
                                                <i class="fas fa-times-circle me-1"></i>Non-Save
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark fs-6 px-2 py-1">
                                                <i class="fas fa-history me-1"></i>Revisi
                                            </span>
                                        <?php endif ?>
                                    </div>
                                </td>
                                
                                <!-- Desktop Status -->
                                <td class="text-center py-3 border-end d-none d-md-table-cell">
                                    <?php if ($row['status'] === 'save'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fs-6 px-3 py-2 d-inline-flex align-items-center">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Save
                                        </span>
                                    <?php elseif ($row['status'] === 'non-save'): ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 fs-6 px-3 py-2 d-inline-flex align-items-center">
                                            <i class="fas fa-times-circle me-2"></i>
                                            Non-Save
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 fs-6 px-3 py-2 d-inline-flex align-items-center">
                                            <i class="fas fa-history me-2"></i>
                                            Revisi
                                        </span>
                                    <?php endif ?>
                                </td>
                                
                                <!-- Aksi -->
                                <td class="text-center py-3">
                                    <!-- Desktop Actions -->
                                    <div class="btn-group btn-group-sm d-none d-md-flex">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>"
                                           class="btn btn-outline-info border"
                                           title="Lihat Dokumen"
                                           target="_blank"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>"
                                           class="btn btn-outline-success border"
                                           title="Download"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        
                                        <!-- Dropdown untuk opsi lainnya -->
                                        <div class="btn-group">
                                            <button type="button" 
                                                    class="btn btn-outline-secondary border dropdown-toggle"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    title="Lainnya">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fas fa-info-circle text-muted me-2"></i>
                                                        Detail
                                                    </a>
                                                </li>
                                                <?php if (session()->get('role') === 'admin'): ?>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                                       class="dropdown-item text-danger"
                                                       onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                                        <i class="fas fa-trash-alt me-2"></i>
                                                        Hapus History
                                                    </a>
                                                </li>
                                                <?php endif ?>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile Actions -->
                                    <div class="d-md-none">
                                        <div class="btn-group-vertical btn-group-sm w-100">
                                            <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>"
                                               class="btn btn-outline-info border"
                                               target="_blank">
                                                <i class="fas fa-eye me-2"></i>Lihat
                                            </a>
                                            <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>"
                                               class="btn btn-outline-success border">
                                                <i class="fas fa-download me-2"></i>Download
                                            </a>
                                            <?php if (session()->get('role') === 'admin'): ?>
                                            <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                               class="btn btn-outline-danger border"
                                               onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                                <i class="fas fa-trash-alt me-2"></i>Hapus
                                            </a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <p class="text-muted fs-5 mb-2">Belum ada history revisi</p>
                                        <p class="text-muted small">Semua history revisi dokumen akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        <?php if (!empty($all_history)) : ?>
                            Menampilkan <strong>1-<?= count($all_history) ?></strong> dari <strong><?= count($all_history) ?></strong> revisi
                        <?php else: ?>
                            <strong>0</strong> data ditemukan
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

.badge.bg-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
    color: #ffc107 !important;
}

.badge.bg-secondary {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: #6c757d !important;
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

/* Gap utility */
.gap-1 { gap: 0.25rem; }
.gap-2 { gap: 0.5rem; }
.gap-3 { gap: 1rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    // Add click event to rows
    document.querySelectorAll('.hover-highlight').forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on buttons or links
            if (!e.target.closest('a') && !e.target.closest('button')) {
                const viewLink = this.querySelector('a[title="Lihat Dokumen"]');
                if (viewLink) {
                    viewLink.click();
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>