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

                <!-- Kode Dokumen Terpisah -->
                <div class="mb-3 row">
                    <label class="form-label small fw-bold">Kode Dokumen *</label>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_internal" 
                               value="<?= substr($dokumen['kode_dokumen'],0,2) ?>" required>
                        <small class="text-muted">Kode Internal</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_dept" required>
                            <option value="">Pilih Dept</option>
                            <option value="QS" <?= strpos($dokumen['kode_dokumen'],'QS')!==false ? 'selected':'' ?>>QS</option>
                            <option value="HRD" <?= strpos($dokumen['kode_dokumen'],'HRD')!==false ? 'selected':'' ?>>HRD</option>
                            <option value="IT" <?= strpos($dokumen['kode_dokumen'],'IT')!==false ? 'selected':'' ?>>IT</option>
                            <option value="FIN" <?= strpos($dokumen['kode_dokumen'],'FIN')!==false ? 'selected':'' ?>>FIN</option>
                            <option value="MK" <?= strpos($dokumen['kode_dokumen'],'MK')!==false ? 'selected':'' ?>>MK</option>
                            <option value="PRD" <?= strpos($dokumen['kode_dokumen'],'PRD')!==false ? 'selected':'' ?>>PRD</option>
                        </select>
                        <small class="text-muted">Kode Departemen</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_running" 
                               value="<?= preg_replace('/[^0-9]/','', $dokumen['kode_dokumen']) ?>" required>
                        <small class="text-muted">Kode Running</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_dokumen" 
                               name="kode_dokumen" readonly
                               value="<?= $dokumen['kode_dokumen'] ?>">
                        <small class="text-muted">Kode Dokumen Final</small>
                    </div>
                </div>

                <!-- Tanggal Efektif -->
                <div class="mb-3">
                    <label for="tanggal_efektif" class="form-label small fw-bold">Tanggal Efektif *</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_efektif" name="tanggal_efektif"
                           value="<?= old('tanggal_efektif', $dokumen['tanggal_efektif'] ?? '') ?>" required>
                </div>

                <!-- Halaman Dokumen -->
                <div class="mb-3">
                    <label for="halaman_dokumen" class="form-label small fw-bold">Halaman Dokumen</label>
                    <input type="text" class="form-control form-control-sm" id="halaman_dokumen" name="halaman_dokumen"
                           value="<?= old('halaman_dokumen', $dokumen['halaman_dokumen'] ?? '') ?>">
                </div>

                <!-- Ruang Lingkup -->
                <div class="mb-3">
                    <label for="ruang_lingkup" class="form-label small fw-bold">Ruang Lingkup</label>
                    <textarea class="form-control form-control-sm" id="ruang_lingkup" name="ruang_lingkup" rows="2"><?= old('ruang_lingkup', $dokumen['ruang_lingkup'] ?? '') ?></textarea>
                </div>

                <!-- Tujuan -->
                <div class="mb-3">
                    <label for="tujuan" class="form-label small fw-bold">Tujuan</label>
                    <textarea class="form-control form-control-sm" id="tujuan" name="tujuan" rows="2"><?= old('tujuan', $dokumen['tujuan'] ?? '') ?></textarea>
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
                                    <a href="/iso00/view/<?= $dokumen['id'] ?>" target="_blank" class="small">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                    <a href="/iso00/download/<?= $dokumen['id'] ?>" class="small">
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
                    <input type="file" class="form-control form-control-sm" id="upload_dokumen" name="upload_dokumen" accept=".pdf">
                    <small class="text-muted">PDF only • Max 10MB • Kosongkan jika tidak ganti</small>
                </div>

                <!-- Barcode -->
                <div class="mb-3">
                    <label for="barcode" class="form-label small fw-bold">Barcode</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $dokumen['barcode'] ?? '' ?>">
                        <button type="button" class="btn btn-outline-secondary" onclick="generateBarcode()"><i class="fas fa-barcode"></i></button>
                    </div>
                </div>

                <!-- Hidden status untuk revisi -->
                <input type="hidden" name="status" value="revisi">

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="/iso00" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Gabungkan tiga kode menjadi satu
function updateKodeDokumen() {
    var ik = document.getElementById('kode_internal').value.toUpperCase();
    var dept = document.getElementById('kode_dept').value.toUpperCase();
    var run = document.getElementById('kode_running').value;
    var output = document.getElementById('kode_dokumen');

    if (ik && dept && run) {
        output.value = ik + '-' + dept + run;
    } else {
        output.value = '';
    }
}

document.getElementById('kode_internal').addEventListener('input', updateKodeDokumen);
document.getElementById('kode_dept').addEventListener('change', updateKodeDokumen);
document.getElementById('kode_running').addEventListener('input', updateKodeDokumen);

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
