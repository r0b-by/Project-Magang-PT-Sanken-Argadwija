<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Upload Dokumen Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-upload me-2"></i>Upload Dokumen Baru
        </h1>
        <a href="/iso00" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    
    <!-- Upload Form -->
    <div class="card">
        <div class="card-body">
            <form action="/iso00/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Document Code -->
                <div class="mb-3">
                    <label for="kode_dokumen" class="form-label">Kode Dokumen *</label>
                    <input type="text" 
                           class="form-control <?= session('errors.kode_dokumen') ? 'is-invalid' : '' ?>" 
                           id="kode_dokumen" 
                           name="kode_dokumen" 
                           value="<?= old('kode_dokumen') ?>"
                           placeholder="Contoh: ISO-001/2023"
                           required>
                    <small class="text-muted">Format: ISO-[nomor]/[tahun]</small>
                    <?php if (session('errors.kode_dokumen')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.kode_dokumen') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Department -->
                <div class="mb-3">
                    <label for="departement" class="form-label">Departemen *</label>
                    <select class="form-control <?= session('errors.departement') ? 'is-invalid' : '' ?>" 
                            id="departement" 
                            name="departement" 
                            required>
                        <option value="">Pilih Departemen</option>
                        <option value="HRD" <?= old('departement') == 'HRD' ? 'selected' : '' ?>>HRD</option>
                        <option value="IT" <?= old('departement') == 'IT' ? 'selected' : '' ?>>IT</option>
                        <option value="Finance" <?= old('departement') == 'Finance' ? 'selected' : '' ?>>Finance</option>
                        <option value="Marketing" <?= old('departement') == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                        <option value="Produksi" <?= old('departement') == 'Produksi' ? 'selected' : '' ?>>Produksi</option>
                        <option value="QA" <?= old('departement') == 'QA' ? 'selected' : '' ?>>QA</option>
                    </select>
                    <?php if (session('errors.departement')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.departement') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- File Upload -->
                <div class="mb-3">
                    <label for="upload_dokumen" class="form-label">File Dokumen *</label>
                    <div class="input-group">
                        <input type="file" 
                               class="form-control <?= session('errors.upload_dokumen') ? 'is-invalid' : '' ?>" 
                               id="upload_dokumen" 
                               name="upload_dokumen" 
                               accept=".pdf,.doc,.docx,.xls,.xlsx"
                               required>
                        <span class="input-group-text">
                            <i class="fas fa-file"></i>
                        </span>
                    </div>
                    <small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX (Max 10MB)</small>
                    <?php if (session('errors.upload_dokumen')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.upload_dokumen') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control <?= session('errors.keterangan') ? 'is-invalid' : '' ?>" 
                              id="keterangan" 
                              name="keterangan" 
                              rows="3"
                              placeholder="Deskripsi atau catatan tentang dokumen ini"><?= old('keterangan') ?></textarea>
                    <?php if (session('errors.keterangan')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.keterangan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Auto-generated info -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Sistem:</h6>
                    <ul class="mb-0">
                        <li>Barcode akan dibuat otomatis oleh sistem</li>
                        <li>Uploader: <?= session()->get('fullname') ?></li>
                        <li>Tanggal: <?= date('d F Y H:i') ?></li>
                        <li>Status: <span class="badge bg-info">Draft</span></li>
                    </ul>
                </div>
                
                <!-- Submit Button -->
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Upload Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-generate document code
    document.getElementById('departement').addEventListener('change', function() {
        var dept = this.value;
        var codeInput = document.getElementById('kode_dokumen');
        
        if (dept && !codeInput.value) {
            var deptCode = dept.substring(0, 3).toUpperCase();
            var year = new Date().getFullYear();
            var random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            
            codeInput.value = 'ISO-' + deptCode + '-' + random + '/' + year;
        }
    });
</script>
<?= $this->endSection() ?>