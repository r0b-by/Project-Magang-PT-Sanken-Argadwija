<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dokumen ISO<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Dokumen ISO</h1> 
            <p class="text-muted small mb-0">Kelola dokumen sistem manajemen</p>
        </div>
        <?php if (in_array(session()->get('role'), ['admin'])): ?>
        <a href="/iso00/create" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Upload Dokumen
        </a>
        <?php endif; ?>
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
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari dokumen berdasarkan kode atau nama...">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 datatable" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center text-muted text-uppercase small fw-semibold border-end" width="60" style="background-color: #f8f9fa;">No</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Dokumen</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">File</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Barcode</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Holder</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Hak Akses</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Uploader</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Uploaded</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Updated</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-lg-table-cell" style="background-color: #f8f9fa;">Updated By</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end d-none d-md-table-cell" style="background-color: #f8f9fa;" width="110">Status</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa;" width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumen as $doc): ?>
                        <tr class="hover-highlight">
                            <td class="text-center text-muted fw-medium py-3 border-end"><?= $no++ ?></td>
                            <td class="py-3 border-end">
                                <div>
                                    <div class="fw-semibold text-dark"><?= $doc['kode_dokumen'] ?></div>
                                    <?php if (!empty($doc['nama_dokumen_internal'])): ?>
                                        <div class="text-primary small">
                                            <i class="fas fa-tag" style="font-size: 10px;"></i> <?= $doc['nama_dokumen_internal'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-muted small">
                                        <?= $doc['halaman_dokumen'] ?? '-' ?> | <?= $doc['ruang_lingkup'] ?? '-' ?>
                                    </div>
                                    <?php if ($doc['barcode']): ?>
                                        <div class="text-muted small">
                                            <i class="fas fa-barcode" style="font-size: 10px;"></i> <?= $doc['barcode'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-1 d-lg-none">
                                        <span class="badge rounded-pill bg-<?= 
                                            $doc['status'] == 'approved' ? 'success' : 
                                            ($doc['status'] == 'save' ? 'info' : 'warning') ?>">
                                            <?= ucfirst($doc['status']) ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell py-3 border-end">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <div>
                                        <div class="text-truncate" style="max-width: 180px;" title="<?= $doc['nama_file'] ?>">
                                            <?= $doc['nama_file'] ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php 
                                            $filePath = WRITEPATH . 'uploads/' . $doc['nama_file'];
                                            if (file_exists($filePath)) {
                                                echo round(filesize($filePath) / 1024, 2) . ' KB';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 border-end">
                                <?php if ($doc['barcode']): ?>
                                    <span class="badge bg-success fs-6">Sudah</span>
                                <?php else: ?>
                                    <span class="badge bg-danger fs-6">Belum</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 border-end d-none d-lg-table-cell">
                                <?php if ($doc['holder_code']): ?>
                                    <span class="badge bg-primary fs-6 px-2 py-1">
                                        <?= esc($doc['holder_code']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 border-end d-none d-lg-table-cell">
                                <?php if (!empty($doc['holder_users'])): ?>
                                    <?php foreach ($doc['holder_users'] as $user): ?>
                                        <span class="badge bg-secondary mb-1 fs-6 px-2 py-1">
                                            <?= esc($user) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Belum ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell py-3 border-end">
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($doc['uploader_foto'])): ?>
                                        <img src="/uploads/foto_user/<?= esc($doc['uploader_foto']) ?>" 
                                            class="rounded-circle me-2" 
                                            width="32" 
                                            height="32"
                                            alt="Profil"
                                            style="object-fit: cover; border: 2px solid #f0f0f0;">
                                    <?php else: ?>
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                            style="width: 32px; height: 32px; min-width: 32px;">
                                            <i class="fas fa-user" style="font-size: 14px;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <div class="text-truncate" style="max-width: 120px;"
                                            title="<?= esc($doc['uploader_name'] ?? 'Unknown') ?>">
                                            <?= esc($doc['uploader_name'] ?? 'Unknown') ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= esc($doc['uploader_role'] ?? '-') ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell py-3 border-end">
                                <?php if (!empty($doc['uploaded_at'])): ?>
                                    <div class="fw-semibold">
                                        <?= date('d/m/Y', strtotime($doc['uploaded_at'])) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= date('H:i', strtotime($doc['uploaded_at'])) ?>
                                    </small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell py-3 border-end">
                                <?php if (!empty($doc['updated_at'])): ?>
                                    <div class="fw-semibold">
                                        <?= date('d/m/Y', strtotime($doc['updated_at'])) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= date('H:i', strtotime($doc['updated_at'])) ?>
                                    </small>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell py-3 border-end">
                                <?php
                                    $hasUpdate = !empty($doc['updated_by']);
                                    $name  = $hasUpdate
                                        ? ($doc['updater_name'] ?? 'Unknown')
                                        : ($doc['uploader_name'] ?? 'Unknown');

                                    $role  = $hasUpdate
                                        ? ($doc['updater_role'] ?? '-')
                                        : ($doc['uploader_role'] ?? '-');
                                ?>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="text-truncate fw-semibold" style="max-width: 120px;"
                                            title="<?= esc($name) ?>">
                                            <?= esc($name) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= esc($role) ?>
                                        </small>
                                    </div>
                                </div>

                                <?php if (!$hasUpdate): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-info-circle me-1"></i>Belum diperbarui
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-md-table-cell py-3 border-end">
                                <span class="badge rounded-pill fs-6 px-2 py-1 text-dark bg-<?= 
                                    $doc['status'] == 'approved' ? 'success' : 
                                    ($doc['status'] == 'save' ? 'info' : 'warning') ?>">
                                    <?= ucfirst($doc['status']) ?>
                                </span>
                                <?php if ($doc['tanggal_efektif']): ?>
                                    <div class="text-muted small mt-1">
                                        <?= date('d/m/Y', strtotime($doc['tanggal_efektif'])) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center py-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- 👁 DETAIL -->
                                    <a href="/iso00/show/<?= $doc['id'] ?>" 
                                    class="btn btn-outline-info border" 
                                    title="Detail Dokumen"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <!-- 📄 PDF -->
                                        <a href="/iso00/view/<?= $doc['id'] ?>" 
                                        class="btn btn-outline-primary border" 
                                        target="_blank" 
                                        title="Lihat PDF"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (
                                        session()->get('user_id') == $doc['uploaded_by'] ||
                                        session()->get('role') === 'admin'
                                    ): ?>
                                        <!-- ✏️ EDIT -->
                                        <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                        class="btn btn-outline-warning border" 
                                        title="Edit Dokumen"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (session()->get('role') === 'dept'): ?>
                                        <!-- ⬇️ DOWNLOAD BARCODE PNG -->
                                        <a href="<?= base_url('barcode/print/'.$doc['id']) ?>" 
                                        class="btn btn-outline-dark border"
                                        title="Download QR Code (PNG)"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if (empty($dokumen)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada dokumen ditemukan</p>
                    <?php if (in_array(session()->get('role'), ['admin'])): ?>
                    <a href="/iso00/create" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i>Upload Dokumen Pertama
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        Menampilkan <strong>1-<?= count($dokumen) ?></strong> dari <strong><?= count($dokumen) ?></strong> dokumen
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

/* Responsive untuk tabel */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
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
    
    // Initialize DataTable jika ada
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json' },
            pageLength: 10,
            lengthMenu: [[10,25,50,-1],[10,25,50,"Semua"]],
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
            drawCallback: function(settings) {
                // Reinitialize tooltips setelah DataTable redraw
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            }
        });
    }
});
</script>
<?= $this->endSection() ?>