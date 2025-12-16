<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Manajemen User</h1>
            <p class="text-muted small mb-0">Kelola data pengguna sistem</p>
        </div>
        <a href="/users/create" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Tambah User
        </a>
    </div>
    
    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-semibold small" width="60">No</th>
                            <th class="py-3 text-muted fw-semibold small">Pengguna</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-md-table-cell">Nama Lengkap</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell" width="120">Role</th>
                            <th class="py-3 text-muted fw-semibold small d-none d-lg-table-cell" width="110">Status</th>
                            <th class="pe-4 py-3 text-center text-muted fw-semibold small" width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($user['foto']): ?>
                                        <img src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                             class="rounded-circle me-3" 
                                             width="40" 
                                             height="40"
                                             alt="Profil"
                                             style="object-fit: cover; border: 2px solid #f0f0f0;">
                                    <?php else: ?>
                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-semibold" 
                                             style="width: 40px; height: 40px; min-width: 40px;">
                                            <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-semibold text-dark"><?= $user['username'] ?></div>
                                        <div class="small text-muted d-md-none"><?= $user['fullname'] ?></div>
                                        <div class="mt-1">
                                            <span class="badge rounded-pill bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'dept' ? 'primary' : 'info') ?> d-lg-none me-1">
                                                <?= ucfirst($user['role']) ?>
                                            </span>
                                            <?php if ($user['is_online'] == 1): ?>
                                                <span class="badge rounded-pill bg-success">
                                                    <i class="fas fa-circle" style="font-size: 6px;"></i> Online
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="text-dark"><?= $user['fullname'] ?></span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="badge rounded-pill fs-6 px-2 py-1 bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'dept' ? 'primary' : 'info') ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="badge rounded-pill fs-6 px-2 py-1 bg-<?= $user['status_akun'] == 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= $user['status_akun'] == 'aktif' ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td class="pe-4 text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                       class="btn btn-outline-primary"
                                       title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="/users/delete/<?= $user['id'] ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Yakin ingin menghapus user <?= addslashes($user['fullname']) ?>?')"
                                       title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <span class="text-muted small">
                    <i class="fas fa-users me-1"></i>Total: <strong><?= count($users) ?></strong> user
                </span>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>