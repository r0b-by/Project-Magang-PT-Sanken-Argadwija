<!-- Mobile Header with Toggle Button -->
<div class="d-md-none fixed-top bg-primary text-white py-2 px-3 d-flex align-items-center justify-content-between" id="mobileHeader" style="height: 60px; z-index: 1030;">
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-white p-0 me-3" id="mobileToggle">
            <i data-feather="menu" width="20" height="20"></i>
        </button>
        <span class="fs-6 fw-semibold" style="font-family: 'Segoe UI', 'Poppins', sans-serif;">ISO System</span>
    </div>
    <div class="d-flex align-items-center">
        <small class="me-2" style="font-size: 0.75rem;">
            <?= session()->get('username') ?? 'User' ?>
        </small>
        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            <i data-feather="user" width="14" height="14"></i>
        </div>
    </div>
</div>

<!-- Sidebar -->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-primary text-white" style="width: 250px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 1040;" id="sidebar">
    <!-- Header with Close Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none">
            <span class="fs-5 fw-semibold" style="font-family: 'Segoe UI', 'Poppins', sans-serif; letter-spacing: 0.5px;">ISO System</span>
        </a>
        <button class="btn btn-close btn-close-white btn-sm d-md-none" id="closeSidebar"></button>
    </div>
    <hr class="text-white opacity-50 mb-3">

    <ul class="nav nav-pills flex-column mb-auto" style="font-family: 'Inter', 'Segoe UI', sans-serif;">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="<?= base_url('/dashboard') ?>" 
               class="nav-link text-white py-2 rounded-2 mb-1 
               <?= (uri_string() == 'dashboard') ? 'active bg-dark' : '' ?>"
               style="font-size: 0.875rem; transition: all 0.25s ease;">
                <i data-feather="home" class="me-2" width="15" height="15"></i> Dashboard
            </a>
        </li>

        <!-- Manage ISO (Admin Only) -->
        <?php if(session()->get('role') == 'admin'): ?>
        <li>
            <a class="nav-link text-white py-2 rounded-2 mb-1 d-flex justify-content-between align-items-center 
                <?= (strpos(uri_string(), 'iso_00') !== false || strpos(uri_string(), 'iso_001') !== false) ? 'active bg-dark' : '' ?>"
                data-bs-toggle="collapse" href="#collapseISO" role="button"
                aria-expanded="<?= (strpos(uri_string(), 'iso_00') !== false || strpos(uri_string(), 'iso_001') !== false) ? 'true' : 'false' ?>"
                aria-controls="collapseISO"
                style="font-size: 0.875rem; transition: all 0.25s ease;">
                <span><i data-feather="file-text" class="me-2" width="15" height="15"></i> Manage ISO</span>
                <i data-feather="chevron-down" width="14" height="14" id="isoChevron"></i>
            </a>

            <div class="collapse <?= (strpos(uri_string(), 'iso_00') !== false || strpos(uri_string(), 'iso_001') !== false) ? 'show' : '' ?>" 
                id="collapseISO">
                
                <ul class="list-unstyled fw-normal pb-1 small">

                    <!-- ==================== ISO 00 ==================== -->
                    <li>
                        <a class="nav-link text-white py-2 rounded-2 mb-1 d-flex justify-content-between align-items-center ps-3
                            <?= strpos(uri_string(), 'iso_00') !== false ? 'active bg-secondary' : '' ?>"
                            data-bs-toggle="collapse" href="#collapseISO00" role="button"
                            aria-expanded="<?= strpos(uri_string(), 'iso_00') !== false ? 'true' : 'false' ?>"
                            aria-controls="collapseISO00"
                            style="font-size: 0.85rem; transition: all 0.25s ease;">
                            <span><i data-feather="file-text" class="me-2" width="14" height="14"></i> ISO 00</span>
                            <i data-feather="chevron-down" width="12" height="12" id="iso00Chevron"></i>
                        </a>

                        <div class="collapse <?= strpos(uri_string(), 'iso_00') !== false ? 'show' : '' ?>" id="collapseISO00">
                            <ul class="list-unstyled fw-normal pb-1 small">

                                <!-- List Dokumen -->
                                <li class="nav-item">
                                    <a href="<?= base_url('/iso_00/list_dokumen') ?>"
                                        class="nav-link text-white py-2 rounded-2 mb-1 ps-4 
                                        <?= (uri_string() == 'iso_00' || uri_string() == 'iso_00/list_dokumen') ? 'active bg-warning text-dark' : '' ?>"
                                        style="font-size: 0.825rem; transition: all 0.25s ease;">
                                        <i data-feather="file-text" class="me-2" width="13" height="13"></i> List Dokumen
                                    </a>
                                </li>

                                <!-- List Barcode -->
                                <li class="nav-item">
                                    <a href="<?= base_url('/iso_00/list_barcode') ?>"
                                        class="nav-link text-white py-2 rounded-2 mb-1 ps-4 
                                        <?= (uri_string() == 'iso_00/list_barcode') ? 'active bg-warning text-dark' : '' ?>"
                                        style="font-size: 0.825rem; transition: all 0.25s ease;">
                                        <i data-feather="hash" class="me-2" width="13" height="13"></i> Barcode
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <!-- ==================== ISO 001 ==================== -->
                    <li>
                        <a class="nav-link text-white py-2 rounded-2 mb-1 d-flex justify-content-between align-items-center ps-3
                            <?= strpos(uri_string(), 'iso_001') !== false ? 'active bg-secondary' : '' ?>"
                            data-bs-toggle="collapse" href="#collapseISO001" role="button"
                            aria-expanded="<?= strpos(uri_string(), 'iso_001') !== false ? 'true' : 'false' ?>"
                            aria-controls="collapseISO001"
                            style="font-size: 0.85rem; transition: all 0.25s ease;">
                            <span><i data-feather="file" class="me-2" width="14" height="14"></i> ISO 001</span>
                            <i data-feather="chevron-down" width="12" height="12" id="iso001Chevron"></i>
                        </a>

                        <div class="collapse <?= strpos(uri_string(), 'iso_001') !== false ? 'show' : '' ?>" id="collapseISO001">
                            <ul class="list-unstyled fw-normal pb-1 small">

                                <li class="nav-item">
                                    <a href="<?= base_url('/iso_001') ?>"
                                        class="nav-link text-white py-2 rounded-2 mb-1 ps-4 
                                        <?= (uri_string() == 'iso_001' || uri_string() == 'iso_001/list') ? 'active bg-warning text-dark' : '' ?>"
                                        style="font-size: 0.825rem; transition: all 0.25s ease;">
                                        <i data-feather="list" class="me-2" width="13" height="13"></i> List Dokumen
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('/iso_001/barcode') ?>"
                                        class="nav-link text-white py-2 rounded-2 mb-1 ps-4 
                                        <?= (uri_string() == 'iso_001/barcode') ? 'active bg-warning text-dark' : '' ?>"
                                        style="font-size: 0.825rem; transition: all 0.25s ease;">
                                        <i data-feather="barcode" class="me-2" width="13" height="13"></i> List Barcode
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </li>

        <!-- Upload Dokumen -->
        <li>
            <a href="<?= base_url('/iso_00/upload') ?>" 
               class="nav-link text-white py-2 rounded-2 mb-1 
               <?= (uri_string() == 'iso_00/upload') ? 'active bg-dark' : '' ?>"
               style="font-size: 0.875rem; transition: all 0.25s ease;">
                <i data-feather="upload" class="me-2" width="15" height="15"></i> Upload Dokumen
            </a>
        </li>
        <?php endif; ?>

        <!-- Scan ISO (Karyawan) -->
        <?php if(session()->get('role') == 'karyawan'): ?>
        <li>
            <a href="<?= base_url('/iso_00/scan') ?>" 
               class="nav-link text-white py-2 rounded-2 mb-1 
               <?= (uri_string() == 'iso_00/scan') ? 'active bg-dark' : '' ?>"
               style="font-size: 0.875rem; transition: all 0.25s ease;">
                <i data-feather="qrcode" class="me-2" width="15" height="15"></i> Scan ISO
            </a>
        </li>
        <?php endif; ?>

        <!-- Logout -->
        <li>
            <a href="<?= base_url('/logout') ?>" 
               class="nav-link text-white py-2 rounded-2 mt-3"
               style="font-size: 0.875rem; transition: all 0.25s ease;">
                <i data-feather="log-out" class="me-2" width="15" height="15"></i> Logout
            </a>
        </li>
    </ul>

    <!-- Remove old toggle button inside sidebar -->
    <!-- <button class="btn btn-outline-light btn-sm mt-auto d-md-none d-flex align-items-center justify-content-center" 
            type="button" id="sidebarToggle"
            style="font-size: 0.8rem; padding: 0.25rem 0.5rem;">
        <i data-feather="menu" class="me-1" width="14" height="14"></i> Menu
    </button> -->
