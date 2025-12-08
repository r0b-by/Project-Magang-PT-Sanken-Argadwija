<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4 px-3 px-lg-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-family: 'Poppins', 'Segoe UI', sans-serif; letter-spacing: 0.5px; font-size: 1.75rem;">
                List Dokumen ISO
            </h1>
            <p class="text-muted mb-0 d-flex align-items-center" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                <i data-feather="file-text" width="14" height="14" class="me-2 opacity-75"></i>
                Total: <?= count($dokumen) ?> dokumen
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?= base_url('iso_00/upload') ?>" class="btn btn-primary btn-sm d-flex align-items-center gap-1 py-2 px-3 rounded-2">
                <i data-feather="upload" width="14" height="14"></i>
                <span class="d-none d-md-inline">Upload Baru</span>
            </a>
            <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 py-2 px-3 rounded-2" id="filterToggle">
                <i data-feather="filter" width="14" height="14"></i>
                <span class="d-none d-md-inline">Filter</span>
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" 
             role="alert"
             style="border-radius: 10px; border-left: 4px solid #38b000; font-family: 'Inter', sans-serif;">
            <i data-feather="check-circle" class="me-2" width="18" height="18"></i>
            <div class="flex-grow-1" style="font-size: 0.875rem;">
                <?= session()->getFlashdata('success') ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter Section (Hidden by default) -->
    <div class="card border-0 shadow-sm mb-4" id="filterSection" style="display: none; border-radius: 12px;">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0" style="font-family: 'Inter', sans-serif; font-size: 0.9rem; font-weight: 600;">
                    <i data-feather="filter" width="14" height="14" class="me-2"></i>
                    Filter Dokumen
                </h6>
                <button class="btn btn-sm btn-outline-secondary d-md-none" id="closeFilterMobile">
                    <i data-feather="x" width="12" height="12"></i>
                </button>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <label class="form-label" style="font-family: 'Inter', sans-serif; font-size: 0.8rem;">Departemen</label>
                    <select class="form-select form-select-sm" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                        <option selected>Semua Departemen</option>
                        <option>HRD</option>
                        <option>IT</option>
                        <option>Production</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" style="font-family: 'Inter', sans-serif; font-size: 0.8rem;">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" style="font-family: 'Inter', sans-serif; font-size: 0.8rem;">Status</label>
                    <select class="form-select form-select-sm" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                        <option selected>Semua Status</option>
                        <option>Aktif</option>
                        <option>Revisi</option>
                        <option>Arsip</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-1">
                        <i data-feather="search" width="12" height="12"></i>
                        <span class="d-none d-md-inline">Terapkan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-family: 'Inter', sans-serif;">
                    <thead class="table-light" style="border-bottom: 2px solid #e9ecef;">
                        <tr>
                            <th class="py-3 px-3 px-md-4" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="hash" width="12" height="12" class="me-1"></i>
                                <span class="d-none d-md-inline">Kode</span>
                                <span class="d-md-none">Kode</span>
                            </th>
                            <th class="py-3 px-3 px-md-4 d-none d-md-table-cell" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="calendar" width="12" height="12" class="me-1"></i>
                                Tanggal
                            </th>
                            <th class="py-3 px-3 px-md-4 d-none d-lg-table-cell" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="briefcase" width="12" height="12" class="me-1"></i>
                                Departemen
                            </th>
                            <th class="py-3 px-3 px-md-4" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="file" width="12" height="12" class="me-1"></i>
                                <span class="d-none d-md-inline">Nama File</span>
                                <span class="d-md-none">File</span>
                            </th>
                            <th class="py-3 px-3 px-md-4 d-none d-xl-table-cell" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="user" width="12" height="12" class="me-1"></i>
                                User
                            </th>
                            <th class="py-3 px-3 px-md-4 d-none d-lg-table-cell" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                <i data-feather="clock" width="12" height="12" class="me-1"></i>
                                Update
                            </th>
                            <th class="py-3 px-3 px-md-4 text-center" style="font-size: 0.825rem; font-weight: 600; color: #495057;">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($dokumen)): ?>
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i data-feather="file" width="48" height="48" class="text-muted mb-3 opacity-50"></i>
                                        <p class="text-muted mb-1" style="font-size: 0.9rem;">Belum ada dokumen</p>
                                        <a href="<?= base_url('iso_00/upload') ?>" class="btn btn-sm btn-outline-primary mt-2">
                                            <i data-feather="upload" width="12" height="12" class="me-1"></i>
                                            Upload Dokumen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($dokumen as $d): ?>
                                <tr class="hover-row" style="transition: all 0.2s ease; border-bottom: 1px solid #f8f9fa;">
                                    <!-- Kode Dokumen -->
                                    <td class="py-3 px-3 px-md-4" style="font-size: 0.875rem;">
                                        <div class="d-flex flex-column">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill mb-1" 
                                                  style="font-size: 0.75rem; font-weight: 500;">
                                                <?= esc($d['kode_dokumen']) ?>
                                            </span>
                                            <!-- Mobile only: Show date -->
                                            <span class="d-md-none text-muted" style="font-size: 0.75rem;">
                                                <i data-feather="calendar" width="10" height="10" class="me-1"></i>
                                                <?= date('d M', strtotime($d['tanggal'])) ?>
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Tanggal (Desktop only) -->
                                    <td class="py-3 px-3 px-md-4 d-none d-md-table-cell" style="font-size: 0.875rem;">
                                        <?= date('d M Y', strtotime($d['tanggal'])) ?>
                                    </td>
                                    
                                    <!-- Departemen (Desktop only) -->
                                    <td class="py-3 px-3 px-md-4 d-none d-lg-table-cell" style="font-size: 0.875rem;">
                                        <?= esc($d['departement']) ?>
                                    </td>
                                    
                                    <!-- Nama File -->
                                    <td class="py-3 px-3 px-md-4" style="font-size: 0.875rem;">
                                        <div class="d-flex align-items-center">
                                            <i data-feather="file-text" width="14" height="14" class="me-2 text-muted d-none d-md-block"></i>
                                            <div class="d-flex flex-column">
                                                <span class="text-truncate" style="max-width: 200px;" title="<?= esc($d['nama_file']) ?>">
                                                    <?= esc($d['nama_file']) ?>
                                                </span>
                                                <!-- Mobile only: Show user and department -->
                                                <div class="d-md-none mt-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <small class="text-muted d-flex align-items-center" style="font-size: 0.7rem;">
                                                            <i data-feather="user" width="10" height="10" class="me-1"></i>
                                                            <?= esc($d['user_update']) ?>
                                                        </small>
                                                        <small class="text-muted d-flex align-items-center" style="font-size: 0.7rem;">
                                                            <i data-feather="briefcase" width="10" height="10" class="me-1"></i>
                                                            <?= esc($d['departement']) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- User Update (Desktop only) -->
                                    <td class="py-3 px-3 px-md-4 d-none d-xl-table-cell" style="font-size: 0.875rem;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 24px; height: 24px;">
                                                <i data-feather="user" width="10" height="10" class="text-info"></i>
                                            </div>
                                            <?= esc($d['user_update']) ?>
                                        </div>
                                    </td>
                                    
                                    <!-- Waktu Update (Desktop only) -->
                                    <td class="py-3 px-3 px-md-4 d-none d-lg-table-cell" style="font-size: 0.875rem;">
                                        <div class="d-flex flex-column">
                                            <span><?= date('d M Y', strtotime($d['tanggal_update'])) ?></span>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <?= esc($d['jam_update']) ?>
                                            </small>
                                        </div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="py-3 px-3 px-md-4">
                                        <div class="d-flex gap-1 justify-content-center">      
                                            <!-- Edit Button -->
                                            <a href="<?= base_url('iso_00/edit/'.$d['id']) ?>" 
                                               class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center py-1 px-2 rounded-2"
                                               title="Edit Dokumen"
                                               style="font-size: 0.75rem; transition: all 0.2s ease; min-width: 36px;">
                                                <i data-feather="edit" width="12" height="12"></i>
                                                <span class="d-none d-sm-inline ms-1">Edit</span>
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <a href="<?= base_url('iso_00/delete/'.$d['id']) ?>" 
                                               onclick="return confirmDelete(event, '<?= esc($d['nama_file']) ?>')"
                                               class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center py-1 px-2 rounded-2"
                                               title="Hapus Dokumen"
                                               style="font-size: 0.75rem; transition: all 0.2s ease; min-width: 36px;">
                                                <i data-feather="trash-2" width="12" height="12"></i>
                                                <span class="d-none d-sm-inline ms-1">Hapus</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination (if needed) -->
    <?php if(isset($pager) && $pager->getPageCount() > 1): ?>
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm flex-wrap justify-content-center">
                <?php if($pager->hasPrevious()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                            <i data-feather="chevron-left" width="14" height="14"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php foreach($pager->links() as $link): ?>
                    <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $link['uri'] ?>">
                            <?= $link['title'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <?php if($pager->hasNext()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                            <i data-feather="chevron-right" width="14" height="14"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Custom CSS -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap');

/* Table hover effects */
.hover-row:hover {
    background-color: rgba(67, 97, 238, 0.03) !important;
    transform: translateX(2px);
    box-shadow: inset 4px 0 0 #4361ee;
}

/* Button hover effects */
.btn-outline-primary:hover {
    background-color: #4361ee;
    color: white;
    border-color: #4361ee;
}

.btn-outline-warning:hover {
    background-color: #ffc107;
    color: #212529;
    border-color: #ffc107;
}

.btn-outline-danger:hover {
    background-color: #e63946;
    color: white;
    border-color: #e63946;
}

/* Badge styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Pagination styling */
.page-link {
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem;
    border: none;
    color: #495057;
    margin: 0 2px;
    border-radius: 6px !important;
}

.page-item.active .page-link {
    background-color: #4361ee;
    border-color: #4361ee;
}

.page-link:hover {
    background-color: #f8f9fa;
    color: #4361ee;
}

/* ============= RESPONSIVE STYLES ============= */

/* Mobile adjustments */
@media (max-width: 576px) {
    .container-fluid {
        padding: 1rem !important;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem;
    }
    
    .d-flex.align-items-center.gap-2 {
        width: 100%;
        justify-content: space-between;
    }
    
    .btn {
        flex: 1;
        min-width: 0;
    }
    
    h1.fw-bold {
        font-size: 1.5rem !important;
        text-align: center;
    }
    
    .alert {
        margin: 0.5rem !important;
        font-size: 0.8rem !important;
    }
}

/* Tablet adjustments */
@media (min-width: 577px) and (max-width: 767.98px) {
    .container-fluid {
        padding: 1.5rem !important;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem !important;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
}

/* Large mobile to tablet */
@media (max-width: 767.98px) {
    .table-responsive {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .table thead {
        display: none;
    }
    
    .table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 0.75rem;
    }
    
    .table tbody tr.hover-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0.75rem !important;
        border: none;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .table tbody td:last-child {
        border-bottom: none;
        justify-content: center;
        padding-top: 1rem !important;
    }
    
    .table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        font-size: 0.8rem;
        color: #495057;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    /* Add data-labels for mobile view */
    .table tbody td:nth-child(1)::before { content: "Kode:"; }
    .table tbody td:nth-child(2)::before { content: "Tanggal:"; }
    .table tbody td:nth-child(3)::before { content: "Departemen:"; }
    .table tbody td:nth-child(4)::before { content: "File:"; }
    .table tbody td:nth-child(5)::before { content: "User:"; }
    .table tbody td:nth-child(6)::before { content: "Update:"; }
    
    /* Hide certain columns on mobile */
    .table tbody td.d-none {
        display: none !important;
    }
    
    /* Adjust badge size on mobile */
    .badge {
        font-size: 0.7rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    /* Filter section adjustments */
    #filterSection .row {
        margin: 0 -0.5rem;
    }
    
    #filterSection .col-12 {
        padding: 0 0.5rem;
        margin-bottom: 1rem;
    }
    
    /* Button adjustments */
    .btn-group .btn {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Desktop adjustments */
@media (min-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .container-fluid {
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }
}

/* Smooth transitions */
.btn, .hover-row, .badge {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Animation for filter section */
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

#filterSection.show {
    display: block;
    animation: slideDown 0.3s ease-out;
}

/* Empty state styling */
td .d-flex.flex-column.align-items-center.justify-content-center {
    padding: 3rem 1rem;
}

/* Text truncation */
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Mobile specific button adjustments */
@media (max-width: 767.98px) {
    .btn-sm {
        min-width: 40px;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-sm span {
        font-size: 0.7rem;
    }
    
    /* Improve touch targets */
    [data-feather] {
        pointer-events: none;
    }
    
    /* Make sure buttons don't wrap */
    .d-flex.gap-1 {
        flex-wrap: nowrap;
    }
}

/* Filter section mobile improvements */
@media (max-width: 767.98px) {
    #filterSection {
        position: fixed;
        top: 60px;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1040;
        border-radius: 0;
        margin: 0;
        overflow-y: auto;
        background: white;
    }
    
    #closeFilterMobile {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 2;
    }
}

/* Pagination responsive */
@media (max-width: 767.98px) {
    .pagination {
        margin: 0;
        padding: 0;
    }
    
    .page-item {
        margin: 2px;
    }
    
    .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>

<script>
// Disable right click
document.addEventListener("contextmenu", e => e.preventDefault());

// Feather icons initialization
if (typeof feather !== 'undefined') {
    feather.replace();
}

// Filter toggle functionality
const filterToggle = document.getElementById('filterToggle');
const filterSection = document.getElementById('filterSection');
const closeFilterMobile = document.getElementById('closeFilterMobile');

if (filterToggle && filterSection) {
    filterToggle.addEventListener('click', function() {
        if (window.innerWidth <= 767.98) {
            // Mobile behavior: Show as full screen modal
            filterSection.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent body scroll
        } else {
            // Desktop behavior: Toggle normally
            if (filterSection.style.display === 'none' || filterSection.style.display === '') {
                filterSection.style.display = 'block';
                filterSection.classList.add('show');
                
                // Change icon to X
                const icon = this.querySelector('i[data-feather]');
                if (icon) {
                    icon.setAttribute('data-feather', 'x');
                    feather.replace();
                }
                
                if (window.innerWidth >= 768) {
                    this.innerHTML = `
                        <i data-feather="x" width="14" height="14"></i>
                        <span class="d-none d-md-inline">Tutup Filter</span>
                    `;
                }
            } else {
                filterSection.style.display = 'none';
                filterSection.classList.remove('show');
                
                // Change icon back to filter
                const icon = this.querySelector('i[data-feather]');
                if (icon) {
                    icon.setAttribute('data-feather', 'filter');
                    feather.replace();
                }
                
                if (window.innerWidth >= 768) {
                    this.innerHTML = `
                        <i data-feather="filter" width="14" height="14"></i>
                        <span class="d-none d-md-inline">Filter</span>
                    `;
                }
            }
        }
        
        // Update feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
}

// Close filter on mobile
if (closeFilterMobile) {
    closeFilterMobile.addEventListener('click', function() {
        filterSection.style.display = 'none';
        document.body.style.overflow = ''; // Restore body scroll
        
        // Update filter toggle button
        if (filterToggle) {
            const icon = filterToggle.querySelector('i[data-feather]');
            if (icon) {
                icon.setAttribute('data-feather', 'filter');
                feather.replace();
            }
            
            if (window.innerWidth >= 768) {
                filterToggle.innerHTML = `
                    <i data-feather="filter" width="14" height="14"></i>
                    <span class="d-none d-md-inline">Filter</span>
                `;
            }
        }
    });
}

// Close filter when clicking outside on mobile
if (window.innerWidth <= 767.98) {
    document.addEventListener('click', function(event) {
        if (filterSection && filterSection.style.display === 'block' && 
            !filterSection.contains(event.target) && 
            event.target !== filterToggle) {
            filterSection.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
}

// Custom delete confirmation with sweet alert style
function confirmDelete(event, fileName) {
    event.preventDefault();
    const url = event.currentTarget.href;
    
    // Create custom confirmation modal
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.cssText = `
        display: block;
        background-color: rgba(0,0,0,0.5);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;
    `;
    
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                            <i data-feather="alert-triangle" width="24" height="24" class="text-danger"></i>
                        </div>
                        <h5 class="modal-title mb-2" style="font-family: 'Inter', sans-serif; font-size: 1.1rem; font-weight: 600;">
                            Konfirmasi Hapus
                        </h5>
                        <p class="text-muted mb-0" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            Apakah Anda yakin ingin menghapus dokumen:<br>
                            <strong>"${fileName}"</strong>
                        </p>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-4" id="cancelDelete" 
                                style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            Batal
                        </button>
                        <button type="button" class="btn btn-danger btn-sm px-4" id="confirmDelete" 
                                style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Update feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
    
    // Handle cancel
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.body.removeChild(modal);
    });
    
    // Handle confirm
    document.getElementById('confirmDelete').addEventListener('click', function() {
        window.location.href = url;
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            document.body.removeChild(modal);
        }
    });
    
    return false;
}

// Row hover effect (desktop only)
if (window.innerWidth >= 768) {
    document.querySelectorAll('.hover-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(67, 97, 238, 0.03)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
}

// Tooltip for truncated text
document.querySelectorAll('.text-truncate').forEach(element => {
    element.addEventListener('mouseenter', function() {
        if (this.offsetWidth < this.scrollWidth) {
            this.title = this.textContent;
        }
    });
});

// Convert table to mobile view on small screens
function adjustTableForMobile() {
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    
    if (window.innerWidth <= 767.98) {
        // Add data-labels to each cell
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        
        tbody.querySelectorAll('tr').forEach((row, rowIndex) => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, cellIndex) => {
                if (cellIndex < headers.length && !cell.classList.contains('d-none')) {
                    cell.setAttribute('data-label', headers[cellIndex]);
                }
            });
        });
    }
}

// Call on load and resize
window.addEventListener('load', adjustTableForMobile);
window.addEventListener('resize', adjustTableForMobile);

// Handle window resize for filter
window.addEventListener('resize', function() {
    if (window.innerWidth >= 768 && filterSection) {
        // Reset filter section for desktop
        filterSection.style.position = '';
        filterSection.style.top = '';
        filterSection.style.left = '';
        filterSection.style.right = '';
        filterSection.style.bottom = '';
        filterSection.style.borderRadius = '12px';
        filterSection.style.margin = '0 0 1rem 0';
        document.body.style.overflow = '';
    }
});
</script>

<?= $this->endSection() ?>