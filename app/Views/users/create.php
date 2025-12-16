<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Tambah User Baru</h1>
            <p class="text-muted small mb-0">Tambahkan pengguna baru ke sistem</p>
        </div>
        <a href="/users" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="/users/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold text-dark">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   id="username" 
                                   name="username" 
                                   value="<?= old('username') ?>"
                                   placeholder="Masukkan username"
                                   required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-dark">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password"
                                       required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (session('errors.password')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= session('errors.password') ?>
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
                                   value="<?= old('fullname') ?>"
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
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold text-dark">Role <span class="text-danger">*</span></label>
                            <select class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Pilih Role</option>
                                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="dept" <?= old('role') == 'dept' ? 'selected' : '' ?>>Departemen</option>
                                <option value="karyawan" <?= old('role') == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
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
                                <option value="aktif" <?= old('status_akun') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status_akun') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <?php if (session('errors.status_akun')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.status_akun') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Photo Upload -->
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold text-dark">Foto Profil</label>
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
                            <small class="text-muted d-block mt-1">Format: JPG, PNG, maks 2MB</small>
                        </div>
                        
                        <!-- Photo Preview -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img id="fotoPreview" 
                                     src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iNjAiIGN5PSI2MCIgcj0iNjAiIGZpbGw9IiNGMEYyRjQiLz48dGV4dCB4PSI2MCIgeT0iNjgiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyNCIgZmlsbD0iIzhCOEI4QiI+VXNlcjwvdGV4dD48L3N2Zz4=" 
                                     class="rounded-circle border" 
                                     width="120" 
                                     height="120"
                                     alt="Preview"
                                     style="object-fit: cover">
                                <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-camera"></i>
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
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-2"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>