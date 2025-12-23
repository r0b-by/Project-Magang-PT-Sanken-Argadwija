<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dokumen ISO<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3" style="background: #F8FAFC; min-height: 100vh;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold" style="color: #0F172A;">Dokumen ISO</h1> 
            <p class="small mb-0" style="color: #64748B;">Kelola dokumen sistem manajemen</p>
        </div>
        <?php if (in_array(session()->get('role'), ['admin'])): ?>
        <a href="/iso00/create" class="btn" style="background: #2563EB; color: white; border: none; border-radius: 8px;">
            <i class="fas fa-plus me-2"></i>Upload Dokumen
        </a>
        <?php endif; ?>
    </div>
    
    <!-- Table Card -->
    <div class="card" style="border: 1px solid #E2E8F0; border-radius: 12px; background: white;">
        <!-- Card Header dengan Search -->
        <div class="card-header py-3" style="background: #FFFFFF; border-bottom: 1px solid #E2E8F0;">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="input-group" style="max-width: 400px;">
                        <span class="input-group-text" style="background: #F8FAFC; border: 1px solid #E2E8F0; color: #64748B;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari dokumen berdasarkan kode atau nama..." 
                               style="border: 1px solid #E2E8F0; border-left: none; color: #0F172A;">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 datatable">
                    <thead>
                        <tr style="background:#E8EEF6;"> <!-- lebih tajam dari #F1F5F9 -->
                        <th class="text-center small fw-semibold py-3" width="60"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            No
                        </th>

                        <th class="small fw-semibold py-3"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            No. Dok
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            File
                        </th>

                        <th class="small fw-semibold py-3 text-center"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Barcode
                        </th>

                        <!-- Header Status Utama -->
                        <th class="small fw-semibold py-3 d-none d-md-table-cell" width="110"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Status
                        </th>

                        <!-- Header Revisi -->
                        <th class="small fw-semibold py-3 d-none d-md-table-cell" width="110"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Revisi
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            No. Holder
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Uploader
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Uploaded
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Updated By
                        </th>

                        <th class="small fw-semibold py-3 d-none d-lg-table-cell"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Updated
                        </th>

                        <th class="text-center small fw-semibold py-3" width="140"
                            style="color:#475569;border:1px solid #CBD5E1;border-bottom:2px solid #94A3B8;">
                            Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumen as $doc): ?>
                        <tr class="table-row">
                            <td class="text-center py-3" style="color: #64748B; border: 1px solid #E2E8F0;"><?= $no++ ?></td>
                            <td class="py-3" style="border: 1px solid #E2E8F0;">
                                <div>
                                    <div class="fw-semibold" style="color: #0F172A;"><?= $doc['kode_dokumen'] ?></div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf me-2" style="color: #EF4444;"></i>
                                    <div>
                                        <div class="text-truncate" style="max-width: 180px; color: #0F172A;" title="<?= $doc['nama_file'] ?>">
                                            <?= $doc['nama_file'] ?>
                                        </div>
                                        <small style="color: #64748B;">
                                            <?php 
                                            $filePath = WRITEPATH . 'uploads/' . $doc['nama_file'];
                                            if (file_exists($filePath)) {
                                                echo round(filesize($filePath) / 1024, 2) . ' KB';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center" style="border: 1px solid #E2E8F0;">
                                <?php if (!empty($doc['barcode'])): ?>
                                    <img 
                                        src="<?= base_url('assets/images/barcode-status/barcode-ready.png') ?>"
                                        alt="Sudah"
                                        title="Sudah"
                                        width="50"
                                    >
                                <?php else: ?>
                                    <img 
                                        src="<?= base_url('assets/images/barcode-status/barcode-not-ready.png') ?>"
                                        alt="Belum"
                                        title="Belum"
                                        width="50"
                                    >
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-md-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <?php
                                    if ($doc['status'] === 'approved') {
                                        $badgeColor = '#059669'; // Hijau lebih lembut
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Approved';
                                    } elseif ($doc['status'] === 'save' || $doc['status'] === 'revisi') {
                                        $badgeColor = '#2563EB'; // Biru lebih cerah
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Draft';
                                    } else { // unsave
                                        $badgeColor = '#6B7280'; // Abu-abu netral
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Unsaved';
                                    }
                                ?>
                                <span class="badge rounded-pill px-2 py-1" style="background: <?= $badgeColor ?>; color: <?= $textColor ?>; font-size: 12px; font-weight: 500;">
                                    <?= $statusText ?>
                                </span>
                            </td>

                            <!-- Kolom Revisi -->
                            <td class="d-none d-md-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <?php
                                    if ($doc['status'] === 'unsave') {
                                        $badgeColor = '#DC2626'; // Merah lebih lembut
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Belum Disimpan';
                                    } elseif ($doc['status'] === 'save') {
                                        $badgeColor = '#F59E0B'; // Oranye/kuning
                                        $textColor = '#1F2937'; // Teks gelap untuk kontras
                                        $statusText = 'Menunggu Revisi';
                                    } elseif ($doc['status'] === 'revisi' && isset($doc['revision_no'])) {
                                        $badgeColor = '#D97706'; // Oranye lebih gelap
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Revisi - ' . $doc['revision_no'];
                                    } else { // approved
                                        $badgeColor = '#059669'; // Hijau konsisten
                                        $textColor = '#FFFFFF';
                                        $statusText = 'Disetujui';
                                    }
                                ?>
                                <span class="badge rounded-pill px-2 py-1" style="background: <?= $badgeColor ?>; color: <?= $textColor ?>; font-size: 12px; font-weight: 500;">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td class="py-3 d-none d-lg-table-cell text-center" style="border:1px solid #E2E8F0;">
                                <?php if (!empty($doc['holder_code'])): ?>
                                    <span class="badge rounded-pill fs- px-3 py-1"
                                        style="
                                            background:#E0E7FF;        /* blue-100 */
                                            color:#1E40AF;             /* blue-800 */
                                            font-size:13px;
                                            font-weight:600;
                                            letter-spacing:0.3px;
                                        ">
                                        <?= esc($doc['holder_code']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="d-none d-lg-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($doc['uploader_foto'])): ?>
                                        <img src="/uploads/foto_user/<?= esc($doc['uploader_foto']) ?>" 
                                            class="rounded-circle me-2" 
                                            width="32" 
                                            height="32"
                                            alt="Profil"
                                            style="object-fit: cover; border: 2px solid #E2E8F0;">
                                    <?php else: ?>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                            style="width: 32px; height: 32px; min-width: 32px; background: #2563EB; color: white;">
                                            <i class="fas fa-user" style="font-size: 14px;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-truncate" style="max-width: 120px; color: #0F172A;"
                                            title="<?= esc($doc['uploader_name'] ?? 'Unknown') ?>">
                                            <?= esc($doc['uploader_name'] ?? 'Unknown') ?>
                                        </div>
                                        <small style="color: #64748B;">
                                            <?= esc($doc['uploader_role'] ?? '-') ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <?php if (!empty($doc['uploaded_at'])): ?>
                                    <div class="fw-semibold" style="color: #0F172A;">
                                        <?= date('d/m/Y', strtotime($doc['uploaded_at'])) ?>
                                    </div>
                                    <small style="color: #64748B;">
                                        <?= date('H:i', strtotime($doc['uploaded_at'])) ?>
                                    </small>
                                <?php else: ?>
                                    <span style="color: #64748B;">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <?php
                                    $hasUpdate = !empty($doc['updated_by']);
                                    $name  = $hasUpdate
                                        ? ($doc['updater_name'] ?? 'Unknown')
                                        : ($doc['uploader_name'] ?? 'Unknown');

                                    $role  = $hasUpdate
                                        ? ($doc['updater_role'] ?? '-')
                                        : ($doc['uploader_role'] ?? '-');
                                ?>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="text-truncate fw-semibold" style="max-width: 120px; color: #0F172A;"
                                            title="<?= esc($name) ?>">
                                            <?= esc($name) ?>
                                        </div>
                                        <small style="color: #64748B;">
                                            <?= esc($role) ?>
                                        </small>
                                    </div>
                                </div>

                                <?php if (!$hasUpdate): ?>
                                    <div class="small mt-1" style="color: #64748B;">
                                        <i class="fas fa-info-circle me-1"></i>Belum diperbarui
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell py-3" style="border: 1px solid #E2E8F0;">
                                <?php if (!empty($doc['updated_at'])): ?>
                                    <div class="fw-semibold" style="color: #0F172A;">
                                        <?= date('d/m/Y', strtotime($doc['updated_at'])) ?>
                                    </div>
                                    <small style="color: #64748B;">
                                        <?= date('H:i', strtotime($doc['updated_at'])) ?>
                                    </small>
                                <?php else: ?>
                                    <span style="color: #64748B;">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center py-3" style="border:1px solid #E2E8F0;">
                                <div class="btn-group btn-group-sm" role="group">

                                    <!-- 👁 DETAIL -->
                                    <a href="/iso00/show/<?= $doc['id'] ?>"
                                    class="btn"
                                    title="Detail Dokumen"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    style="background:#E0E7FF;border:1px solid #C7D2FE;color:#1E40AF;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <!-- 📄 PDF -->
                                        <a href="/iso00/view/<?= $doc['id'] ?>"
                                        class="btn"
                                        target="_blank"
                                        title="Lihat PDF"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        style="background:#FEE2E2;border:1px solid #FECACA;color:#991B1B;">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (
                                        session()->get('user_id') == $doc['uploaded_by'] ||
                                        session()->get('role') === 'admin'
                                    ): ?>

                                        <?php if (($doc['status'] ?? 'unsave') === 'unsave'): ?>
                                            <!-- 🔒 EDIT DISABLED -->
                                            <span class="btn disabled"
                                                title="Dokumen masih UNSAVE dan terkunci"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                style="background:#F1F5F9;border:1px solid #CBD5E1;color:#94A3B8;cursor:not-allowed;">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        <?php else: ?>
                                            <!-- ✏️ EDIT AKTIF -->
                                            <a href="/iso00/edit/<?= $doc['id'] ?>"
                                            class="btn"
                                            title="Edit Dokumen"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            style="background:#FEF3C7;border:1px solid #FDE68A;color:#92400E;">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                    <?php if (session()->get('role') === 'dept'): ?>
                                        <!-- ⬇️ BARCODE -->
                                        <a href="<?= base_url('barcode/print/'.$doc['id']) ?>"
                                        class="btn"
                                        title="Download QR Code (PNG)"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        style="background:#DCFCE7;border:1px solid #BBF7D0;color:#166534;">
                                            <i class="fas fa-qrcode"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if (empty($dokumen)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #94A3B8;"></i>
                    <p style="color: #64748B;">Tidak ada dokumen ditemukan</p>
                    <?php if (in_array(session()->get('role'), ['admin'])): ?>
                    <a href="/iso00/create" class="btn mt-2" style="background: #2563EB; color: white; border: none; border-radius: 8px;">
                        <i class="fas fa-plus me-2"></i>Upload Dokumen Pertama
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Card Footer dengan Pagination -->
        <div class="card-footer" style="background: #FFFFFF; border-top: 1px solid #E2E8F0;">
            <div class="row align-items-center py-2">
                <div class="col-md-6">
                    <p class="small mb-0" style="color: #64748B;">
                        Menampilkan <strong style="color: #0F172A;">1-<?= count($dokumen) ?></strong> dari <strong style="color: #0F172A;"><?= count($dokumen) ?></strong> dokumen
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" style="border-color: #E2E8F0; color: #64748B;">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#" style="background: #2563EB; border-color: #2563EB;">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-color: #E2E8F0; color: #64748B;">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-color: #E2E8F0; color: #64748B;">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" style="border-color: #E2E8F0; color: #64748B;">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

.status-icon {
    width: 20px;
    height: 20px;
}

/* ===========================
   Tabel Styles
   Sesuai panduan desain
   =========================== */

/* Base Container */
.container-fluid {
    background: #F8FAFC;
}

/* Card Styling */
.card {
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    background: white;
    overflow: hidden;
}

/* Table Styling */
.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table th, .table td {
    vertical-align: middle;
}

/* Table Header */
.table thead th {
    background: #F1F5F9;
    color: #64748B;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.875rem 0.75rem;
    border: 1px solid #E2E8F0;
    border-bottom: 2px solid #E2E8F0;
}

/* Table Body */
.table tbody td {
    padding: 1rem 0.75rem;
    border: 1px solid #E2E8F0;
    color: #0F172A;
}

/* Subtext dalam tabel */
.table tbody td small,
.table tbody td .text-muted {
    color: #64748B !important;
}

/* Hover effect untuk baris */
.table-row {
    transition: background-color 0.2s ease;
}

.table-row:hover {
    background-color: #F8FAFC !important;
    cursor: pointer;
}

/* Badge styling */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    border-radius: 6px;
    padding: 4px 8px;
}

/* Input group styling */
.input-group-text {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    color: #64748B;
}

.form-control {
    border: 1px solid #E2E8F0;
    color: #0F172A;
}

.form-control:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

/* Button group styling */
/* Base button group */
.btn-group .btn {
    border-width: 1px;
    transition: 
        background-color 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        transform 0.15s ease;
}

/* Hover effect (tidak ubah warna utama) */
.btn-group .btn:hover {
    filter: brightness(0.95);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

/* Active / click */
.btn-group .btn:active {
    filter: brightness(0.9);
    transform: translateY(0);
}

/* Focus (accessibility) */
.btn-group .btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
}

/* Pagination styling */
.pagination .page-link {
    border-radius: 6px;
    margin: 0 2px;
    border: 1px solid #E2E8F0;
    color: #64748B;
}

.pagination .page-item.active .page-link {
    background: #2563EB;
    border-color: #2563EB;
    color: white;
}

.pagination .page-item.disabled .page-link {
    background: #F8FAFC;
    color: #94A3B8;
}

/* Tooltip styling */
.tooltip {
    font-size: 0.875rem;
}

/* Empty state */
.text-center.py-5 i {
    color: #94A3B8;
}

/* Responsive untuk tabel */
@media (max-width: 768px) {
    .table-responsive {
        border: none;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

/* Alternating row colors (opsional - untuk readability) */
.table tbody tr:nth-child(even) {
    background-color: #FAFBFC;
}

/* Smooth transitions */
.btn, .table-row, .btn-group .btn {
    transition: all 0.2s ease-in-out;
}

/* Border radius untuk sel pertama dan terakhir */
.table thead th:first-child {
    border-top-left-radius: 0;
}

.table thead th:last-child {
    border-top-right-radius: 0;
}

/* Card header */
.card-header {
    padding: 1.25rem 1.5rem;
}

/* Card footer */
.card-footer {
    padding: 1rem 1.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    // Initialize DataTable jika ada
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json' },
            pageLength: 10,
            lengthMenu: [[10,25,50,-1],[10,25,50,"Semua"]],
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
            drawCallback: function(settings) {
                // Reinitialize tooltips setelah DataTable redraw
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
                
                // Tambahkan hover effect ke baris baru
                $('.table-row').hover(
                    function() {
                        $(this).css('background-color', '#F8FAFC');
                    },
                    function() {
                        $(this).css('background-color', $(this).index() % 2 === 0 ? '#FAFBFC' : 'white');
                    }
                );
            }
        });
    }
    
    // Tambahkan hover effect ke baris tabel
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#F8FAFC';
        });
        
        row.addEventListener('mouseleave', function() {
            const isEven = Array.from(tableRows).indexOf(this) % 2 === 0;
            this.style.backgroundColor = isEven ? '#FAFBFC' : 'white';
        });
    });
    
    // Button group hover effects
        document.querySelectorAll('.btn-group .btn').forEach(btn => {

        // Simpan warna awal
        const originalBg    = btn.style.backgroundColor;
        const originalColor = btn.style.color;
        const originalBorder= btn.style.borderColor;

        btn.addEventListener('mouseenter', () => {
            btn.style.filter = 'brightness(0.95)';
            btn.style.boxShadow = '0 2px 6px rgba(0,0,0,0.08)';
        });

        btn.addEventListener('mouseleave', () => {
            btn.style.backgroundColor = originalBg;
            btn.style.color = originalColor;
            btn.style.borderColor = originalBorder;
            btn.style.filter = 'none';
            btn.style.boxShadow = 'none';
        });

    });
});
</script>
<?= $this->endSection() ?>