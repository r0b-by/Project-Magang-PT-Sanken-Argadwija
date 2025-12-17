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
                            <th class="pe-4 py-3 text-center text-muted fw-semibold small" width="240">Aksi</th>
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
                                            <div class="text-muted small mt-1"><?= esc($h['description']) ?></div>
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
                                                <small class="text-muted"><?= esc($h['nama_dokumen']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($h['users'])): ?>
                                        <?php foreach ($h['users'] as $u): ?>
                                            <span class="badge bg-secondary fs-6 px-2 py-1">
                                                <?= esc($u['fullname']) ?> (<?= esc($u['username'] ?? '-') ?>)
                                        </span><br>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="badge bg-danger fs-6 px-2 py-1">Belum ada user</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('access/detail/'.esc($h['holder_code'])) ?>" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('access/edit-dokumen/'.esc($h['id'])) ?>" 
                                           class="btn btn-outline-warning" title="Edit Dokumen">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <a href="<?= base_url('access/edit-users/'.esc($h['id'])) ?>" 
                                           class="btn btn-outline-primary" title="Edit User">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        <a href="<?= base_url('access/edit/'.esc($h['id'])) ?>" 
                                           class="btn btn-outline-secondary" title="Edit Holder">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="<?= base_url('access/delete-holder/'.esc($h['id'])) ?>" 
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

<?= $this->endSection() ?>
