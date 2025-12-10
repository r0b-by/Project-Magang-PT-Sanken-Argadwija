<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Upload Dokumen Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-upload me-2"></i>Upload Dokumen
        </h1>
        <a href="/iso00" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span class="d-none d-sm-inline"> Kembali</span>
        </a>
    </div>
    
    <!-- Form -->
    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="/iso00/store" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Document Code -->
                <div class="mb-3">
                    <label for="kode_dokumen" class="form-label small fw-bold">Kode Dokumen *</label>
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.kode_dokumen') ? 'is-invalid' : '' ?>" 
                           id="kode_dokumen" 
                           name="kode_dokumen" 
                           value="<?= old('kode_dokumen') ?>"
                           placeholder="ISO-001/2023"
                           required>
                    <?php if (session('errors.kode_dokumen')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.kode_dokumen') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Department -->
                <div class="mb-3">
                    <label for="departement" class="form-label small fw-bold">Departemen *</label>
                    <select class="form-select form-select-sm <?= session('errors.departement') ? 'is-invalid' : '' ?>" 
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
                        <div class="invalid-feedback small">
                            <?= session('errors.departement') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- File Upload -->
                <div class="mb-3">
                    <label for="upload_dokumen" class="form-label small fw-bold">File Dokumen *</label>
                    <input type="file" 
                           class="form-control form-control-sm <?= session('errors.upload_dokumen') ? 'is-invalid' : '' ?>" 
                           id="upload_dokumen" 
                           name="upload_dokumen" 
                           accept=".pdf"
                           required>
                    <small class="text-muted d-block mt-1">PDF only • Max 10MB</small>
                    <?php if (session('errors.upload_dokumen')): ?>
                        <div class="invalid-feedback small d-block">
                            <?= session('errors.upload_dokumen') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <div class="mb-3">
                    <label for="keterangan" class="form-label small fw-bold">Keterangan</label>
                    <textarea class="form-control form-control-sm <?= session('errors.keterangan') ? 'is-invalid' : '' ?>" 
                              id="keterangan" 
                              name="keterangan" 
                              rows="2"
                              placeholder="Catatan tentang dokumen ini"><?= old('keterangan') ?></textarea>
                    <?php if (session('errors.keterangan')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.keterangan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- System Info -->
                <div class="alert alert-info py-2 mb-3">
                    <div class="small">
                        <div class="fw-semibold">
                            <i class="fas fa-info-circle me-1"></i>Informasi:
                        </div>
                        <div class="mt-1">
                            <span class="badge bg-secondary"><?= session()->get('fullname') ?></span>
                            <span class="badge bg-secondary ms-1"><?= date('d/m/Y') ?></span>
                            <span class="badge bg-info ms-1">Draft</span>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i>
                        <span class="d-none d-sm-inline"> Reset</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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