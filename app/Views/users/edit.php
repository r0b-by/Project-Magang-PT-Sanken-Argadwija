<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Edit User</h1>
            <p class="text-muted small mb-0">Perbarui data pengguna <?= esc($user['fullname']) ?></p>
        </div>
        <a href="/users" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="/users/update/<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Current Photo -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <?php if ($user['foto']): ?>
                                    <img id="fotoPreview" 
                                         src="/uploads/foto_user/<?= $user['foto'] ?>" 
                                         class="rounded-circle border" 
                                         width="120" 
                                         height="120"
                                         alt="Foto Profil"
                                         style="object-fit: cover">
                                <?php else: ?>
                                    <div id="fotoPreview" 
                                         class="rounded-circle border bg-primary bg-gradient text-white d-flex align-items-center justify-content-center"
                                         style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <?= strtoupper(substr($user['fullname'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold text-dark">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   id="username" 
                                   name="username" 
                                   value="<?= old('username', $user['username']) ?>"
                                   placeholder="Masukkan username"
                                   required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Fullname -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.fullname') ? 'is-invalid' : '' ?>" 
                                   id="fullname" 
                                   name="fullname" 
                                   value="<?= old('fullname', $user['fullname']) ?>"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            <?php if (session('errors.fullname')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.fullname') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-dark">Password Baru</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Kosongkan jika tidak ingin mengganti">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (session('errors.password')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= session('errors.password') ?>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted d-block mt-1">Minimum 8 karakter</small>
                        </div>
                        
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold text-dark">Role <span class="text-danger">*</span></label>
                            <select class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Pilih Role</option>
                                <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="dept" <?= old('role', $user['role']) == 'dept' ? 'selected' : '' ?>>Departemen</option>
                                <option value="karyawan" <?= old('role', $user['role']) == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
                            </select>
                            <?php if (session('errors.role')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.role') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status_akun" class="form-label fw-semibold text-dark">Status Akun <span class="text-danger">*</span></label>
                            <select class="form-select <?= session('errors.status_akun') ? 'is-invalid' : '' ?>" 
                                    id="status_akun" 
                                    name="status_akun" 
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="aktif" <?= old('status_akun', $user['status_akun']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status_akun', $user['status_akun']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <?php if (session('errors.status_akun')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.status_akun') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Photo Upload -->
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-semibold text-dark">Upload Foto Baru</label>
                            <input type="file" 
                                   class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                                   id="foto" 
                                   name="foto" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <?php if (session('errors.foto')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.foto') ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($user['foto']): ?>
                                <small class="text-muted d-block mt-1">File saat ini: <?= $user['foto'] ?></small>
                            <?php endif; ?>
                        </div>
                        
                        <!-- User Info -->
                        <div class="alert alert-light border mt-3">
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>ID User:</span>
                                    <span class="fw-semibold">#<?= $user['id'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Terdaftar:</span>
                                    <span><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Terakhir Update:</span>
                                    <span><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top mt-3">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                    <div>
                        <a href="/users" class="btn btn-outline-danger me-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>