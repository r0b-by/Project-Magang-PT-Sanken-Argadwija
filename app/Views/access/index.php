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

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" width="60">No</th>
                            <th class="py-3 text-muted fw-semibold small">Holder</th>
                            <th class="py-3 text-muted fw-semibold small">Dokumen</th>
                            <th class="py-3 text-muted fw-semibold small">Pengguna</th>
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
                                        <div class="fw-semibold text-dark">
                                            <?= esc($h['holder_code']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <?php if (!empty($h['dokumen_list'])): ?>
                                            <ul class="list-unstyled mb-0 small">
                                                <?php foreach ($h['dokumen_list'] as $doc): ?>
                                                    <li><i class="fas fa-file-alt text-danger me-1"></i> <?= esc($doc) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span class="text-muted small">Belum ada</span>
                                        <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                        <?php if (!empty($h['user_list'])): ?>
                                            <ul class="list-unstyled mb-0 small">
                                                <?php foreach ($h['user_list'] as $user): ?>
                                                    <li><i class="fas fa-user text-primary me-1"></i> <?= esc($user) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span class="text-muted small">Belum ada</span>
                                        <?php endif; ?>
                                        </td>


                                    <td class="pe-4 text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('access/detail/'.$h['holder_code']) ?>"
                                               class="btn btn-outline-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('access/edit-dokumen/'.$h['id']) ?>"
                                               class="btn btn-outline-warning" title="Kelola Dokumen">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                            <a href="<?= base_url('access/edit-users/'.$h['id']) ?>"
                                               class="btn btn-outline-primary" title="Kelola User">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                            <a href="<?= base_url('access/edit/'.$h['id']) ?>"
                                               class="btn btn-outline-secondary" title="Edit Holder">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('access/delete-holder/'.$h['id']) ?>"
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Yakin ingin menghapus holder ini? Semua akses user akan ikut terhapus.')"
                                               title="Hapus">
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
