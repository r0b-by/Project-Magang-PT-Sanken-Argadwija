<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-user-edit me-2"></i>Edit User
        </h1>
        <a href="/users" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span class="d-none d-sm-inline"> Kembali</span>
        </a>
    </div>
    
    <!-- Form -->
    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="/users/update/<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Current Photo -->
                <div class="text-center mb-3">
                    <?php if ($user['foto']): ?>
                        <img id="fotoPreview" 
                             src="/uploads/foto_user/<?= $user['foto'] ?>" 
                             class="rounded-circle" 
                             width="80" 
                             height="80"
                             alt="Foto"
                             style="object-fit: cover">
                    <?php else: ?>
                        <div id="fotoPreview" 
                             class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label small fw-bold">Username *</label>
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                           id="username" 
                           name="username" 
                           value="<?= old('username', $user['username']) ?>"
                           required>
                    <?php if (session('errors.username')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.username') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Fullname -->
                <div class="mb-3">
                    <label for="fullname" class="form-label small fw-bold">Nama Lengkap *</label>
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.fullname') ? 'is-invalid' : '' ?>" 
                           id="fullname" 
                           name="fullname" 
                           value="<?= old('fullname', $user['fullname']) ?>"
                           required>
                    <?php if (session('errors.fullname')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.fullname') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold">Password</label>
                    <input type="password" 
                           class="form-control form-control-sm <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                           id="password" 
                           name="password" 
                           placeholder="Kosongkan jika tidak ganti">
                    <?php if (session('errors.password')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Role & Status -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="role" class="form-label small fw-bold">Role *</label>
                        <select class="form-select form-select-sm <?= session('errors.role') ? 'is-invalid' : '' ?>" 
                                id="role" 
                                name="role" 
                                required>
                            <option value="">Pilih Role</option>
                            <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="dept" <?= old('role', $user['role']) == 'dept' ? 'selected' : '' ?>>Departemen</option>
                            <option value="karyawan" <?= old('role', $user['role']) == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
                        </select>
                        <?php if (session('errors.role')): ?>
                            <div class="invalid-feedback small">
                                <?= session('errors.role') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-6">
                        <label for="status_akun" class="form-label small fw-bold">Status *</label>
                        <select class="form-select form-select-sm <?= session('errors.status_akun') ? 'is-invalid' : '' ?>" 
                                id="status_akun" 
                                name="status_akun" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" <?= old('status_akun', $user['status_akun']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status_akun', $user['status_akun']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <?php if (session('errors.status_akun')): ?>
                            <div class="invalid-feedback small">
                                <?= session('errors.status_akun') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Photo Upload -->
                <div class="mb-3">
                    <label for="foto" class="form-label small fw-bold">Foto Baru</label>
                    <input type="file" 
                           class="form-control form-control-sm <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                           id="foto" 
                           name="foto" 
                           accept="image/*"
                           onchange="previewImage(this)">
                    <?php if (session('errors.foto')): ?>
                        <div class="invalid-feedback small d-block">
                            <?= session('errors.foto') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i>
                        <span class="d-none d-sm-inline"> Reset</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('fotoPreview');
            preview.src = e.target.result;
            preview.classList.remove('bg-secondary');
            preview.classList.remove('d-flex', 'align-items-center', 'justify-content-center');
            preview.classList.add('rounded-circle');
            preview.style.width = '80px';
            preview.style.height = '80px';
            preview.style.objectFit = 'cover';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?= $this->endSection() ?>