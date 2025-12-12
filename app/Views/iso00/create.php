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

                    <!-- KODE INTERNAL -->
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_internal" required>
                            <option value="">Pilih Kode</option>
                            <option value="VD" data-name="DVD / Audio-Video">VD</option>
                            <option value="LD" data-name="LED / LCD TV">LD</option>
                            <option value="SP" data-name="Speaker Aktif">SP</option>
                            <option value="CR" data-name="CTV Repair">CR</option>
                            <option value="WT" data-name="Mesin Cuci">WT</option>
                            <option value="WD" data-name="Dispenser">WD</option>
                            <option value="HA" data-name="Home Appliances">HA</option>
                            <option value="SH" data-name="Solar Water Heater">SH</option>
                            <option value="AP" data-name="Air Cooler">AP</option>
                            <option value="DD" data-name="Dish Dryer">DD</option>
                            <option value="EO" data-name="Electric Oven">EO</option>
                            <option value="MOVEN" data-name="Microwave Electric">MOVEN</option>
                            <option value="SN" data-name="Kulkas">SN</option>
                            <option value="AC" data-name="Air Conditioner">AC</option>
                            <option value="SC" data-name="Showcase">SC</option>
                            <option value="FZ" data-name="Chest Freezer">FZ</option>
                            <option value="GC" data-name="Gas Cooker">GC</option>
                            <option value="FN" data-name="Kipas Angin">FN</option>
                            <option value="SL" data-name="Setrika Listrik">SL</option>
                            <option value="SJ" data-name="Rice Cooker">SJ</option>
                            <option value="QW" data-name="QC Produk White Goods">QW</option>
                            <option value="QB" data-name="QC Produk Brown Goods">QB</option>
                        </select>
                        <small class="text-muted">Kode Internal</small>
                    </div>

                    <!-- NAMA DOKUMEN INTERNAL -->
                    <div class="col-md-3 mb-2">
                        <input type="text" 
                            class="form-control form-control-sm" 
                            id="nama_internal" 
                            name="nama_dokumen_internal"
                            placeholder="Nama Dokumen" 
                            readonly>
                        <small class="text-muted">Nama Dokumen Internal</small>
                    </div>


                    <!-- KODE DEPARTEMEN -->
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

                    <!-- KODE RUNNING -->
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_running" 
                               placeholder="001" required>
                        <small class="text-muted">Kode Running</small>
                    </div>

                    <!-- KODE DOKUMEN FINAL -->
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_dokumen"
                               name="kode_dokumen" readonly placeholder="IK-QS001">
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
                    <textarea class="form-control form-control-sm" id="ruang_lingkup" name="ruang_lingkup" rows="2"></textarea>
                </div>

                <!-- Tujuan -->
                <div class="mb-3">
                    <label for="tujuan" class="form-label small fw-bold">Tujuan</label>
                    <textarea class="form-control form-control-sm" id="tujuan" name="tujuan" rows="2"></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label for="upload_dokumen" class="form-label small fw-bold">File Dokumen *</label>
                    <input type="file" class="form-control form-control-sm" id="upload_dokumen" 
                           name="upload_dokumen" accept=".pdf" required>
                    <small class="text-muted">PDF only • Max 10MB</small>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm"
                            onclick="document.getElementById('status_field').value='save'">
                        <i class="fas fa-upload me-1"></i>Upload
                    </button>
                </div>

                <input type="hidden" id="status_field" name="status" value="save">
            </form>
        </div>
    </div>
</div>

<script>
// Update kode dokumen final
function updateKodeDokumen() {
    let ik   = document.getElementById('kode_internal').value.toUpperCase();
    let dept = document.getElementById('kode_dept').value.toUpperCase();
    let run  = document.getElementById('kode_running').value;

    let output = document.getElementById('kode_dokumen');

    if (ik && dept && run) {
        output.value = ik + '-' + dept + run;
    } else {
        output.value = '';
    }
}

// Tampilkan nama dokumen otomatis
document.getElementById('kode_internal').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];
    let name = selected.getAttribute('data-name') || '';
    document.getElementById('nama_internal').value = name;
    updateKodeDokumen();
});

// Update kode final saat dept/run berubah
document.getElementById('kode_dept').addEventListener('change', updateKodeDokumen);
document.getElementById('kode_running').addEventListener('input', updateKodeDokumen);
</script>

<?= $this->endSection() ?>
