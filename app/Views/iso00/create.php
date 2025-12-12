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

                <!-- Kode Dokumen Terpisah -->
                <div class="mb-3 row">
                    <label class="form-label small fw-bold">Kode Dokumen *</label>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_internal" placeholder="IK" required>
                        <small class="text-muted">Kode Internal</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_dept" required>
                            <option value="">Pilih Dept</option>
                            <option value="QS">QS</option>
                            <option value="HRD">HRD</option>
                            <option value="IT">IT</option>
                            <option value="FIN">FIN</option>
                            <option value="MK">MK</option>
                            <option value="PRD">PRD</option>
                        </select>
                        <small class="text-muted">Kode Departemen</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_running" placeholder="001" required>
                        <small class="text-muted">Kode Running</small>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_dokumen" name="kode_dokumen" readonly placeholder="IK-QS001/2">
                        <small class="text-muted">Kode Dokumen Final</small>
                    </div>
                </div>

                <!-- Tanggal Efektif -->
                <div class="mb-3">
                    <label for="tanggal_efektif" class="form-label small fw-bold">Tanggal Efektif *</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_efektif" name="tanggal_efektif" required>
                </div>

                <!-- Halaman Dokumen -->
                <div class="mb-3">
                    <label for="halaman_dokumen" class="form-label small fw-bold">Halaman Dokumen</label>
                    <input type="text" class="form-control form-control-sm" id="halaman_dokumen" name="halaman_dokumen" placeholder="1-8">
                </div>

                <!-- Ruang Lingkup -->
                <div class="mb-3">
                    <label for="ruang_lingkup" class="form-label small fw-bold">Ruang Lingkup</label>
                    <textarea class="form-control form-control-sm" id="ruang_lingkup" name="ruang_lingkup" rows="2" placeholder="Ongoing QS"></textarea>
                </div>

                <!-- Tujuan -->
                <div class="mb-3">
                    <label for="tujuan" class="form-label small fw-bold">Tujuan</label>
                    <textarea class="form-control form-control-sm" id="tujuan" name="tujuan" rows="2" placeholder="Opsional"></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label for="upload_dokumen" class="form-label small fw-bold">File Dokumen *</label>
                    <input type="file" class="form-control form-control-sm" id="upload_dokumen" name="upload_dokumen" accept=".pdf" required>
                    <small class="text-muted">PDF only • Max 10MB</small>
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="document.getElementById('status_field').value='save'">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>

                <!-- Hidden status field -->
                <input type="hidden" id="status_field" name="status" value="save">
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
</script>

<?= $this->endSection() ?>
