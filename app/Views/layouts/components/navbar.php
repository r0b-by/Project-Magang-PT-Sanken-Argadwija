
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid px-2 px-md-3">
        <!-- Menu Toggle for Mobile -->
        <button class="btn btn-sm btn-outline-secondary me-2 d-lg-none" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#offcanvasSidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Brand -->
        <span class="navbar-brand fw-bold">
            <i class="fas fa-folder-tree me-2 text-primary"></i>DMS
        </span>
        
        <!-- User Menu -->
        <div class="ms-auto">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center" 
                        type="button" 
                        data-bs-toggle="dropdown">
                    <?php if (session()->get('photo')): ?>
                        <img src="/uploads/foto_user/<?= session()->get('photo') ?>" 
                             class="rounded-circle me-2" 
                             width="32" 
                             height="32"
                             alt="Profile">
                    <?php else: ?>
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 32px; height: 32px;">
                            <?= strtoupper(substr(session()->get('fullname'), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <span class="d-none d-sm-inline">
                        <?= session()->get('fullname') ?>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="px-3 py-2 small">
                        <div class="fw-bold"><?= session()->get('fullname') ?></div>
                        <div class="text-muted"><?= ucfirst(session()->get('role')) ?></div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Menu</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">

        <?php 
        // FIX: tambahkan ini supaya tidak error
        $role = session()->get('role'); 

        if ($role === 'admin') {
            echo view('layouts/components/sidebar_admin');
        } elseif ($role === 'dept') {
            echo view('layouts/components/sidebar_dept');
        }
        ?>
        
    </div>
</div>