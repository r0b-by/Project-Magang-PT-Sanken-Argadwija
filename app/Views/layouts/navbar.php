<!-- Navbar / Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid px-3 px-lg-4">

        <!-- Page Title -->
        <span class="ms-3 h5 mb-0 fw-semibold" 
              style="font-family: 'Poppins', 'Segoe UI', sans-serif; letter-spacing: 0.3px;">
            <?= $title ?? 'Dashboard' ?>
        </span>

        <!-- User Profile Section -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- User Info -->
            <div class="d-flex flex-column align-items-end d-none d-md-flex">
                <span class="text-dark fw-medium" 
                      style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                    <?= session()->get('fullname') ?? 'Guest' ?>
                </span>
                <span class="text-muted" 
                      style="font-family: 'Inter', sans-serif; font-size: 0.75rem;">
                    <?= ucfirst(session()->get('role') ?? 'User') ?>
                </span>
            </div>
            
            <!-- Profile Picture with Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                   id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                   style="transition: all 0.25s ease;">
                    <div class="position-relative">
                        <img src="<?= base_url('assets/img/user.png') ?>" 
                             alt="Profile" 
                             class="rounded-circle border border-light shadow-sm"
                             width="40" 
                             height="40"
                             style="transition: all 0.3s ease; object-fit: cover;">
                        <!-- Online Indicator -->
                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"
                              style="width: 10px; height: 10px;"></span>
                    </div>
                </a>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" 
                    aria-labelledby="userDropdown"
                    style="min-width: 200px; border-radius: 12px;">
                    <li>
                        <div class="dropdown-header px-3 py-2">
                            <div class="fw-semibold" 
                                 style="font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                                <?= session()->get('fullname') ?? 'Guest' ?>
                            </div>
                            <div class="text-muted" 
                                 style="font-family: 'Inter', sans-serif; font-size: 0.8rem;">
                                <?= ucfirst(session()->get('role') ?? 'User') ?>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" 
                           href="#"
                           style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            <i data-feather="user" class="me-2" width="16" height="16"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" 
                           href="#"
                           style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            <i data-feather="settings" class="me-2" width="16" height="16"></i>
                            Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2 text-danger" 
                           href="<?= base_url('/logout') ?>"
                           style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            <i data-feather="log-out" class="me-2" width="16" height="16"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Custom CSS untuk navbar -->
<style>
/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600&display=swap');

/* Navbar styling */
.navbar {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    backdrop-filter: blur(10px);
}

/* Sidebar toggle button hover effect */
#sidebarToggle {
    border-width: 1.5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#sidebarToggle:hover {
    background-color: #0d6efd;
    color: white;
    transform: rotate(90deg) scale(1.05);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
}

#sidebarToggle:active {
    transform: rotate(90deg) scale(0.95);
}

/* User profile dropdown styling */
.dropdown-toggle::after {
    margin-left: 0.5rem;
    transition: transform 0.2s ease;
}

.dropdown-toggle.show::after {
    transform: rotate(180deg);
}

/* Profile picture hover effect */
.dropdown-toggle img:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Dropdown item hover effect */
.dropdown-item {
    border-radius: 8px;
    margin: 2px 8px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(4px);
    color: #0d6efd !important;
}

/* Dropdown menu animation */
.dropdown-menu {
    animation: slideIn 0.2s ease-out;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Page title styling */
.navbar .h5 {
    color: #2c3e50;
    background: linear-gradient(135deg, #2c3e50 0%, #4a6491 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .navbar {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .container-fluid {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    
    .navbar .h5 {
        font-size: 1.1rem;
    }
    
    #sidebarToggle {
        width: 36px;
        height: 36px;
    }
    
    .dropdown-toggle img {
        width: 36px;
        height: 36px;
    }
}

/* Shadow for navbar */
.navbar.shadow-sm {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
}

/* Smooth transitions */
.navbar, .dropdown-toggle, .dropdown-item {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

<script>
// Disable klik kanan
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
});

// Toggle sidebar functionality
document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    const isHidden = sidebar.style.transform === 'translateX(-250px)';
    
    if (isHidden) {
        sidebar.style.transform = 'translateX(0)';
        sidebar.style.boxShadow = '2px 0 10px rgba(0,0,0,0.1)';
    } else {
        sidebar.style.transform = 'translateX(-250px)';
        sidebar.style.boxShadow = 'none';
    }
    
    // Rotate icon for visual feedback
    const icon = this.querySelector('i[data-feather]');
    if (icon) {
        if (!isHidden) {
            this.style.transform = 'rotate(0deg) scale(1)';
        }
    }
});

// Feather icons initialization
if (typeof feather !== 'undefined') {
    feather.replace();
}

// Dropdown animation
document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('show.bs.dropdown', function () {
        const dropdownMenu = this.nextElementSibling;
        dropdownMenu.style.animation = 'slideIn 0.2s ease-out';
    });
});

// Add active state to navbar items based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.navbar-nav .nav-link');
    
    navItems.forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
            item.style.color = '#0d6efd';
            item.style.fontWeight = '500';
        }
    });
});
</script>