<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container-fluid px-3 px-lg-4">
        <!-- Menu Toggle for Mobile -->
        <button class="btn btn-light border-0 me-2 d-lg-none rounded-circle p-2" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#offcanvasSidebar"
                style="width: 40px; height: 40px;">
            <i class="fas fa-bars text-primary"></i>
        </button>
        
        <!-- Brand -->
        <span class="navbar-brand fw-bold mb-0 d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                <i class="fas fa-folder-tree text-primary"></i>
            </div>
            <span class="d-none d-sm-inline">DMS</span>
        </span>
        
        <!-- User Menu -->
        <div class="ms-auto">
            <div class="dropdown">
                <button class="btn btn-light border rounded-pill d-flex align-items-center px-2 py-1" 
                        type="button" 
                        data-bs-toggle="dropdown">
                    <?php if (session()->get('photo')): ?>
                        <img src="/uploads/foto_user/<?= session()->get('photo') ?>" 
                             class="rounded-circle me-2" 
                             width="36" 
                             height="36"
                             style="object-fit: cover;"
                             alt="Profile">
                    <?php else: ?>
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-semibold" 
                             style="width: 36px; height: 36px;">
                            <?= strtoupper(substr(session()->get('fullname'), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <span class="d-none d-md-inline me-2 fw-medium text-dark">
                        <?= session()->get('fullname') ?>
                    </span>
                    <i class="fas fa-chevron-down text-muted small"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2" style="min-width: 200px;">
                    <div class="px-3 py-3 border-bottom">
                        <div class="fw-semibold text-dark"><?= session()->get('fullname') ?></div>
                        <div class="small text-muted mt-1">
                            <i class="fas fa-circle text-success me-1" style="font-size: 0.5rem;"></i>
                            <?= ucfirst(session()->get('role')) ?>
                        </div>
                    </div>
                    <a class="dropdown-item text-danger py-2 mt-1" href="/logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" style="width: 280px;">
    <div class="offcanvas-header border-bottom bg-light">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                <i class="fas fa-folder-tree text-primary"></i>
            </div>
            <div>
                <h6 class="offcanvas-title mb-0 fw-bold">DMS</h6>
                <small class="text-muted">Document Management</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <?php 
        $role = session()->get('role'); 
        if ($role === 'admin') {
            echo view('layouts/components/sidebar_admin');
        } elseif ($role === 'dept') {
            echo view('layouts/components/sidebar_dept');
        }
        ?>
    </div>
</div>

<style>
.navbar {
    height: 64px;
}

.navbar .btn-light:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.dropdown-menu {
    animation: slideDown 0.2s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    padding-left: 1.25rem;
}

.dropdown-item.text-danger:hover {
    background-color: #fff5f5;
}

.offcanvas-header {
    height: 80px;
}

.offcanvas {
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.btn-close:focus {
    box-shadow: none;
}

/* Profile Image */
img[alt="Profile"] {
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>