<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 py-2">
        <div>
            <h1 class="h4 mb-0 text-gray-800">
                <i class="fas fa-users me-2"></i>Manajemen User
            </h1>
            <p class="text-muted small mb-0 d-none d-md-block">Kelola data pengguna sistem</p>
        </div>
        <div>
            <a href="/users/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah
            </a>
        </div>
    </div>
    
    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-2">
            <h6 class="m-0 font-weight-bold text-gray-800">
                <i class="fas fa-table me-2"></i>Daftar Pengguna
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">No</th>
                            <th width="50">Foto</th>
                            <th>Username</th>
                            <th class="d-none d-sm-table-cell">Nama</th>
                            <th width="90">Role</th>
                            <th width="90">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-3"><?= $no++ ?></td>
                            <td>
                                <?php if (!empty($user['foto'])): ?>
                                    <img src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                         class="rounded-circle" 
                                         width="36" 
                                         height="36"
                                         alt="Profil"
                                         style="object-fit: cover"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <?php endif; ?>
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center d-<?= empty($user['foto']) ? 'flex' : 'none' ?>" 
                                     style="width:36px; height:36px">
                                    <span class="text-white fw-bold"><?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?></span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong><?= htmlspecialchars($user['username'] ?? '') ?></strong>
                                    <?php if ($user['is_online'] == 1): ?>
                                        <small class="text-success d-block d-sm-none">
                                            <i class="fas fa-circle fa-xs me-1"></i>Online
                                        </small>
                                    <?php endif; ?>
                                    <small class="text-muted d-block d-sm-none"><?= htmlspecialchars(substr($user['fullname'] ?? '', 0, 15)) ?></small>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell"><?= htmlspecialchars($user['fullname'] ?? '') ?></td>
                            <td>
                                <span class="badge <?= ($user['role'] == 'admin') ? 'bg-danger' : 'bg-secondary' ?>">
                                    <?= ucfirst($user['role'] ?? 'user') ?>
                                </span>
                            </td>
                            <td>
                                <?php if (($user['status_akun'] ?? '') == 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/users/edit/<?= $user['id'] ?>" 
                                       class="btn btn-outline-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/users/delete/<?= $user['id'] ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Hapus user <?= htmlspecialchars(addslashes($user['fullname'])) ?>?')"
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
        <div class="card-footer bg-white py-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    Total: <?= count($users) ?> user
                </span>
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

<?= $this->section('styles') ?>
<style>
    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .table th:nth-child(3),
        .table td:nth-child(3) {
            min-width: 120px;
        }
        
        .btn-group .btn {
            padding: 0.2rem 0.4rem;
        }
    }
    
    @media (max-width: 400px) {
        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(2),
        .table td:nth-child(2) {
            display: none;
        }
        
        h1 {
            font-size: 1.2rem;
        }
    }
</style>
<?= $this->endSection() ?>