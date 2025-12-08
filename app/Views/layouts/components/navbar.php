<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <button class="btn btn-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <span class="navbar-brand fw-bold text-primary">
            <i class="fas fa-folder-tree me-2"></i>DMS
        </span>
        
        <div class="ms-auto d-flex align-items-center">
            <!-- Notifications -->
            <div class="dropdown me-3">
                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Notifikasi</h6>
                    <a class="dropdown-item" href="#">
                        <small>Dokumen baru diupload</small>
                    </a>
                    <a class="dropdown-item" href="#">
                        <small>Scan berhasil dicatat</small>
                    </a>
                    <a class="dropdown-item" href="#">
                        <small>Update sistem tersedia</small>
                    </a>
                </div>
            </div>
            
            <!-- User Profile -->
            <div class="dropdown">
                <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <?php if (session()->get('photo')): ?>
                        <img src="/uploads/foto_user/<?= session()->get('photo') ?>" 
                             class="profile-img me-2" 
                             alt="Profile">
                    <?php else: ?>
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 40px; height: 40px;">
                            <?= strtoupper(substr(session()->get('fullname'), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="text-start">
                        <div class="fw-bold"><?= session()->get('fullname') ?></div>
                        <small class="text-muted"><?= ucfirst(session()->get('role')) ?></small>
                    </div>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user me-2"></i>Profil
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog me-2"></i>Pengaturan
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Offcanvas Sidebar for Mobile -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <?php 
        $role = session()->get('role');
        if ($role === 'admin') {
            echo view('layouts/components/sidebar_admin');
        } elseif ($role === 'dept') {
            echo view('layouts/components/sidebar_dept');
        } elseif ($role === 'karyawan') {
            echo view('layouts/components/sidebar_karyawan');
        }
        ?>
    </div>
</div>