<div class="sidebar d-flex flex-column">
    <!-- Logo -->
    <div class="p-3 text-center border-bottom">
        <h4 class="mb-0">
            <i class="fas fa-folder-tree me-2"></i>
            <span class="d-none d-lg-inline">DMS</span>
        </h4>
        <small class="text-muted d-none d-lg-block">Admin Panel</small>
    </div>
    
    <!-- Navigation -->
    <div class="flex-grow-1 p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('/dashboard/admin') ? 'active' : '' ?>" 
                   href="/dashboard/admin">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Manajemen User</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/users') !== false ? 'active' : '' ?>" 
                   href="/users">
                    <i class="fas fa-users me-2"></i>
                    <span>Data User</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Dokumen</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/iso00') !== false ? 'active' : '' ?>" 
                   href="/iso00">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Dokumen ISO</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/barcode') !== false ? 'active' : '' ?>" 
                href="/barcode">
                    <i class="fas fa-qrcode me-2"></i>
                    <span>Generate Barcode</span>
                </a>
            </li>

            <!-- Activity Log (BARU DITAMBAHKAN) -->
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Aktivitas</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/activity') !== false ? 'active' : '' ?>" 
                   href="/activity">
                    <i class="fas fa-history me-2"></i>
                    <span>Activity Log</span>
                </a>
            </li>

        </ul>
    </div>
    
    <!-- Footer -->
    <div class="p-3 border-top">
        <div class="text-center">
            <small class="text-muted">v1.0.0</small><br>
            <small class="text-muted">© <?= date('Y') ?> DMS</small>
        </div>
    </div>
</div>