</div>

<!-- Overlay for mobile -->
<div class="d-md-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" 
     id="sidebarOverlay" 
     style="z-index: 1035; display: none;"></div>

<!-- CSS untuk hover effect yang lebih baik -->
<style>
/* Import Google Fonts untuk tampilan lebih estetik */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600&display=swap');

/* Gaya umum untuk link sidebar */
#sidebar .nav-link {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-weight: 400;
    letter-spacing: 0.3px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Hover effect yang lebih smooth dan nyaman */
#sidebar .nav-link:not(.active):hover {
    background-color: rgba(255, 255, 255, 0.15) !important;
    transform: translateX(4px);
    color: #e9ecef !important;
}

/* Active state yang lebih jelas */
#sidebar .nav-link.active {
    box-shadow: 0 2px 4px rgba(155, 139, 139, 0.1);
    font-weight: 500;
}

/* Chevron rotation animation */
#sidebar .collapsed i[data-feather="chevron-down"] {
    transition: transform 0.3s ease;
}

#sidebar .collapsed[aria-expanded="true"] i[data-feather="chevron-down"] {
    transform: rotate(180deg);
}

/* Submenu styling */
#sidebar .list-unstyled .nav-link {
    font-weight: 300;
}

/* Smooth collapse animation */
#sidebar .collapse {
    transition: all 0.3s ease;
}

