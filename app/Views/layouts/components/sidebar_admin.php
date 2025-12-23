<?php
$session = \Config\Services::session();
$role = $session->get('role');
?>
<?php if ($role === 'admin'): ?>
<!-- Sidebar -->
<div class="sidebar d-flex flex-column" style="background-color: #0F172A; color: white; min-height: 100vh;">
    <!-- HEADER -->
    <div class="p-4 text-center border-bottom" style="border-color: #1E293B !important;">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 60px; height: 60px; background-color: rgba(255, 255, 255, 0.1);">
            <i class="fas fa-folder-tree fa-lg" style="color: white;"></i>
        </div>
        <h5 class="mb-1 fw-bold text-white">DMS</h5>
        <span class="badge small" style="background-color: #2563EB; color: white;">Admin Panel</span>
    </div>

    <!-- MENU -->
    <div class="flex-grow-1 p-3 overflow-auto">
        <ul class="nav flex-column gap-1">
            <!-- DASHBOARD -->
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center 
                   <?= current_url() === base_url('dashboard/admin') ? 'active' : '' ?>"
                   style="<?= current_url() === base_url('dashboard/admin') 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="<?= base_url('dashboard/admin') ?>"
                   data-persistence-key="dashboard">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- MANAJEMEN -->
            <li class="nav-item mt-4 mb-2">
                <div class="small text-uppercase px-3 fw-semibold" 
                     style="color: rgba(255, 255, 255, 0.5); font-size: 0.7rem; letter-spacing: 0.5px;">
                    Manajemen
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                   <?= strpos(current_url(), base_url('users')) !== false ? 'active' : '' ?>"
                   style="<?= strpos(current_url(), base_url('users')) !== false 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="<?= base_url('users') ?>"
                   data-persistence-key="users">
                    <i class="fas fa-users me-3"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- DOKUMEN -->
            <li class="nav-item mt-4 mb-2">
                <div class="small text-uppercase px-3 fw-semibold" 
                     style="color: rgba(255, 255, 255, 0.5); font-size: 0.7rem; letter-spacing: 0.5px;">
                    Dokumen
                </div>
            </li>
            <li class="nav-item">
                <?php 
                $isIsoActive = strpos(current_url(), base_url('iso00')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between
                   <?= $isIsoActive ? 'active' : '' ?>"
                   style="<?= $isIsoActive 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="#" 
                   data-bs-toggle="collapse" 
                   data-bs-target="#dokumenIsoMenu"
                   data-persistence-key="iso"
                   id="isoDropdownToggle"
                   aria-expanded="<?= $isIsoActive ? 'true' : 'false' ?>">
                    <span class="d-flex align-items-center">
                        <i class="fas fa-file-alt me-3"></i>
                        <span>Dokumen ISO</span>
                    </span>
                    <i class="fas fa-chevron-down small dropdown-chevron"></i>
                </a>
                <div class="collapse <?= $isIsoActive ? 'show' : '' ?>" 
                     id="dokumenIsoMenu"
                     data-persistence-id="dokumenIsoMenu">
                    <ul class="nav flex-column ms-4 mt-1" style="border-left: 1px solid #1E293B;">

                        <!-- DAFTAR DOKUMEN -->
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                                <?= preg_match('#/iso00($|/)#', current_url()) && strpos(current_url(), 'history') === false
                                    ? 'active' : '' ?>"
                               style="<?= preg_match('#/iso00($|/)#', current_url()) && strpos(current_url(), 'history') === false
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('iso00') ?>"
                               data-persistence-key="iso-list">
                                <i class="fas fa-file me-3"></i>
                                <span>Daftar Dokumen</span>
                            </a>
                        </li>

                        <!-- HISTORY DOKUMEN -->
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                                <?= strpos(current_url(), base_url('iso00/history')) !== false
                                    ? 'active' : '' ?>"
                               style="<?= strpos(current_url(), base_url('iso00/history')) !== false
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('iso00/history/all') ?>"
                               data-persistence-key="iso-history">
                                <i class="fas fa-history me-3"></i>
                                <span>History Dokumen</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- BARCODE -->
            <li class="nav-item mt-4 mb-2">
                <div class="small text-uppercase px-3 fw-semibold" 
                     style="color: rgba(255, 255, 255, 0.5); font-size: 0.7rem; letter-spacing: 0.5px;">
                    Barcode
                </div>
            </li>
            <li class="nav-item">
                <?php 
                $isBarcodeActive = strpos(current_url(), base_url('barcode')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between
                   <?= $isBarcodeActive ? 'active' : '' ?>"
                   style="<?= $isBarcodeActive 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="#" 
                   data-bs-toggle="collapse" 
                   data-bs-target="#barcodeMenu"
                   data-persistence-key="barcode"
                   id="barcodeDropdownToggle"
                   aria-expanded="<?= $isBarcodeActive ? 'true' : 'false' ?>">
                    <span class="d-flex align-items-center">
                        <i class="fas fa-qrcode me-3"></i>
                        <span>Barcode Dokumen</span>
                    </span>
                    <i class="fas fa-chevron-down small dropdown-chevron"></i>
                </a>
                <div class="collapse <?= $isBarcodeActive ? 'show' : '' ?>" 
                     id="barcodeMenu"
                     data-persistence-id="barcodeMenu">
                    <ul class="nav flex-column ms-4 mt-1" style="border-left: 1px solid #1E293B;">
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                               <?= current_url() === base_url('barcode/generate') ? 'active' : '' ?>"
                               style="<?= current_url() === base_url('barcode/generate')
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('barcode/generate') ?>"
                               data-persistence-key="barcode-generate">
                                <i class="fas fa-plus-square me-3"></i>
                                <span>Generate Barcode</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                               <?= current_url() === base_url('barcode') ? 'active' : '' ?>"
                               style="<?= current_url() === base_url('barcode')
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('barcode') ?>"
                               data-persistence-key="barcode-list">
                                <i class="fas fa-list me-3"></i>
                                <span>Daftar Barcode</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- HAK AKSES DOKUMEN -->
            <li class="nav-item mt-4 mb-2">
                <div class="small text-uppercase px-3 fw-semibold" 
                     style="color: rgba(255, 255, 255, 0.5); font-size: 0.7rem; letter-spacing: 0.5px;">
                    Hak Akses
                </div>
            </li>
            <li class="nav-item">
                <?php 
                $isAccessActive = strpos(current_url(), base_url('access')) !== false;
                ?>
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between
                   <?= $isAccessActive ? 'active' : '' ?>"
                   style="<?= $isAccessActive 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="#" 
                   data-bs-toggle="collapse" 
                   data-bs-target="#accessMenu"
                   data-persistence-key="access"
                   id="accessDropdownToggle"
                   aria-expanded="<?= $isAccessActive ? 'true' : 'false' ?>">
                    <span class="d-flex align-items-center">
                        <i class="fas fa-id-badge me-3"></i>
                        <span>Master Holder</span>
                    </span>
                    <i class="fas fa-chevron-down small dropdown-chevron"></i>
                </a>
                <div class="collapse <?= $isAccessActive ? 'show' : '' ?>" 
                     id="accessMenu"
                     data-persistence-id="accessMenu">
                    <ul class="nav flex-column ms-4 mt-1" style="border-left: 1px solid #1E293B;">
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                               <?= current_url() === base_url('access') ? 'active' : '' ?>"
                               style="<?= current_url() === base_url('access')
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('access') ?>"
                               data-persistence-key="access-list">
                                <i class="fas fa-list me-3"></i>
                                <span>Daftar Holder</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                               <?= current_url() === base_url('access/create') ? 'active' : '' ?>"
                               style="<?= current_url() === base_url('access/create')
                                       ? 'background-color: #2563EB; color: white;' 
                                       : 'color: rgba(255, 255, 255, 0.7);' ?>"
                               href="<?= base_url('access/create') ?>"
                               data-persistence-key="access-create">
                                <i class="fas fa-plus-circle me-3"></i>
                                <span>Tambah Holder</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- AKTIVITAS -->
            <li class="nav-item mt-4 mb-2">
                <div class="small text-uppercase px-3 fw-semibold" 
                     style="color: rgba(255, 255, 255, 0.5); font-size: 0.7rem; letter-spacing: 0.5px;">
                    Aktivitas
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 rounded-3 d-flex align-items-center
                   <?= strpos(current_url(), base_url('activity')) !== false ? 'active' : '' ?>"
                   style="<?= strpos(current_url(), base_url('activity')) !== false 
                           ? 'background-color: #2563EB; color: white;' 
                           : 'color: rgba(255, 255, 255, 0.8);' ?>"
                   href="<?= base_url('activity') ?>"
                   data-persistence-key="activity">
                    <i class="fas fa-list-alt me-3"></i>
                    <span>Log Aktivitas</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="p-3 border-top text-center" style="border-color: #1E293B !important;">
        <small class="d-flex align-items-center justify-content-center" 
               style="color: rgba(255, 255, 255, 0.6);">
            <i class="fas fa-shield-alt me-2"></i>
            DMS v1.0
        </small>
    </div>
</div>
<?php endif; ?>