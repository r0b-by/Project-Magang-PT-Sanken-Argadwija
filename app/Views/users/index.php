<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Manajemen User
        </h1>
        <a href="/users/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">No</th>
                            <th width="60" class="text-center">Foto</th>
                            <th>Username</th>
                            <th class="d-none d-sm-table-cell">Nama</th>
                            <th width="100">Role</th>
                            <th width="100" class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-3"><?= $no++ ?></td>
                            <td class="text-center">
                                <?php if ($user['foto']): ?>
                                    <img src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                         class="rounded-circle" 
                                         width="36" 
                                         height="36"
                                         alt="Profil"
                                         style="object-fit: cover">
                                <?php else: ?>
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 36px; height: 36px;">
                                        <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <strong><?= $user['username'] ?></strong>
                                    <div class="text-muted small d-block d-sm-none">
                                        <?= $user['fullname'] ?>
                                    </div>
                                    <div class="small">
                                        <span class="badge bg-<?= $user['status_akun'] == 'aktif' ? 'success' : 'danger' ?>">
                                            <?= $user['status_akun'] == 'aktif' ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                        <?php if ($user['is_online'] == 1): ?>
                                            <span class="badge bg-info ms-1">Online</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell"><?= $user['fullname'] ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $user['role'] == 'admin' ? 'danger' : 
                                    ($user['role'] == 'dept' ? 'primary' : 'info') ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                       class="btn btn-outline-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/users/delete/<?= $user['id'] ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Hapus user <?= addslashes($user['fullname']) ?>?')"
                                       title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total: <?= count($users) ?> user</span>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>