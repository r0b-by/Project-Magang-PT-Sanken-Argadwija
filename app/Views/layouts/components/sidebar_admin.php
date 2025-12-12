<?php
$session = \Config\Services::session();
$role = $session->get('role'); // 'admin' atau 'dept'
?>

<?php if($role === 'admin'): ?>
<!-- ============================ -->
<!-- SIDEBAR ADMIN -->
<!-- ============================ -->
<div class="sidebar d-flex flex-column">

    <!-- Header -->
    <div class="p-2 text-center border-bottom">
        <h5 class="mb-0"><i class="fas fa-folder-tree me-2 text-primary"></i> DMS</h5>
        <small class="text-muted d-none d-lg-block small">Admin</small>
    </div>

    <!-- Menu -->
    <div class="flex-grow-1 p-2">
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link py-2 <?= current_url() == base_url('dashboard/admin') ? 'active' : '' ?>" 
                   href="<?= base_url('dashboard/admin') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>

            <!-- Manajemen -->
            <li class="nav-item mt-2">
                <div class="small text-muted px-3 mb-1">Manajemen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('users')) !== false ? 'active' : '' ?>" 
                   href="<?= base_url('users') ?>">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>

            <!-- Dokumen -->
            <li class="nav-item mt-2">
                <div class="small text-muted px-3 mb-1">Dokumen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active' : '' ?>" 
                   href="<?= base_url('iso00') ?>">
                    <i class="fas fa-file-alt me-2"></i> Dokumen ISO
                </a>
            </li>

            <!-- History semua dokumen -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('iso00/allHistory') ?>">
                    <i class="fa-solid fa-list me-2"></i> 
                    History File
                </a>
            </li>

            <!-- BARCODE -->
            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('barcode')) !== false ? 'active' : '' ?>" 
                   href="<?= base_url('barcode') ?>">
                    <i class="fas fa-qrcode me-2"></i> Barcode
                </a>
            </li>

            <!-- Hak Akses Dokumen -->
            <li class="nav-item mt-2">
                <div class="small text-muted px-3 mb-1">Hak Akses Dokumen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('access')) !== false ? 'active' : '' ?>" 
                href="<?= base_url('access') ?>">
                    <i class="fas fa-id-badge me-2"></i> Semua Hak Akses
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('access/create')) !== false ? 'active' : '' ?>" 
                href="<?= base_url('access/create') ?>">
                    <i class="fas fa-user-lock me-2"></i> Tambah Hak Akses
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('access/search')) !== false ? 'active' : '' ?>" 
                href="<?= base_url('access/search') ?>">
                    <i class="fas fa-search me-2"></i> Cari Dokumen (Holder Code)
                </a>
            </li>

            <!-- Aktivitas -->
            <li class="nav-item mt-2">
                <div class="small text-muted px-3 mb-1">Aktivitas</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('activity')) !== false ? 'active' : '' ?>" 
                   href="<?= base_url('activity') ?>">
                    <i class="fas fa-history me-2"></i> Log Aktivitas
                </a>
            </li>

        </ul>
    </div>

    <div class="p-2 border-top text-center small text-muted">v1.0</div>
</div>
<?php endif; ?>
