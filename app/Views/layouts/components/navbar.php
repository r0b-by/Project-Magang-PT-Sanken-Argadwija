<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #FFFFFF; border-bottom: 1px solid #E2E8F0;">
    <div class="container-fluid">
        <!-- Sidebar Toggle untuk Mobile -->
        <button class="btn d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars" style="color: #0F172A;"></i>
        </button>
        
        <!-- Logo/Title -->
        <a class="navbar-brand fw-bold ms-2 ms-lg-0" href="#" style="color: #0F172A;">
            <i class="fas fa-folder-tree me-2" style="color: #2563EB;"></i>
            Document Management System
        </a>
        
        <!-- Right Side Menu -->
        <div class="d-flex align-items-center">
            <!-- Notifikasi -->
            <div class="dropdown me-3">
                <button class="btn btn-link text-decoration-none position-relative p-0" 
                        type="button" 
                        data-bs-toggle="dropdown"
                        style="color: #64748B;">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                          style="background-color: #16A34A; font-size: 0.6rem;">
                        3
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width: 300px;">
                    <li><h6 class="dropdown-header fw-bold" style="color: #0F172A;">Notifikasi</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-start" href="#">
                            <div class="me-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 32px; height: 32px; background-color: #16A34A20;">
                                    <i class="fas fa-check-circle" style="color: #16A34A; font-size: 0.8rem;"></i>
                                </div>
                            </div>
                            <div>
                                <small class="fw-semibold" style="color: #0F172A;">Dokumen disetujui</small>
                                <p class="mb-0 small" style="color: #64748B;">ISO-001 telah disetujui</p>
                                <small class="text-muted">2 menit yang lalu</small>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-center small" href="#" style="color: #2563EB;">
                            Lihat semua notifikasi
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- User Profile -->
            <div class="dropdown">
                <button class="btn d-flex align-items-center p-0" 
                        type="button" 
                        data-bs-toggle="dropdown"
                        style="border: none; background: none;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 36px; height: 36px; background-color: #2563EB; color: white;">
                        <span class="fw-bold">A</span>
                    </div>
                    <div class="d-none d-md-block text-start">
                        <div class="small fw-semibold" style="color: #0F172A;">Admin User</div>
                        <div class="xsmall" style="color: #64748B;">Administrator</div>
                    </div>
                    <i class="fas fa-chevron-down ms-2 small" style="color: #64748B;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fas fa-user me-2" style="color: #64748B;"></i>
                            <span style="color: #0F172A;">Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fas fa-cog me-2" style="color: #64748B;"></i>
                            <span style="color: #0F172A;">Pengaturan</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fas fa-sign-out-alt me-2" style="color: #64748B;"></i>
                            <span style="color: #0F172A;">Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>