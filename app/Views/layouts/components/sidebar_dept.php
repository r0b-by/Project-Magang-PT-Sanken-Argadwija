<div class="sidebar d-flex flex-column">
    <!-- Logo -->
    <div class="p-3 text-center border-bottom">
        <h4 class="mb-0">
            <i class="fas fa-folder-tree me-2"></i>
            <span class="d-none d-lg-inline">DMS</span>
        </h4>
        <small class="text-muted d-none d-lg-block">Departemen</small>
    </div>
    
    <!-- Navigation -->
    <div class="flex-grow-1 p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('/dashboard/dept') ? 'active' : '' ?>" 
                   href="/dashboard/dept">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Dokumen</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/iso00') !== false ? 'active' : '' ?>" 
                   href="/iso00">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Dokumen Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/iso00/create">
                    <i class="fas fa-upload me-2"></i>
                    <span>Upload Dokumen</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Footer -->
    <div class="p-3 border-top">
        <div class="text-center">
            <small class="text-muted">© <?= date('Y') ?> DMS</small>
        </div>
    </div>
</div>