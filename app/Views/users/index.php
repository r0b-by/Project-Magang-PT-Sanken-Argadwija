<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Manajemen User
        </h1>
        <div>
            <a href="/users/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah User
            </a>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Terakhir Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if ($user['foto']): ?>
                                    <img src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                         class="profile-img" 
                                         alt="Foto Profil">
                                <?php else: ?>
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['fullname'] ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $user['role'] == 'admin' ? 'danger' : 
                                    ($user['role'] == 'dept' ? 'primary' : 'info') ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['status_akun'] == 'aktif'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-circle me-1"></i>Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-circle me-1"></i>Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                           <td>
                                <?php if (!empty($user['last_active_at'])): ?>
                                    <?= date('d/m/Y H:i', strtotime($user['last_active_at'])) ?>
                                <?php else: ?>
                                    <span class="text-muted">Belum pernah</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                       class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/users/delete/<?= $user['id'] ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Yakin menghapus user <?= $user['fullname'] ?>?')">
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
    </div>
</div>
<?= $this->endSection() ?>