<div class="sidebar d-flex flex-column">
    <!-- Logo -->
    <div class="p-3 text-center border-bottom">
        <h4 class="mb-0">
            <i class="fas fa-folder-tree me-2"></i>
            <span class="d-none d-lg-inline">DMS</span>
        </h4>
        <small class="text-muted d-none d-lg-block">Karyawan</small>
    </div>
    
    <!-- Navigation -->
    <div class="flex-grow-1 p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('/dashboard/karyawan') ? 'active' : '' ?>" 
                   href="/dashboard/karyawan">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Scan -->
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Scan</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/iso001/scan') !== false ? 'active' : '' ?>" 
                   href="/iso001/scan">
                    <i class="fas fa-qrcode me-2"></i>
                    <span>Scan Barcode</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/iso001') !== false && strpos(current_url(), '/scan') === false ? 'active' : '' ?>" 
                   href="/iso001">
                    <i class="fas fa-history me-2"></i>
                    <span>Riwayat Scan</span>
                </a>
            </li>

            <!-- Dokumen -->
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">Dokumen</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/iso00') !== false ? 'active' : '' ?>" 
                   href="/iso00">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Dokumen Tersedia</span>
                </a>
            </li>

            <!-- Activity -->
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted ms-3">History</small>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= strpos(current_url(), '/activity') !== false ? 'active' : '' ?>" 
                   href="/activity">
                    <i class="fas fa-history me-2"></i>
                    <span>Aktivitas</span>
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
