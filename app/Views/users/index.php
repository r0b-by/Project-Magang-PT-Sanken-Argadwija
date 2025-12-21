<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb & Page Title -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Manajemen User</h2>
                <p class="text-muted mb-0">Kelola data pengguna sistem</p>
            </div>
            <a href="/users/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm">
        <!-- Card Header dengan Search -->
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari user berdasarkan nama atau username...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Body dengan Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" style="border-color: #dee2e6;">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-muted text-uppercase small fw-semibold text-center border-end" style="background-color: #f8f9fa;">No</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">User</th>
                            <th class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Email</th>
                            <th width="120" class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Role</th>
                            <th width="100" class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Status</th>
                            <th width="180" class="text-muted text-uppercase small fw-semibold border-end" style="background-color: #f8f9fa;">Terakhir Aktif</th>
                            <th class="text-center text-muted text-uppercase small fw-semibold" width="150" style="background-color: #f8f9fa;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                        <tr class="hover-highlight">
                            <td class="text-muted fw-medium text-center py-3 border-end"><?= $no++ ?></td>
                            <td class="py-3 border-end">
                                <div class="d-flex align-items-center">
                                    <?php if ($user['foto']): ?>
                                        <img src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                            class="rounded-circle me-3 border" 
                                            width="40" 
                                            height="40"
                                            alt="<?= $user['fullname'] ?>"
                                            style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-semibold" 
                                             style="width: 40px; height: 40px; font-size: 16px;">
                                            <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold text-dark mb-0"><?= $user['fullname'] ?></div>
                                        <div class="d-flex align-items-center mt-1">
                                            <small class="text-muted">@<?= $user['username'] ?></small>
                                            <?php if($user['is_online'] == 1): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border-0 px-2 py-1 ms-2" style="font-size: 0.65rem;">
                                                    <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                                                    Online
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 border-end">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-muted me-2" style="font-size: 0.875rem;"></i>
                                    <span class="text-dark"><?= $user['email'] ?? '-' ?></span>
                                </div>
                            </td>
                            <td class="py-3 border-end">
                                <span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'dept' ? 'primary' : 'info') ?> bg-opacity-10 text-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'dept' ? 'primary' : 'info') ?> border-0 px-3 py-2 d-inline-flex align-items-center" style="min-width: 80px;">
                                    <i class="fas fa-<?= $user['role'] == 'admin' ? 'user-shield' : ($user['role'] == 'dept' ? 'user-tie' : 'user') ?> me-2" style="font-size: 0.75rem;"></i>
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td class="py-3 border-end">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-<?= $user['status_akun'] == 'aktif' ? 'success' : 'secondary' ?> bg-opacity-10 text-<?= $user['status_akun'] == 'aktif' ? 'success' : 'secondary' ?> border-0 px-3 py-2 d-inline-flex align-items-center" style="min-width: 70px;">
                                        <i class="fas fa-circle me-2" style="font-size: 6px;"></i>
                                        <?= ucfirst($user['status_akun']) ?>
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 border-end">
                                <?php if (!empty($user['last_login'] ?? null)): ?>
                                    <div class="text-muted small">
                                        <div><?= date('d M Y', strtotime($user['last_login'])) ?></div>
                                        <div class="text-muted"><?= date('H:i', strtotime($user['last_login'])) ?></div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small">Belum pernah</span>
                                <?php endif; ?> 
                            </td>
                            <td class="text-center py-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-light text-muted border" 
                                            title="Lihat Detail"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                       class="btn btn-outline-light text-muted border"
                                       title="Edit User"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-light text-muted border"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            title="Lainnya">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-key text-muted me-2"></i>
                                                Reset Password
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-lock text-muted me-2"></i>
                                                Nonaktifkan Akun
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a href="/users/delete/<?= $user['id'] ?>" 
                                               class="dropdown-item text-danger"
                                               onclick="return confirm('Yakin ingin menghapus user <?= addslashes($user['fullname']) ?>?')">
                                                <i class="fas fa-trash-alt me-2"></i>
                                                Hapus User
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer dengan Pagination -->
        <div class="card-footer bg-white border-top">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="text-muted mb-0 small">
                        Menampilkan <strong>1-<?= count($users) ?></strong> dari <strong><?= count($users) ?></strong> user
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
/* Custom Styles untuk menyesuaikan dengan referensi */
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

/* Hover effect yang lebih subtle */
.hover-highlight:hover {
    background-color: #f8fafc !important;
    cursor: pointer;
}

/* Excel-like styling */
.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered > :not(caption) > * {
    border-width: 1px;
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

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-size: 1.2rem;
    color: #6c757d;
}

.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 0.125rem;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.dropdown-menu {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.border {
    border-color: #e9ecef !important;
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
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>
<?= $this->endSection() ?>