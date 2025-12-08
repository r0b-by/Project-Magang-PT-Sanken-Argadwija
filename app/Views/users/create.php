<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus me-2"></i>Tambah User Baru
        </h1>
        <a href="/users" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    
    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form action="/users/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-8">
                        <!-- Username & Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" 
                                       class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                       id="username" 
                                       name="username" 
                                       value="<?= old('username') ?>"
                                       required>
                                <?php if (session('errors.username')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.username') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" 
                                       class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <?php if (session('errors.password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Fullname -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap *</label>
                            <input type="text" 
                                   class="form-control <?= session('errors.fullname') ? 'is-invalid' : '' ?>" 
                                   id="fullname" 
                                   name="fullname" 
                                   value="<?= old('fullname') ?>"
                                   required>
                            <?php if (session('errors.fullname')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.fullname') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Role & Status -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role *</label>
                                <select class="form-control <?= session('errors.role') ? 'is-invalid' : '' ?>" 
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
                            <div class="col-md-6">
                                <label for="status_akun" class="form-label">Status Akun *</label>
                                <select class="form-control <?= session('errors.status_akun') ? 'is-invalid' : '' ?>" 
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
                        </div>
                    </div>
                    
                    <!-- Photo Upload -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <div class="card">
                                <div class="card-body text-center">
                                    <!-- Preview Image -->
                                    <div class="mb-3">
                                        <img id="fotoPreview" 
                                             src="https://via.placeholder.com/150" 
                                             class="img-thumbnail" 
                                             alt="Preview Foto" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    
                                    <!-- File Input -->
                                    <input type="file" 
                                           class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                                           id="foto" 
                                           name="foto" 
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <small class="text-muted d-block mt-2">
                                        Max 2MB, Format: JPG, PNG
                                    </small>
                                    <?php if (session('errors.foto')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session('errors.foto') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image preview function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('fotoPreview').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Auto-generate username from fullname
    document.getElementById('fullname').addEventListener('blur', function() {
        var fullname = this.value.toLowerCase();
        var usernameInput = document.getElementById('username');
        
        if (fullname && !usernameInput.value) {
            // Remove spaces and special characters
            var username = fullname.replace(/\s+/g, '.').replace(/[^a-z0-9.]/g, '');
            usernameInput.value = username;
        }
    });
</script>
<?= $this->endSection() ?>