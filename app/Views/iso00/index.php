<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-3 mb-md-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Dokumen ISO
        </h1>
        <div>
            <?php if (in_array(session()->get('role'), ['admin', 'dept'])): ?>
            <a href="/iso00/create" class="btn btn-primary btn-sm btn-md">
                <i class="fas fa-plus me-1"></i><span class="d-none d-md-inline">Upload</span><span class="d-md-none">Upload Dokumen</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Documents Table -->
    <div class="card shadow-sm">
        <div class="card-body p-2 p-md-3">
            <div class="table-responsive">
                <table class="table table-hover datatable mb-0">
                    <thead class="d-none d-md-table-header-group">
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 15%">Kode Dokumen</th>
                            <th style="width: 12%">Departemen</th>
                            <th style="width: 22%">File</th>
                            <th style="width: 15%">Uploader</th>
                            <th class="text-center" style="width: 10%">Status</th>
                            <th style="width: 12%">Tanggal Upload</th>
                            <th class="text-center" style="width: 9%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumen as $doc): ?>
                        <tr class="vertical-align-top">
                            <!-- Mobile Header Row -->
                            <td class="d-md-none fw-bold bg-light" colspan="2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><?= $no ?>. <?= $doc['kode_dokumen'] ?></span>
                                    <span class="badge bg-<?= 
                                        $doc['status'] == 'approved' ? 'success' : 
                                        ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                        <?= ucfirst($doc['status']) ?>
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Desktop: No -->
                            <td class="text-center d-none d-md-table-cell"><?= $no++ ?></td>
                            
                            <!-- Desktop: Kode Dokumen -->
                            <td class="d-none d-md-table-cell">
                                <strong><?= $doc['kode_dokumen'] ?></strong>
                                <?php if ($doc['barcode']): ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-barcode me-1"></i>
                                        <?= $doc['barcode'] ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Mobile Content -->
                            <td class="d-md-none">
                                <div class="row g-2">
                                    <?php if ($doc['barcode']): ?>
                                    <div class="col-4 fw-bold">Barcode:</div>
                                    <div class="col-8">
                                        <i class="fas fa-barcode me-1 text-muted"></i>
                                        <?= $doc['barcode'] ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="col-4 fw-bold">Departemen:</div>
                                    <div class="col-8"><?= $doc['departement'] ?></div>
                                    
                                    <div class="col-4 fw-bold">File:</div>
                                    <div class="col-8">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-file-pdf text-danger me-2 mt-1"></i>
                                            <div>
                                                <div class="text-break"><?= $doc['nama_file'] ?></div>
                                                <small class="text-muted">
                                                    <?php 
                                                    $filePath = WRITEPATH . 'uploads/' . $doc['nama_file'];
                                                    if (file_exists($filePath)) {
                                                        echo round(filesize($filePath) / 1024, 2) . ' KB';
                                                    } else {
                                                        echo '<span class="text-danger">File tidak ditemukan</span>';
                                                    }
                                                    ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-4 fw-bold">Uploader:</div>
                                    <div class="col-8">
                                        <div class="d-flex align-items-center">
                                            <?php if (isset($doc['foto'])): ?>
                                                <img src="/uploads/foto_user/<?= $doc['foto'] ?>" 
                                                    class="profile-img-sm me-2" 
                                                    alt="Foto Uploader">
                                            <?php endif; ?>
                                            <div>
                                                <div><?= $doc['fullname'] ?? 'Unknown' ?></div>
                                                <small class="text-muted"><?= $doc['role'] ?? 'Unknown' ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-4 fw-bold">Tanggal:</div>
                                    <div class="col-8"><?= date('d/m/Y H:i', strtotime($doc['uploaded_at'])) ?></div>
                                </div>
                            </td>
                            
                            <!-- Desktop: Departemen -->
                            <td class="d-none d-md-table-cell"><?= $doc['departement'] ?></td>
                            
                            <!-- Desktop: File -->
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <div>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= $doc['nama_file'] ?>">
                                            <?= $doc['nama_file'] ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php 
                                            $filePath = WRITEPATH . 'uploads/' . $doc['nama_file'];
                                            if (file_exists($filePath)) {
                                                echo round(filesize($filePath) / 1024, 2) . ' KB';
                                            } else {
                                                echo '<span class="text-danger">File tidak ditemukan</span>';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Desktop: Uploader -->
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex align-items-center">
                                    <?php if (isset($doc['foto'])): ?>
                                        <img src="/uploads/foto_user/<?= $doc['foto'] ?>" 
                                            class="profile-img me-2" 
                                            alt="Foto Uploader">
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-truncate" style="max-width: 120px;" title="<?= $doc['fullname'] ?? 'Unknown' ?>">
                                            <?= $doc['fullname'] ?? 'Unknown' ?>
                                        </div>
                                        <small class="text-muted"><?= $doc['role'] ?? 'Unknown' ?></small>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Desktop: Status -->
                            <td class="text-center d-none d-md-table-cell">
                                <span class="badge bg-<?= 
                                    $doc['status'] == 'approved' ? 'success' : 
                                    ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($doc['status']) ?>
                                </span>
                            </td>
                            
                            <!-- Desktop: Tanggal Upload -->
                            <td class="d-none d-md-table-cell"><?= date('d/m/Y H:i', strtotime($doc['uploaded_at'])) ?></td>
                            
                            <!-- Aksi -->
                            <td class="text-center">
                                <!-- Mobile Actions -->
                                <div class="d-grid gap-1 d-md-none">
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="/iso00/show/<?= $doc['id'] ?>" 
                                        class="btn btn-info flex-fill">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <a href="/iso00/view/<?= $doc['id'] ?>" 
                                        class="btn btn-primary flex-fill" target="_blank">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </a>
                                    </div>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="/iso00/download/<?= $doc['id'] ?>" 
                                        class="btn btn-success flex-fill">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                        <?php if (session()->get('user_id') == $doc['uploaded_by'] || session()->get('role') == 'admin'): ?>
                                        <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                        class="btn btn-warning flex-fill">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <?php endif; ?>
                                        <?php if (session()->get('role') == 'admin'): ?>
                                        <a href="/iso00/delete/<?= $doc['id'] ?>" 
                                        class="btn btn-danger flex-fill"
                                        onclick="return confirm('Yakin menghapus dokumen ini?')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Desktop Actions -->
                                <div class="btn-group btn-group-sm d-none d-md-flex" role="group">
                                    <a href="/iso00/show/<?= $doc['id'] ?>" 
                                    class="btn btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/iso00/view/<?= $doc['id'] ?>" 
                                    class="btn btn-primary" target="_blank" title="Lihat PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="/iso00/download/<?= $doc['id'] ?>" 
                                    class="btn btn-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <?php if (session()->get('user_id') == $doc['uploaded_by'] || session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                    class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/delete/<?= $doc['id'] ?>" 
                                    class="btn btn-danger" title="Hapus"
                                    onclick="return confirm('Yakin menghapus dokumen ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <tr class="d-md-none"><td colspan="1" class="p-0 border-0"></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <?php if (empty($dokumen)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">Tidak ada dokumen ditemukan.</p>
                    <?php if (in_array(session()->get('role'), ['admin', 'dept'])): ?>
                    <a href="/iso00/create" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i>Upload Dokumen Pertama
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for better mobile experience */
    @media (max-width: 767.98px) {
        .table > tbody > tr > td {
            border-top: 1px solid #dee2e6;
            padding: 0.75rem 0.5rem;
        }
        
        .card-body {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .profile-img-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .row.g-2 > div {
            padding: 0.25rem 0.5rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        h1 {
            font-size: 1.5rem;
        }
        
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .btn.btn-sm {
            padding: 0.25rem 0.5rem;
        }
        
        .btn.btn-md {
            padding: 0.375rem 0.75rem;
        }
    }
    
    /* Desktop styles */
    @media (min-width: 768px) {
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
    
    /* Fix for DataTables on mobile */
    .datatable {
        width: 100% !important;
    }
    
    .text-break {
        word-break: break-word;
    }
</style>

<script>
    // Initialize DataTables with responsive configuration
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                columnDefs: [
                    {
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },
                    {
                        responsivePriority: 3,
                        targets: 2
                    }
                ]
            });
        }
    });
</script>
<?= $this->endSection() ?>