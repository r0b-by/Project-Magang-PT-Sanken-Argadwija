<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Tambah User Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-user-plus me-2"></i>Tambah User
        </h1>
        <a href="/users" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span class="d-none d-sm-inline"> Kembali</span>
        </a>
    </div>
    
    <!-- Form -->
    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="/users/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label small fw-bold">Username *</label>
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                           id="username" 
                           name="username" 
                           value="<?= old('username') ?>"
                           required>
                    <?php if (session('errors.username')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.username') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-bold">Password *</label>
                    <input type="password" 
                           class="form-control form-control-sm <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                           id="password" 
                           name="password" 
                           required>
                    <?php if (session('errors.password')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.password') ?>
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
                           value="<?= old('fullname') ?>"
                           required>
                    <?php if (session('errors.fullname')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.fullname') ?>
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
                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="dept" <?= old('role') == 'dept' ? 'selected' : '' ?>>Departemen</option>
                            <option value="karyawan" <?= old('role') == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
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
                            <option value="aktif" <?= old('status_akun') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status_akun') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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
                    <label for="foto" class="form-label small fw-bold">Foto Profil</label>
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
                
                <!-- Photo Preview -->
                <div class="text-center mb-3">
                    <img id="fotoPreview" 
                         src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSI0MCIgY3k9IjQwIiByPSI0MCIgZmlsbD0iI0U5RTlFOSIvPjx0ZXh0IHg9IjQwIiB5PSI0NSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSIjNjY2NjY2Ij5VPC90ZXh0Pjwvc3ZnPg==" 
                         class="rounded-circle" 
                         width="80" 
                         height="80"
                         alt="Preview"
                         style="object-fit: cover">
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i>
                        <span class="d-none d-sm-inline"> Reset</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i>Simpan
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
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-generate username from fullname
document.getElementById('fullname').addEventListener('blur', function() {
    const fullname = this.value.trim().toLowerCase();
    const usernameInput = document.getElementById('username');
    
    if (fullname && !usernameInput.value) {
        const username = fullname.replace(/\s+/g, '.').replace(/[^a-z0-9.]/g, '');
        usernameInput.value = username;
    }
});
</script>
<?= $this->endSection() ?>