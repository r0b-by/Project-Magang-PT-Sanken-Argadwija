<?php
$session = \Config\Services::session();
$role = $session->get('role');
?>
<?php if ($role === 'admin'): ?>
<div class="sidebar d-flex flex-column bg-white shadow-sm">
    <!-- HEADER -->
    <div class="p-4 text-center border-bottom">
        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
            <i class="fas fa-folder-tree fa-lg text-primary"></i>
        </div>
        <h5 class="mb-1 fw-bold text-dark">DMS</h5>
        <span class="badge bg-light text-primary border small">Admin Panel</span>
    </div>

    <!-- MENU -->
    <div class="flex-grow-1 p-3 overflow-auto">
        <ul class="nav flex-column gap-1">
            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= current_url() === base_url('dashboard/admin') ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="<?= base_url('dashboard/admin') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>

            <!-- MANAJEMEN -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Manajemen</div>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= strpos(current_url(), base_url('users')) !== false ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="<?= base_url('users') ?>">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </li>

            <!-- DOKUMEN -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Dokumen</div>
            </li>
            <li class="nav-item">
                <?php 
                $isIsoActive = strpos(current_url(), base_url('iso00')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between <?= $isIsoActive ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#dokumenIsoMenu" aria-expanded="<?= $isIsoActive ? 'true' : 'false' ?>">
                    <span><i class="fas fa-file-alt me-2"></i>Dokumen ISO</span>
                    <i class="fas fa-chevron-down small"></i>
                </a>
                <div class="collapse <?= $isIsoActive ? 'show' : '' ?>" id="dokumenIsoMenu">
                    <ul class="nav flex-column ms-3 mt-1">

                        <!-- ================= DAFTAR DOKUMEN ================= -->
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 
                                <?= preg_match('#/iso00($|/)#', current_url()) && strpos(current_url(), 'history') === false
                                    ? 'active bg-primary text-white'
                                    : 'text-dark' ?>"
                            href="<?= base_url('iso00') ?>">
                                <i class="fas fa-file me-2"></i>Daftar Dokumen
                            </a>
                        </li>

                        <!-- ================= HISTORY DOKUMEN ================= -->
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 
                                <?= strpos(current_url(), base_url('iso00/history')) !== false
                                    ? 'active bg-primary text-white'
                                    : 'text-dark' ?>"
                            href="<?= base_url('iso00/history/all') ?>">
                                <i class="fas fa-history me-2"></i>History Dokumen
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- BARCODE -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Barcode</div>
            </li>
            <li class="nav-item">
                <?php 
                $isBarcodeActive = strpos(current_url(), base_url('barcode')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between <?= $isBarcodeActive ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#barcodeMenu" aria-expanded="<?= $isBarcodeActive ? 'true' : 'false' ?>">
                    <span><i class="fas fa-qrcode me-2"></i>Barcode Dokumen</span>
                    <i class="fas fa-chevron-down small"></i>
                </a>
                <div class="collapse <?= $isBarcodeActive ? 'show' : '' ?>" id="barcodeMenu">
                    <ul class="nav flex-column ms-3 mt-1">
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 text-dark"
                               href="<?= base_url('barcode/generate') ?>">
                                <i class="fas fa-plus-square me-2"></i>Generate Barcode
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 text-dark"
                               href="<?= base_url('barcode') ?>">
                                <i class="fas fa-list me-2"></i>Daftar Barcode
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- HAK AKSES DOKUMEN -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Hak Akses</div>
            </li>
            <li class="nav-item">
                <?php 
                $isAccessActive = strpos(current_url(), base_url('access')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between <?= $isAccessActive ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#accessMenu" aria-expanded="<?= $isAccessActive ? 'true' : 'false' ?>">
                    <span><i class="fas fa-id-badge me-2"></i>Master Holder</span>
                    <i class="fas fa-chevron-down small"></i>
                </a>
                <div class="collapse <?= $isAccessActive ? 'show' : '' ?>" id="accessMenu">
                    <ul class="nav flex-column ms-3 mt-1">
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 <?= current_url() === base_url('access') ? 'active bg-primary text-white' : 'text-dark' ?>"
                               href="<?= base_url('access') ?>">
                                <i class="fas fa-list me-2"></i>Daftar Holder
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 <?= current_url() === base_url('access/create') ? 'active bg-primary text-white' : 'text-dark' ?>"
                               href="<?= base_url('access/create') ?>">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Holder
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 <?= strpos(current_url(), base_url('access/search')) !== false ? 'active bg-primary text-white' : 'text-dark' ?>"
                               href="<?= base_url('access/search') ?>">
                                <i class="fas fa-search me-2"></i>Cari Holder
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- AKTIVITAS -->
            <li class="nav-item mt-3 mb-2">
                <div class="small text-uppercase text-muted px-3 fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Aktivitas</div>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 <?= strpos(current_url(), base_url('activity')) !== false ? 'active bg-primary text-white' : 'text-dark' ?>"
                   href="<?= base_url('activity') ?>">
                    <i class="fas fa-list-alt me-2"></i>Log Aktivitas
                </a>
            </li>
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="p-3 border-top text-center bg-light">
        <small class="text-muted d-flex align-items-center justify-content-center">
            <i class="fas fa-shield-alt me-2 text-primary"></i>DMS v1.0
        </small>
    </div>
</div>

<?php endif; ?>