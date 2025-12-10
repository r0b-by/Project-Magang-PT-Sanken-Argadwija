<?php
$session = \Config\Services::session();
$role = $session->get('role'); // 'admin' atau 'dept'
?>

<?php if($role === 'admin'): ?>
    <!-- Sidebar Admin -->
    <div class="sidebar d-flex flex-column">
        <div class="p-2 text-center border-bottom">
            <h5 class="mb-0"><i class="fas fa-folder-tree me-2 text-primary"></i> DMS</h5>
            <small class="text-muted d-none d-lg-block small">Admin</small>
        </div>
        <div class="flex-grow-1 p-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link py-2 <?= current_url() == base_url('dashboard/admin') ? 'active' : '' ?>" 
                       href="<?= base_url('dashboard/admin') ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mt-2"><div class="small text-muted px-3 mb-1">Manajemen</div></li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('users')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('users') ?>">
                        <i class="fas fa-users me-2"></i>
                        <span>Users</span>
                    </a>
                </li>
                <!-- Dokumen & Barcode -->
                <li class="nav-item mt-2"><div class="small text-muted px-3 mb-1">Dokumen</div></li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('iso00') ?>">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>Dokumen ISO</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00/history')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('iso00/history') ?>">
                        <i class="fas fa-history me-2"></i>
                        <span>Riwayat Dokumen</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('barcode')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('barcode') ?>">
                        <i class="fas fa-qrcode me-2"></i>
                        <span>Barcode</span>
                    </a>
                </li>
                <li class="nav-item mt-2"><div class="small text-muted px-3 mb-1">Aktivitas</div></li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('activity')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('activity') ?>">
                        <i class="fas fa-history me-2"></i>
                        <span>Log</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="p-2 border-top"><div class="text-center small text-muted">v1.0</div></div>
    </div>

<?php elseif($role === 'dept'): ?>
    <!-- Sidebar Dept -->
    <div class="sidebar d-flex flex-column">
        <div class="p-2 text-center border-bottom">
            <h5 class="mb-0"><i class="fas fa-folder-tree me-2 text-primary"></i> DMS</h5>
            <small class="text-muted d-none d-lg-block small">Departemen</small>
        </div>
        <div class="flex-grow-1 p-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link py-2 <?= current_url() == base_url('dashboard/dept') ? 'active' : '' ?>" 
                       href="<?= base_url('dashboard/dept') ?>">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mt-2"><div class="small text-muted px-3 mb-1">Dokumen</div></li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('iso00') ?>">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>Dokumen Saya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2" href="<?= base_url('iso00/create') ?>">
                        <i class="fas fa-upload me-2"></i>
                        <span>Upload</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 <?= strpos(current_url(), base_url('iso00/history')) !== false ? 'active' : '' ?>" 
                       href="<?= base_url('iso00/history') ?>">
                        <i class="fas fa-history me-2"></i>
                        <span>Riwayat Dokumen</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="p-2 border-top"><div class="text-center small text-muted">v1.0</div></div>
    </div>
<?php endif; ?>
