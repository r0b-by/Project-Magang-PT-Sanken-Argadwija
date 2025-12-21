<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Detail Holder: <?= esc($holder['holder_code']) ?><?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">
                <i class="fas fa-folder me-2 text-primary"></i>Detail Holder
            </h1>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary fs-6 px-3 py-2 me-2">
                    <?= esc($holder['holder_code']) ?>
                </span>
                <?php if (!empty($holder['description'])): ?>
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i><?= esc($holder['description']) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <a href="<?= base_url('access/edit-dokumen/'.$holder['id']) ?>" class="btn btn-warning shadow-sm me-2">
                <i class="fas fa-file-alt me-2"></i>Kelola Dokumen
            </a>
            <a href="<?= base_url('access/edit-users/'.$holder['id']) ?>" class="btn btn-primary shadow-sm me-2">
                <i class="fas fa-user-edit me-2"></i>Kelola User
            </a>
            <a href="<?= base_url('access') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-folder fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Dokumen</h6>
                            <h3 class="fw-bold mb-0"><?= !empty($dokumen) ? count($dokumen) : '0' ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total User</h6>
                            <h3 class="fw-bold mb-0"><?= !empty($users) ? count($users) : '0' ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 rounded p-3">
                            <i class="fas fa-calendar-alt fa-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Dibuat</h6>
                            <h5 class="fw-bold mb-0">
                                <?= !empty($holder['created_at']) ? date('d M Y', strtotime($holder['created_at'])) : '-' ?>
                            </h5>
                            <small class="text-muted">
                                <?= !empty($holder['created_at']) ? date('H:i', strtotime($holder['created_at'])) : '' ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Dokumen Section -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-file-alt text-warning me-2"></i>Daftar Dokumen
                        </h5>
                        <span class="badge bg-warning bg-opacity-10 text-warning">
                            <?= !empty($dokumen) ? count($dokumen) : '0' ?> dokumen
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($dokumen)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:50px">#</th>
                                        <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Kode Dokumen</th>
                                        <th class="text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa;">Nama Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dokumen as $index => $d): ?>
                                    <tr class="hover-highlight">
                                        <td class="text-center text-muted fw-medium py-2 border-end"><?= $index + 1 ?></td>
                                        <td class="py-2 border-end">
                                            <div class="fw-semibold text-dark">
                                                <i class="fas fa-barcode text-primary me-2" style="font-size: 12px;"></i>
                                                <?= esc($d['kode_dokumen']) ?>
                                            </div>
                                        </td>
                                        <td class="py-2">
                                            <div class="text-truncate" style="max-width: 250px;">
                                                <?= esc($d['nama_dokumen_internal']) ?>
                                            </div>
                                            <?php if (!empty($d['versi'])): ?>
                                            <div class="text-muted small mt-1">
                                                <i class="fas fa-code-branch me-1" style="font-size: 10px;"></i>
                                                Versi: <?= esc($d['versi']) ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-2">Belum ada dokumen yang di-assign</p>
                            <a href="<?= base_url('access/edit-dokumen/'.$holder['id']) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Dokumen
                            </a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="<?= base_url('access/edit-dokumen/'.$holder['id']) ?>" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>Kelola Dokumen
                    </a>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-users text-primary me-2"></i>Daftar Pengguna
                        </h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            <?= !empty($users) ? count($users) : '0' ?> pengguna
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($users)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa; width:50px">#</th>
                                        <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">User</th>
                                        <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Role</th>
                                        <th class="text-center text-muted text-uppercase small fw-semibold" style="background-color: #f8f9fa; width:100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $index => $u): ?>
                                    <tr class="hover-highlight">
                                        <td class="text-center text-muted fw-medium py-2 border-end"><?= $index + 1 ?></td>
                                        <td class="py-2 border-end">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                    style="width: 32px; height: 32px; min-width: 32px; font-size: 12px;">
                                                    <?= strtoupper(substr($u['fullname'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark"><?= esc($u['fullname']) ?></div>
                                                    <div class="text-muted small">@<?= esc($u['username']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2 border-end">
    <?php 
    // Safely get role with default value
    $role = $u['role'] ?? 'user'; // Default to 'user' if role doesn't exist
    $roleClass = '';
    $roleIcon = '';
    
    switch($role) {
        case 'admin':
            $roleClass = 'danger';
            $roleIcon = 'user-shield';
            break;
        case 'dept':
            $roleClass = 'primary';
            $roleIcon = 'user-tie';
            break;
        default:
            $roleClass = 'info';
            $roleIcon = 'user';
    }
    ?>
    <span class="badge bg-<?= $roleClass ?> bg-opacity-10 text-<?= $roleClass ?> border-0 px-2 py-1">
        <i class="fas fa-<?= $roleIcon ?> me-1"></i>
        <?= ucfirst($role) ?>
    </span>
</td>
                                        <td class="text-center py-2">
                                            <a href="<?= base_url('access/remove-user/'.$u['access_id']) ?>"
                                               onclick="return confirm('Hapus user ini dari holder <?= esc($holder['holder_code']) ?>?')"
                                               class="btn btn-outline-danger btn-sm border"
                                               title="Hapus User"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-2">Belum ada pengguna yang di-assign</p>
                            <a href="<?= base_url('access/edit-users/'.$holder['id']) ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Pengguna
                            </a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="<?= base_url('access/edit-users/'.$holder['id']) ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit me-2"></i>Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="d-flex justify-content-between mt-3">
        <a href="<?= base_url('access') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Holder
        </a>
        <div>
            <a href="<?= base_url('access/edit/'.$holder['id']) ?>" class="btn btn-outline-secondary me-2">
                <i class="fas fa-pen me-2"></i>Edit Holder
            </a>
            <a href="<?= base_url('access/delete-holder/'.$holder['id']) ?>"
               class="btn btn-outline-danger"
               onclick="return confirm('Yakin ingin menghapus holder ini? Semua akses user akan ikut terhapus.')">
                <i class="fas fa-trash-alt me-2"></i>Hapus Holder
            </a>
        </div>
    </div>
</div>

<style>
/* Custom Styles untuk tampilan seperti Excel */
.card {
    border-radius: 0.5rem;
    overflow: hidden;
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
    padding: 0.75rem 0.5rem;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table tbody td {
    padding: 0.75rem 0.5rem;
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

/* Stats card styling */
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-success.bg-gradient {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

/* Badge opacity styling */
.badge.bg-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
    color: #ffc107 !important;
}

.badge.bg-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

.badge.bg-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
    color: #dc3545 !important;
}

.badge.bg-info {
    background-color: rgba(13, 202, 240, 0.1) !important;
    color: #0dcaf0 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.justify-content-between.align-items-center.mb-4 > div:last-child {
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-4 > div:last-child a {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
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
});
</script>
<?= $this->endSection() ?>