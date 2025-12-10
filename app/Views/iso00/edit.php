<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Edit Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Dokumen
        </h1>
        <a href="/iso00" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span class="d-none d-sm-inline"> Kembali</span>
        </a>
    </div>
    
    <!-- Form -->
    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="/iso00/update/<?= $dokumen['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Document Code -->
                <div class="mb-3">
                    <label for="kode_dokumen" class="form-label small fw-bold">Kode Dokumen *</label>
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.kode_dokumen') ? 'is-invalid' : '' ?>"
                           id="kode_dokumen" 
                           name="kode_dokumen"
                           value="<?= old('kode_dokumen', $dokumen['kode_dokumen'] ?? '') ?>"
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
                    <input type="text" 
                           class="form-control form-control-sm <?= session('errors.departement') ? 'is-invalid' : '' ?>"
                           id="departement" 
                           name="departement"
                           value="<?= old('departement', $dokumen['departement'] ?? '') ?>"
                           required>
                    <?php if (session('errors.departement')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.departement') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <div class="mb-3">
                    <label for="keterangan" class="form-label small fw-bold">Keterangan</label>
                    <textarea class="form-control form-control-sm <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                              id="keterangan" 
                              name="keterangan"
                              rows="2"><?= old('keterangan', $dokumen['keterangan'] ?? '') ?></textarea>
                    <?php if (session('errors.keterangan')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.keterangan') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label small fw-bold">Status</label>
                    <select class="form-select form-select-sm <?= session('errors.status') ? 'is-invalid' : '' ?>"
                            id="status" 
                            name="status">
                        <option value="save" <?= (old('status', $dokumen['status'] ?? '') == 'save') ? 'selected' : '' ?>>Save</option>
                        <option value="revisi" <?= (old('status', $dokumen['status'] ?? '') == 'revisi') ? 'selected' : '' ?>>Revisi</option>
                    </select>
                    <?php if (session('errors.status')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.status') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Current File -->
                <?php if (!empty($dokumen['nama_file'])): ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold">File Saat Ini</label>
                    <div class="alert alert-light py-2 small">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?= $dokumen['nama_file'] ?></div>
                                <div class="d-flex gap-2 mt-1">
                                    <a href="/iso00/view/<?= $dokumen['id'] ?>" 
                                       target="_blank"
                                       class="text-decoration-none small">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                    <a href="/iso00/download/<?= $dokumen['id'] ?>" 
                                       class="text-decoration-none small">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- New File -->
                <div class="mb-3">
                    <label for="upload_dokumen" class="form-label small fw-bold">File Baru</label>
                    <input type="file" 
                           class="form-control form-control-sm <?= session('errors.upload_dokumen') ? 'is-invalid' : '' ?>"
                           id="upload_dokumen" 
                           name="upload_dokumen"
                           accept=".pdf">
                    <small class="text-muted d-block mt-1">PDF only • Max 10MB • Kosongkan jika tidak ganti</small>
                    <?php if (session('errors.upload_dokumen')): ?>
                        <div class="invalid-feedback small d-block">
                            <?= session('errors.upload_dokumen') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Barcode -->
                <div class="mb-3">
                    <label for="barcode" class="form-label small fw-bold">Barcode</label>
                    <div class="input-group input-group-sm">
                        <input type="text" 
                               class="form-control <?= session('errors.barcode') ? 'is-invalid' : '' ?>"
                               id="barcode" 
                               name="barcode"
                               value="<?= old('barcode', $dokumen['barcode'] ?? '') ?>"
                               placeholder="Kosongkan untuk auto-generate">
                        <button type="button" 
                                class="btn btn-outline-secondary"
                                onclick="generateBarcode()">
                            <i class="fas fa-barcode"></i>
                        </button>
                    </div>
                    <?php if (session('errors.barcode')): ?>
                        <div class="invalid-feedback small">
                            <?= session('errors.barcode') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($dokumen['barcode'])): ?>
                        <div class="alert alert-danger py-1 px-2 mt-2 small">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Barcode belum dibuat - belum bisa discan
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">Kode untuk scanning</small>
                            <a href="/iso00/print-barcode/<?= $dokumen['id'] ?>" 
                               target="_blank"
                               class="btn btn-outline-info btn-sm">
                                <i class="fas fa-print"></i>
                                <span class="d-none d-sm-inline"> Cetak</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Uploader Info -->
                <div class="alert alert-info py-2 mb-3 small">
                    <div class="fw-semibold">
                        <i class="fas fa-user me-1"></i>
                        <?= $dokumen['uploader_name'] ?? 'Unknown' ?>
                    </div>
                    <div class="mt-1">
                        <span class="badge bg-secondary"><?= date('d/m/Y', strtotime($dokumen['uploaded_at'])) ?></span>
                        <?php if (!empty($dokumen['updated_at'])): ?>
                            <span class="badge bg-secondary ms-1">Update: <?= date('d/m/Y', strtotime($dokumen['updated_at'])) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="/iso00" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times"></i>
                        <span class="d-none d-sm-inline"> Batal</span>
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Actions (Mobile) -->
    <div class="row g-2 mt-3 d-lg-none">
        <div class="col-6">
            <a href="/iso00/view/<?= $dokumen['id'] ?>" 
               target="_blank"
               class="btn btn-outline-primary w-100 btn-sm">
                <i class="fas fa-eye me-1"></i>Lihat
            </a>
        </div>
        <div class="col-6">
            <a href="/iso00/download/<?= $dokumen['id'] ?>" 
               class="btn btn-outline-success w-100 btn-sm">
                <i class="fas fa-download me-1"></i>Download
            </a>
        </div>
    </div>
</div>

<script>
function generateBarcode() {
    var codeInput = document.getElementById('barcode');
    if (!codeInput.value) {
        var random = Math.random().toString(36).substring(2, 10).toUpperCase();
        var year = new Date().getFullYear();
        codeInput.value = 'DOC-' + random + '-' + year;
    }
}
</script>
<?= $this->endSection() ?>