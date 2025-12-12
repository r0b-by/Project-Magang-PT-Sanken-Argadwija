<?php
$session = \Config\Services::session();
$role = $session->get('role'); // 'admin' atau 'dept'
?>

<?php if($role === 'dept'): ?>
<!-- ============================ -->
<!-- SIDEBAR DEPARTEMEN -->
<!-- ============================ -->
<div class="sidebar d-flex flex-column">

    <!-- Header -->
    <div class="p-2 text-center border-bottom">
        <h5 class="mb-0"><i class="fas fa-folder-tree me-2 text-primary"></i> DMS</h5>
        <small class="text-muted d-none d-lg-block small">Departemen</small>
    </div>

    <!-- Menu -->
    <div class="flex-grow-1 p-2">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link py-2 <?= current_url() == base_url('dashboard/dept') ? 'active' : '' ?>" 
                   href="<?= base_url('dashboard/dept') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mt-2">
                <div class="small text-muted px-3 mb-1">Dokumen</div>
            </li>

            <li class="nav-item">
                <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active' : '' ?>" 
                   href="<?= base_url('iso00') ?>">
                    <i class="fas fa-file-alt me-2"></i> Dokumen Saya
                </a>
            </li>

        </ul>
    </div>

    <div class="p-2 border-top text-center small text-muted">v1.0</div>
</div>

<?php endif; ?>