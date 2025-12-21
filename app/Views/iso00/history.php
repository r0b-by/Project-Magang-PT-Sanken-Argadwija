<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Riwayat Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">
                <i class="fas fa-history me-2"></i>Riwayat Revisi Dokumen
            </h1> 
            <p class="text-muted small mb-0">Histori perubahan dan revisi dokumen</p>
        </div>
        <a href="<?= site_url('iso00') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
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
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari riwayat revisi...">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (!empty($history)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                        <thead class="table-light d-none d-md-table-header-group">
                            <tr>
                                <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:5%">#</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:10%">Versi</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:20%">Nama File</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:20%">Ruang Lingkup</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:15%">Tujuan</th>
                                <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:10%">Status</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:10%">Uploader</th>
                                <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:10%">Uploaded</th>
                                <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $i => $row) : ?>
                            <tr class="hover-highlight">
                                <!-- MOBILE HEADER -->
                                <td class="fw-bold d-md-none bg-light border-end" colspan="2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><?= ($i + 1) ?>. <?= esc($row['nama_file']) ?></span>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>" class="btn btn-sm btn-outline-primary border" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>" class="btn btn-sm btn-outline-success border">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <!-- DESKTOP -->
                                <td class="text-center text-muted fw-medium py-3 border-end d-none d-md-table-cell"><?= $i + 1 ?></td>
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <span class="fw-semibold"><?= esc($row['versi']) ?></span>
                                </td>
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            <?= esc($row['nama_file']) ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- MOBILE CONTENT -->
                                <td class="d-md-none py-3 border-end">
                                    <div class="row g-2">
                                        <div class="col-4 fw-bold small">Versi</div>
                                        <div class="col-8 small"><?= esc($row['versi']) ?></div>

                                        <div class="col-4 fw-bold small">Ruang Lingkup</div>
                                        <div class="col-8 small"><?= esc($row['ruang_lingkup'] ?? '-') ?></div>

                                        <div class="col-4 fw-bold small">Tujuan</div>
                                        <div class="col-8 small"><?= esc($row['tujuan'] ?? '-') ?></div>

                                        <div class="col-4 fw-bold small">Status</div>
                                        <div class="col-8 small">
                                            <?php if ($row['status'] === 'save'): ?>
                                                <span class="badge bg-success">Save</span>
                                            <?php elseif ($row['status'] === 'non-save'): ?>
                                                <span class="badge bg-secondary">Non-Save</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Revisi</span>
                                            <?php endif ?>
                                        </div>

                                        <div class="col-4 fw-bold small">Uploader</div>
                                        <div class="col-8 small"><?= esc($row['uploader_name']) ?></div>

                                        <div class="col-4 fw-bold small">Uploaded</div>
                                        <div class="col-8 small">
                                            <?= !empty($row['uploaded_at']) ? date('d M Y H:i', strtotime($row['uploaded_at'])) : '-' ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- DESKTOP CONTINUE -->
                                <td class="py-3 border-end d-none d-md-table-cell"><?= esc($row['ruang_lingkup'] ?? '-') ?></td>
                                <td class="py-3 border-end d-none d-md-table-cell"><?= esc($row['tujuan'] ?? '-') ?></td>
                                <td class="text-center py-3 border-end d-none d-md-table-cell">
                                    <?php if ($row['status'] === 'save'): ?>
                                        <span class="badge bg-success fs-6 px-2 py-1">Save</span>
                                    <?php elseif ($row['status'] === 'non-save'): ?>
                                        <span class="badge bg-secondary fs-6 px-2 py-1">Non-Save</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark fs-6 px-2 py-1">Revisi</span>
                                    <?php endif ?>
                                </td>

                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                            style="width: 28px; height: 28px; min-width: 28px; font-size: 12px;">
                                            <?= strtoupper(substr($row['uploader_name'], 0, 1)) ?>
                                        </div>
                                        <div class="text-truncate" style="max-width: 120px;">
                                            <?= esc($row['uploader_name']) ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="py-3 border-end d-none d-md-table-cell">
                                    <?php if (!empty($row['uploaded_at'])): ?>
                                        <div class="fw-semibold small">
                                            <?= date('d/m/Y', strtotime($row['uploaded_at'])) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= date('H:i', strtotime($row['uploaded_at'])) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- AKSI -->
                                <td class="text-center py-3">
                                    <div class="d-md-none">
                                        <?php if (session()->get('role') === 'admin'): ?>
                                        <div class="mt-2">
                                            <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                            class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </a>
                                        </div>
                                        <?php endif ?>
                                    </div>

                                    <div class="btn-group btn-group-sm d-none d-md-flex">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>" 
                                           class="btn btn-outline-primary border" 
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
                                        <?php if (session()->get('role') === 'admin'): ?>
                                        <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                           class="btn btn-outline-danger border"
                                           title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus history revisi ini?')"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php endif ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">Belum ada histori revisi dokumen.</p>
                </div>
            <?php endif ?>
        </div>
        
        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        <?php if (!empty($history)) : ?>
                            Menampilkan <strong>1-<?= count($history) ?></strong> dari <strong><?= count($history) ?></strong> revisi
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

/* Mobile responsive */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
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
});
</script>
<?= $this->endSection() ?>