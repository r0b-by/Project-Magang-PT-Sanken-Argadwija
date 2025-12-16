<?php
$session = \Config\Services::session();
$role = $session->get('role');
?>
<?php if($role === 'dept'): ?>
<div class="sidebar d-flex flex-column bg-white shadow-sm">
    <!-- HEADER -->
    <div class="p-4 text-center border-bottom">
        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
            <i class="fas fa-folder-tree fa-lg text-success"></i>
        </div>
        <h5 class="mb-1 fw-bold text-dark">DMS</h5>
        <span class="badge bg-light text-success border small">Departemen</span>
    </div>

    <!-- MENU -->
    <div class="flex-grow-1 p-3 overflow-auto">
        <ul class="nav flex-column gap-1">
            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= current_url() == base_url('dashboard/dept') ? 'active bg-success text-white' : 'text-dark' ?>" 
                   href="<?= base_url('dashboard/dept') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>

            <!-- DOKUMEN -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Dokumen</div>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active bg-success text-white' : 'text-dark' ?>" 
                   href="<?= base_url('iso00') ?>">
                    <i class="fas fa-file-alt me-2"></i>Dokumen Saya
                </a>
            </li>

            <!-- BARCODE 
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Barcode</div>
            </li>-->
            <!--<li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= strpos(current_url(), base_url('barcode')) !== false ? 'active bg-success text-white' : 'text-dark' ?>" 
                   href="<?= base_url('barcode') ?>">
                    <i class="fas fa-qrcode me-2"></i>Barcode Dokumen
                </a>
            </li>-->
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="p-3 border-top text-center bg-light">
        <small class="text-muted d-flex align-items-center justify-content-center">
            <i class="fas fa-shield-alt me-2 text-success"></i>DMS v1.0
        </small>
    </div>
</div>
<?php endif; ?>