<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Master Holder Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Master Holder Dokumen</h1>
            <p class="text-muted small mb-0">Kelola akses holder dokumen ISO</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-primary fs-6">
                Total: <?= !empty($holders) ? count($holders) : '0' ?> Holder
            </span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header dengan Search -->
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group" style="max-width: 400px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari holder atau dokumen...">
                        </div>
                        <a href="<?= base_url('access/create') ?>" class="btn btn-primary shadow-sm ms-3">
                            <i class="fas fa-plus me-2"></i>Tambah Holder
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 datatable" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:60px">No</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Holder</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Dokumen</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Pengguna</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:240px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($holders)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted fs-5 mb-2">Tidak ada holder ditemukan</p>
                                        <p class="text-muted small">Holder digunakan untuk mengelola akses dokumen ke pengguna</p>
                                        <a href="<?= base_url('access/create') ?>" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus me-2"></i>Tambah Holder Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($holders as $h): ?>
                            <tr class="hover-highlight">
                                <!-- No Urut -->
                                <td class="text-center text-muted fw-medium py-3 border-end"><?= $no++ ?></td>

                                <!-- Holder Info -->
                                <td class="py-3 border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="fas fa-folder" style="font-size: 16px;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-1">
                                                <?= esc($h['holder_code']) ?>
                                            </div>
                                            <?php if (!empty($h['description'])): ?>
                                            <div class="text-muted small">
                                                <i class="fas fa-info-circle me-1" style="font-size: 10px;"></i>
                                                <?= esc($h['description']) ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($h['created_at'])): ?>
                                            <div class="text-muted small mt-1">
                                                <i class="fas fa-calendar me-1" style="font-size: 10px;"></i>
                                                Dibuat: <?= date('d/m/Y', strtotime($h['created_at'])) ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Dokumen List -->
                                <td class="py-3 border-end">
                                    <?php if (!empty($h['dokumen_list'])): ?>
                                        <div class="mb-2">
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 fs-6 mb-2">
                                                <?= count($h['dokumen_list']) ?> Dokumen
                                            </span>
                                        </div>
                                        <div class="small">
                                            <?php 
                                            $maxDocs = 3; // Tampilkan maksimal 3 dokumen
                                            $displayDocs = array_slice($h['dokumen_list'], 0, $maxDocs);
                                            foreach ($displayDocs as $doc): 
                                            ?>
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="fas fa-file-alt text-danger me-2" style="font-size: 10px;"></i>
                                                    <span class="text-truncate" style="max-width: 180px;">
                                                        <?= esc($doc) ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <?php if (count($h['dokumen_list']) > $maxDocs): ?>
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-ellipsis-h me-1"></i>
                                                    +<?= count($h['dokumen_list']) - $maxDocs ?> dokumen lainnya
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Belum ada dokumen
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- User List -->
                                <td class="py-3 border-end">
                                    <?php if (!empty($h['user_list'])): ?>
                                        <div class="mb-2">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fs-6 mb-2">
                                                <?= count($h['user_list']) ?> Pengguna
                                            </span>
                                        </div>
                                        <div class="small">
                                            <?php 
                                            $maxUsers = 3; // Tampilkan maksimal 3 pengguna
                                            $displayUsers = array_slice($h['user_list'], 0, $maxUsers);
                                            foreach ($displayUsers as $user): 
                                            ?>
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="fas fa-user text-primary me-2" style="font-size: 10px;"></i>
                                                    <span class="text-truncate" style="max-width: 180px;">
                                                        <?= esc($user) ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <?php if (count($h['user_list']) > $maxUsers): ?>
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-ellipsis-h me-1"></i>
                                                    +<?= count($h['user_list']) - $maxUsers ?> pengguna lainnya
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Belum ada pengguna
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Action Buttons -->
                                <td class="text-center py-3">
                                    <div class="btn-group btn-group-sm d-none d-md-flex">
                                        <!-- Detail -->
                                        <a href="<?= base_url('access/detail/'.$h['holder_code']) ?>"
                                           class="btn btn-outline-info border"
                                           title="Detail Holder"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Manage Documents -->
                                        <a href="<?= base_url('access/edit-dokumen/'.$h['id']) ?>"
                                           class="btn btn-outline-warning border"
                                           title="Kelola Dokumen"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        
                                        <!-- Manage Users -->
                                        <a href="<?= base_url('access/edit-users/'.$h['id']) ?>"
                                           class="btn btn-outline-primary border"
                                           title="Kelola Pengguna"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        
                                        <!-- Dropdown for more options -->
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
                                                    <a class="dropdown-item" href="<?= base_url('access/edit/'.$h['id']) ?>">
                                                        <i class="fas fa-pen text-muted me-2"></i>
                                                        Edit Holder
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="<?= base_url('access/delete-holder/'.$h['id']) ?>"
                                                       class="dropdown-item text-danger"
                                                       onclick="return confirm('Yakin ingin menghapus holder ini? Semua akses user akan ikut terhapus.')">
                                                        <i class="fas fa-trash-alt me-2"></i>
                                                        Hapus Holder
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Mobile Actions -->
                                    <div class="d-md-none">
                                        <div class="btn-group-vertical btn-group-sm w-100">
                                            <a href="<?= base_url('access/detail/'.$h['holder_code']) ?>"
                                               class="btn btn-outline-info border">
                                                <i class="fas fa-eye me-2"></i>Detail
                                            </a>
                                            <a href="<?= base_url('access/edit-dokumen/'.$h['id']) ?>"
                                               class="btn btn-outline-warning border">
                                                <i class="fas fa-file-alt me-2"></i>Dokumen
                                            </a>
                                            <a href="<?= base_url('access/edit-users/'.$h['id']) ?>"
                                               class="btn btn-outline-primary border">
                                                <i class="fas fa-user-edit me-2"></i>Pengguna
                                            </a>
                                            <div class="btn-group">
                                                <a href="<?= base_url('access/edit/'.$h['id']) ?>"
                                                   class="btn btn-outline-secondary border">
                                                    <i class="fas fa-pen me-2"></i>Edit
                                                </a>
                                                <a href="<?= base_url('access/delete-holder/'.$h['id']) ?>"
                                                   class="btn btn-outline-danger border"
                                                   onclick="return confirm('Yakin ingin menghapus holder ini? Semua akses user akan ikut terhapus.')">
                                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                                </a>
                                            </div>
                                        </div>
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
                        <?php if (!empty($holders)) : ?>
                            Menampilkan <strong>1-<?= count($holders) ?></strong> dari <strong><?= count($holders) ?></strong> holder
                        <?php else: ?>
                            <strong>0</strong> holder ditemukan
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
.badge.bg-info {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

.badge.bg-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: #198754 !important;
}

/* Holder icon styling */
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-responsive {
        border: 1px solid #dee2e6;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .card-header .input-group {
        max-width: 100% !important;
        margin-bottom: 1rem;
    }
    
    .card-header .d-flex {
        flex-direction: column;
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
    
    // Make rows clickable to view detail
    document.querySelectorAll('.hover-highlight').forEach(row => {
        const detailLink = row.querySelector('a[title="Detail Holder"]');
        if (detailLink) {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on buttons or links
                if (!e.target.closest('a') && !e.target.closest('button')) {
                    detailLink.click();
                }
            });
        }
    });
    
    // Initialize DataTable if exists
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: { 
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json' 
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
            drawCallback: function(settings) {
                // Reinitialize tooltips after DataTable redraw
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