/* Feather icon alignment */
#sidebar i[data-feather] {
    vertical-align: middle;
}

/* Background untuk item aktif yang lebih soft */
#sidebar .nav-link.active.bg-warning {
    background-color: #ffffff48 !important;
    color: #ffffffff !important;
}

/* Sidebar header */
#sidebar .fw-semibold {
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Tombol close sidebar */
#closeSidebar {
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

#closeSidebar:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Mobile header toggle button */
#mobileToggle {
    transition: all 0.2s ease;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#mobileToggle:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.05);
}

/* ============= RESPONSIVE STYLES ============= */

/* Mobile header */
#mobileHeader {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    padding-left: 15px;
    padding-right: 15px;
}

/* Sidebar untuk mobile */
@media (max-width: 767.98px) {
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 85%;
        max-width: 300px;
        height: 100vh;
        z-index: 1040;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
        overflow-y: auto;
        padding: 1rem !important;
    }
    
    #sidebar.show {
        transform: translateX(0);
    }
    
    /* Main content adjustment */
    body {
        padding-top: 60px !important;
    }
    
    /* Sidebar overlay */
    #sidebarOverlay.show {
        display: block !important;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Adjust sidebar content for mobile */
    #sidebar .nav-link {
        padding: 0.75rem 1rem !important;
        font-size: 0.9rem !important;
        min-height: 44px;
        display: flex;
        align-items: center;
    }
    
    #sidebar .nav-link i[data-feather] {
        width: 16px !important;
        height: 16px !important;
    }
    
    #sidebar .fs-5 {
        font-size: 1.1rem !important;
    }
    
    /* Better touch targets for mobile */
    #sidebar .nav-item,
    #sidebar li {
        margin-bottom: 0.5rem;
    }
    
    /* Adjust collapse menus for mobile */
    #sidebar .ps-3 {
        padding-left: 1rem !important;
    }
    
    #sidebar .ps-4 {
        padding-left: 2rem !important;
    }
    
    /* Make sure the sidebar doesn't get too tall */
    #sidebar .mb-auto {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
        padding-right: 5px;
    }
    
    /* Custom scrollbar for mobile sidebar */
    #sidebar .mb-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    #sidebar .mb-auto::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    
    #sidebar .mb-auto::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    /* Animation for sidebar items on mobile */
    #sidebar .nav-link {
        animation: slideInLeft 0.3s ease backwards;
    }
    
    #sidebar .nav-link:nth-child(1) { animation-delay: 0.1s; }
    #sidebar .nav-link:nth-child(2) { animation-delay: 0.15s; }
    #sidebar .nav-link:nth-child(3) { animation-delay: 0.2s; }
    #sidebar .nav-link:nth-child(4) { animation-delay: 0.25s; }
    #sidebar .nav-link:nth-child(5) { animation-delay: 0.3s; }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
}

/* Tablet adjustments */
@media (min-width: 768px) and (max-width: 991.98px) {
    #sidebar {
        width: 220px;
        position: fixed;
        left: 0;
        top: 0;
    }
    
    #mobileHeader,
    #sidebarOverlay {
        display: none !important;
    }
    
    /* Adjust main content margin */
    body {
        padding-left: 220px !important;
    }
    
    /* Ensure content is not hidden behind sidebar */
    .container, .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
}

/* Desktop */
@media (min-width: 992px) {
    #sidebar {
        position: fixed;
        left: 0;
        top: 0;
    }
    
    #mobileHeader,
    #sidebarOverlay {
        display: none !important;
    }
    
    /* Adjust main content margin */
    body {
        padding-left: 250px !important;
    }
    
    /* Ensure content is not hidden behind sidebar */
    .container, .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
}

