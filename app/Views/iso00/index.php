<!-- ========================================== -->
<!-- 1. HALAMAN INDEX DOKUMEN ISO -->
<!-- ========================================== -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Dokumen ISO<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Dokumen ISO</h1>
            <p class="text-muted small mb-0">Kelola dokumen sistem manajemen</p>
        </div>
        <?php if (in_array(session()->get('role'), ['admin'])): ?>
        <a href="/iso00/create" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Upload Dokumen
        </a>
        <?php endif; ?>
    </div>
    
    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" width="60">No</th>
                            <th class="py-3 text-muted fw-semibold small">Dokumen</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">File</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">Holder</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">Hak Akses</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell">Uploader</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-md-table-cell" width="110">Status</th>
                            <th class="pe-4 py-3 text-center text-muted fw-semibold small" width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumen as $doc): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark"><?= $doc['kode_dokumen'] ?></div>
                                    <?php if (!empty($doc['nama_dokumen_internal'])): ?>
                                        <div class="text-primary small">
                                            <i class="fas fa-tag" style="font-size: 10px;"></i> <?= $doc['nama_dokumen_internal'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-muted small">
                                        <?= $doc['halaman_dokumen'] ?? '-' ?> | <?= $doc['ruang_lingkup'] ?? '-' ?>
                                    </div>
                                    <?php if ($doc['barcode']): ?>
                                        <div class="text-muted small">
                                            <i class="fas fa-barcode" style="font-size: 10px;"></i> <?= $doc['barcode'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-1 d-lg-none">
                                        <span class="badge rounded-pill bg-<?= 
                                            $doc['status'] == 'approved' ? 'success' : 
                                            ($doc['status'] == 'save' ? 'info' : 'warning') ?>">
                                            <?= ucfirst($doc['status']) ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <div>
                                        <div class="text-truncate" style="max-width: 180px;" title="<?= $doc['nama_file'] ?>">
                                            <?= $doc['nama_file'] ?>
                                        </div>
                                        <small class="text-muted">
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
                            <td>
                                <?php if ($doc['holder_code']): ?>
                                    <span class="badge bg-primary fs-6 px-2 py-1">
                                        <?= esc($doc['holder_code']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($doc['holder_users'])): ?>
                                    <?php foreach ($doc['holder_users'] as $user): ?>
                                        <span class="badge bg-secondary mb-1 fs-6 px-2 py-1">
                                            <?= esc($user) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Belum ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($doc['uploader_foto'])): ?>
                                        <img src="/uploads/foto_user/<?= esc($doc['uploader_foto']) ?>" 
                                            class="rounded-circle me-2" 
                                            width="32" 
                                            height="32"
                                            alt="Profil"
                                            style="object-fit: cover; border: 2px solid #f0f0f0;">
                                    <?php else: ?>
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                            style="width: 32px; height: 32px; min-width: 32px;">
                                            <i class="fas fa-user" style="font-size: 14px;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <div class="text-truncate" style="max-width: 120px;"
                                            title="<?= esc($doc['uploader_name'] ?? 'Unknown') ?>">
                                            <?= esc($doc['uploader_name'] ?? 'Unknown') ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= esc($doc['uploader_role'] ?? '-') ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge rounded-pill fs-6 px-2 py-1 text-dark bg-<?= 
                                    $doc['status'] == 'approved' ? 'success' : 
                                    ($doc['status'] == 'save' ? 'info' : 'warning') ?>">
                                    <?= ucfirst($doc['status']) ?>
                                </span>
                                <?php if ($doc['tanggal_efektif']): ?>
                                    <div class="text-muted small mt-1">
                                        <?= date('d/m/Y', strtotime($doc['tanggal_efektif'])) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/iso00/show/<?= $doc['id'] ?>" class="btn btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/view/<?= $doc['id'] ?>" class="btn btn-outline-primary" target="_blank" title="PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="/iso00/download/<?= $doc['id'] ?>" class="btn btn-outline-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (session()->get('user_id') == $doc['uploaded_by'] || session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/edit/<?= $doc['id'] ?>" class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-pen"></i>
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
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada dokumen ditemukan</p>
                    <?php if (in_array(session()->get('role'), ['admin'])): ?>
                    <a href="/iso00/create" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i>Upload Dokumen Pertama
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.datatable').DataTable({
            responsive: true,
            language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json' },
            pageLength: 10,
            lengthMenu: [[10,25,50,-1],[10,25,50,"Semua"]]
        });
    }
});
</script>
<?= $this->endSection() ?>