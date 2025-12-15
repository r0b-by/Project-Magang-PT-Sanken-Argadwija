<?php
$session = \Config\Services::session();
$role = $session->get('role');
?>

<?php if ($role === 'admin'): ?>
<div class="sidebar d-flex flex-column">

    <!-- HEADER -->
    <div class="p-3 text-center border-bottom">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-folder-tree me-2 text-primary"></i> DMS
        </h5>
        <small class="text-muted">Admin Panel</small>
    </div>

    <!-- MENU -->
    <div class="flex-grow-1 p-2">
        <ul class="nav flex-column">

            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link py-2 <?= current_url() === base_url('dashboard/admin') ? 'active' : '' ?>"
                   href="<?= base_url('dashboard/admin') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>

            <!-- ================= MANAGEMEN ================= -->
            <li class="nav-item mt-3">
                <div class="small text-muted px-3 mb-1">Manajemen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('users')) !== false ? 'active' : '' ?>"
                   href="<?= base_url('users') ?>">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>

            <!-- ================= DOKUMEN ================= -->
            <li class="nav-item mt-3">
                <div class="small text-muted px-3 mb-1">Dokumen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active' : '' ?>"
                   href="<?= base_url('iso00') ?>">
                    <i class="fas fa-file-alt me-2"></i> Dokumen ISO
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00/allHistory')) !== false ? 'active' : '' ?>"
                   href="<?= base_url('iso00/allHistory') ?>">
                    <i class="fas fa-list me-2"></i> History Dokumen
                </a>
            </li>

            <!-- ================= BARCODE ================= -->
            <li class="nav-item mt-3">
                <div class="small text-muted px-3 mb-1">Barcode</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('barcode')) !== false ? 'active' : '' ?>"
                   href="<?= base_url('barcode') ?>">
                    <i class="fas fa-qrcode me-2"></i> Barcode Dokumen
                </a>
            </li>

            <!-- ================= ISO ACCESS HOLDER ================= -->
            <li class="nav-item mt-3">
                <div class="small text-muted px-3 mb-1">Hak Akses Dokumen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= current_url() === base_url('access') ? 'active' : '' ?>"
                   href="<?= base_url('access') ?>">
                    <i class="fas fa-id-badge me-2"></i> Master Holder
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= current_url() === base_url('access/create') ? 'active' : '' ?>"
                   href="<?= base_url('access/create') ?>">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Holder
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('access/search')) !== false ? 'active' : '' ?>"
                   href="<?= base_url('access/search') ?>">
                    <i class="fas fa-search me-2"></i> Cari Holder
                </a>
            </li>

            <!-- ================= AKTIVITAS ================= -->
            <li class="nav-item mt-3">
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

    <!-- FOOTER -->
    <div class="p-2 border-top text-center small text-muted">
        DMS v1.0
    </div>
</div>
<?php endif; ?>