/* Ensure content is not hidden behind sidebar on all screens */
main {
    width: 100%;
}

/* Improve touch experience on mobile */
@media (max-width: 767.98px) {
    /* Larger hit area for collapse toggles */
    [data-bs-toggle="collapse"] {
        cursor: pointer;
    }
    
    /* Prevent body scroll when sidebar is open */
    body.sidebar-open {
        overflow: hidden;
    }
}
</style>

<script>
// Disable right click
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
});

// Initialize feather icons
if (typeof feather !== 'undefined') {
    feather.replace();
}

// Mobile sidebar toggle functionality
const sidebar = document.getElementById('sidebar');
const mobileToggle = document.getElementById('mobileToggle');
const closeSidebar = document.getElementById('closeSidebar');
const overlay = document.getElementById('sidebarOverlay');

// Toggle sidebar from mobile header (HAMBURGER MENU)
mobileToggle.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Toggle sidebar
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
    
    // Toggle body class for scroll lock
    document.body.classList.toggle('sidebar-open');
    
    // Update hamburger icon to X when sidebar is open
    const icon = this.querySelector('i[data-feather]');
    if (sidebar.classList.contains('show')) {
        icon.setAttribute('data-feather', 'x');
    } else {
        icon.setAttribute('data-feather', 'menu');
    }
    feather.replace();
    
    console.log('Sidebar toggled. Open:', sidebar.classList.contains('show'));
});

// Close sidebar with close button (X inside sidebar)
closeSidebar.addEventListener('click', function() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    document.body.classList.remove('sidebar-open');
    
    // Update mobile toggle icon back to hamburger
    const mobileIcon = document.querySelector('#mobileToggle i[data-feather]');
    mobileIcon.setAttribute('data-feather', 'menu');
    feather.replace();
});

// Close sidebar with overlay click
overlay.addEventListener('click', function() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    document.body.classList.remove('sidebar-open');
    
    // Update mobile toggle icon back to hamburger
    const mobileIcon = document.querySelector('#mobileToggle i[data-feather]');
    mobileIcon.setAttribute('data-feather', 'menu');
    feather.replace();
});

// Close sidebar when clicking on a link (on mobile)
if (window.innerWidth <= 767) {
    document.querySelectorAll('#sidebar .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            // Don't close if it's a collapse toggle
            if (this.getAttribute('data-bs-toggle') !== 'collapse') {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
                
                // Update mobile toggle icon back to hamburger
                const mobileIcon = document.querySelector('#mobileToggle i[data-feather]');
                mobileIcon.setAttribute('data-feather', 'menu');
                feather.replace();
            }
        });
    });
}

// Close sidebar with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && window.innerWidth <= 767) {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.classList.remove('sidebar-open');
        
        // Update mobile toggle icon back to hamburger
        const mobileIcon = document.querySelector('#mobileToggle i[data-feather]');
        if (mobileIcon) {
            mobileIcon.setAttribute('data-feather', 'menu');
            feather.replace();
        }
    }
});

// Update chevron icons saat collapse terbuka/tutup
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
    button.addEventListener('click', function() {
        const chevron = this.querySelector('i[data-feather="chevron-down"]');
        if (chevron) {
            setTimeout(() => {
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 300);
        }
    });
});

// Handle window resize
function handleResize() {
    if (window.innerWidth >= 768) {
        // On tablet/desktop, ensure sidebar is visible
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.classList.remove('sidebar-open');
        
        // Update mobile toggle icon
        const mobileIcon = document.querySelector('#mobileToggle i[data-feather]');
        if (mobileIcon) {
            mobileIcon.setAttribute('data-feather', 'menu');
            feather.replace();
        }
    }
}

// Initial check on load
window.addEventListener('load', handleResize);
// Check on resize
window.addEventListener('resize', handleResize);

// Close all collapse menus when closing sidebar on mobile
function closeAllCollapses() {
    document.querySelectorAll('#sidebar .collapse.show').forEach(collapse => {
        const bsCollapse = new bootstrap.Collapse(collapse, {
            toggle: false
        });
        bsCollapse.hide();
    });
}

// Add event listeners for closing sidebar
closeSidebar.addEventListener('click', closeAllCollapses);
overlay.addEventListener('click', closeAllCollapses);

// Prevent body scroll when sidebar is open on mobile
sidebar.addEventListener('touchmove', function(e) {
    if (window.innerWidth <= 767) {
        e.preventDefault();
    }
}, { passive: false });

// Debugging - log sidebar state
console.log('Sidebar initialized');
console.log('Mobile toggle button:', document.getElementById('mobileToggle'));
</script>