<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Master Holder Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Master Holder Dokumen</h1>
            <p class="text-muted small mb-0">Kelola akses holder dokumen ISO</p>
        </div>
        <a href="<?= base_url('access/create') ?>" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Tambah Holder
        </a>
    </div>
    
    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" width="60">No</th>
                            <th class="py-3 text-muted fw-semibold small">Holder</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-md-table-cell">Dokumen</th>
                            <th class="py-3 text-muted fw-semibold small">Total User</th>
                            <th class="pe-4 py-3 text-center text-muted fw-semibold small" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($holders)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada holder ditemukan</p>
                                    <a href="<?= base_url('access/create') ?>" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Tambah Holder Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($holders as $h): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= $no++ ?></td>
                                <td>
                                    <div>
                                        <div class="fw-semibold text-dark"><?= esc($h['holder_code']) ?></div>
                                        <?php if (!empty($h['description'])): ?>
                                            <div class="text-muted small mt-1">
                                                <?= esc($h['description']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-alt text-primary me-2"></i>
                                        <div>
                                            <div class="text-truncate" style="max-width: 200px;" title="<?= esc($h['kode_dokumen'] ?? 'Belum ditentukan') ?>">
                                                <?= esc($h['kode_dokumen'] ?? '-') ?>
                                            </div>
                                            <?php if (!empty($h['nama_dokumen'])): ?>
                                                <small class="text-muted">
                                                    <?= esc($h['nama_dokumen']) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 32px; height: 32px; min-width: 32px;">
                                            <i class="fas fa-users" style="font-size: 14px;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><?= esc($h['total_users']) ?> User</div>
                                            <small class="text-muted">
                                                <?php if (isset($h['last_updated'])): ?>
                                                    Diperbarui: <?= date('d/m/Y', strtotime($h['last_updated'])) ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('access/detail/'.esc($h['holder_code'])) ?>" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('access/assign/'.esc($h['holder_code'])) ?>" 
                                           class="btn btn-outline-warning" title="Edit User">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="<?= base_url('access/edit-holder/'.esc($h['id'] ?? $h['holder_code'])) ?>" 
                                           class="btn btn-outline-primary" title="Edit Holder">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="<?= base_url('access/delete-holder/'.esc($h['id'] ?? $h['holder_code'])) ?>" 
                                           class="btn btn-outline-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus holder ini? Semua user yang terhubung akan kehilangan akses.')">
                                            <i class="fas fa-trash-alt"></i>
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
</div>

<script>
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
                { orderable: false, targets: [4] } // Nonaktifkan sorting untuk kolom aksi
            ],
            order: [[0, 'asc']] // Urutkan berdasarkan kolom No
        });
    }
    
    // Auto-hide alert setelah 5 detik
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>

<?= $this->endSection() ?>