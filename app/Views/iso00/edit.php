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

                    <!-- Kode Internal -->
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_internal" required>
                            <option value="">Pilih Kode</option>
                            <option value="VD" data-name="DVD / Audio-Video" <?= (strpos($dokumen['kode_dokumen'], 'VD') === 0) ? 'selected' : '' ?>>VD</option>
                            <option value="LD" data-name="LED / LCD TV" <?= (strpos($dokumen['kode_dokumen'], 'LD') === 0) ? 'selected' : '' ?>>LD</option>
                            <option value="SP" data-name="Speaker Aktif" <?= (strpos($dokumen['kode_dokumen'], 'SP') === 0) ? 'selected' : '' ?>>SP</option>
                            <option value="CR" data-name="CTV Repair" <?= (strpos($dokumen['kode_dokumen'], 'CR') === 0) ? 'selected' : '' ?>>CR</option>
                            <option value="WT" data-name="Mesin Cuci" <?= (strpos($dokumen['kode_dokumen'], 'WT') === 0) ? 'selected' : '' ?>>WT</option>
                            <option value="WD" data-name="Dispenser" <?= (strpos($dokumen['kode_dokumen'], 'WD') === 0) ? 'selected' : '' ?>>WD</option>
                            <option value="HA" data-name="Home Appliances" <?= (strpos($dokumen['kode_dokumen'], 'HA') === 0) ? 'selected' : '' ?>>HA</option>
                            <option value="SH" data-name="Solar Water Heater" <?= (strpos($dokumen['kode_dokumen'], 'SH') === 0) ? 'selected' : '' ?>>SH</option>
                            <option value="AP" data-name="Air Cooler" <?= (strpos($dokumen['kode_dokumen'], 'AP') === 0) ? 'selected' : '' ?>>AP</option>
                            <option value="DD" data-name="Dish Dryer" <?= (strpos($dokumen['kode_dokumen'], 'DD') === 0) ? 'selected' : '' ?>>DD</option>
                            <option value="EO" data-name="Electric Oven" <?= (strpos($dokumen['kode_dokumen'], 'EO') === 0) ? 'selected' : '' ?>>EO</option>
                            <option value="MOVEN" data-name="Microwave Electric" <?= (strpos($dokumen['kode_dokumen'], 'MOVEN') === 0) ? 'selected' : '' ?>>MOVEN</option>
                            <option value="SN" data-name="Kulkas" <?= (strpos($dokumen['kode_dokumen'], 'SN') === 0) ? 'selected' : '' ?>>SN</option>
                            <option value="AC" data-name="Air Conditioner" <?= (strpos($dokumen['kode_dokumen'], 'AC') === 0) ? 'selected' : '' ?>>AC</option>
                            <option value="SC" data-name="Showcase" <?= (strpos($dokumen['kode_dokumen'], 'SC') === 0) ? 'selected' : '' ?>>SC</option>
                            <option value="FZ" data-name="Chest Freezer" <?= (strpos($dokumen['kode_dokumen'], 'FZ') === 0) ? 'selected' : '' ?>>FZ</option>
                            <option value="GC" data-name="Gas Cooker" <?= (strpos($dokumen['kode_dokumen'], 'GC') === 0) ? 'selected' : '' ?>>GC</option>
                            <option value="FN" data-name="Kipas Angin" <?= (strpos($dokumen['kode_dokumen'], 'FN') === 0) ? 'selected' : '' ?>>FN</option>
                            <option value="SL" data-name="Setrika Listrik" <?= (strpos($dokumen['kode_dokumen'], 'SL') === 0) ? 'selected' : '' ?>>SL</option>
                            <option value="SJ" data-name="Rice Cooker" <?= (strpos($dokumen['kode_dokumen'], 'SJ') === 0) ? 'selected' : '' ?>>SJ</option>
                            <option value="QW" data-name="QC Produk White Goods" <?= (strpos($dokumen['kode_dokumen'], 'QW') === 0) ? 'selected' : '' ?>>QW</option>
                            <option value="QB" data-name="QC Produk Brown Goods" <?= (strpos($dokumen['kode_dokumen'], 'QB') === 0) ? 'selected' : '' ?>>QB</option>
                        </select>
                        <small class="text-muted">Kode Internal</small>
                    </div>

                    <!-- Nama Dokumen Internal -->
                    <div class="col-md-3 mb-2">
                        <input type="text" 
                            class="form-control form-control-sm" 
                            id="nama_internal"
                            name="nama_dokumen_internal"
                            value="<?= $dokumen['nama_dokumen_internal'] ?? '' ?>" 
                            readonly>
                        <small class="text-muted">Nama Dokumen Internal</small>
                    </div>

                    <!-- Kode Departemen -->
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_dept" required>
                            <option value="">Pilih Dept</option>
                            <?php 
                                $deptList = ['QS','HRD','IT','FIN','MK','PRD'];
                                foreach ($deptList as $d): 
                            ?>
                                <option value="<?= $d ?>" <?= (strpos($dokumen['kode_dokumen'], $d) !== false) ? 'selected' : '' ?>>
                                    <?= $d ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Kode Departemen</small>
                    </div>

                    <!-- Kode Running -->
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_running"
                               value="<?= preg_replace('/[^0-9]/', '', $dokumen['kode_dokumen']) ?>" required>
                        <small class="text-muted">Kode Running</small>
                    </div>

                    <!-- Final Kode Dokumen -->
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="kode_dokumen"
                               name="kode_dokumen" readonly
                               value="<?= $dokumen['kode_dokumen'] ?>">
                        <small class="text-muted">Kode Dokumen Final</small>
                    </div>
                </div>

                <!-- Tanggal Efektif -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tanggal Efektif *</label>
                    <input type="date" class="form-control form-control-sm"
                           id="tanggal_efektif"
                           name="tanggal_efektif"
                           value="<?= $dokumen['tanggal_efektif'] ?? '' ?>"
                           required>
                </div>

                <!-- Halaman -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Halaman Dokumen</label>
                    <input type="text" class="form-control form-control-sm" name="halaman_dokumen"
                           value="<?= $dokumen['halaman_dokumen'] ?? '' ?>">
                </div>

                <!-- Ruang Lingkup -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Ruang Lingkup</label>
                    <textarea name="ruang_lingkup" class="form-control form-control-sm" rows="2"><?= $dokumen['ruang_lingkup'] ?? '' ?></textarea>
                </div>

                <!-- Tujuan -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tujuan</label>
                    <textarea name="tujuan" class="form-control form-control-sm" rows="2"><?= $dokumen['tujuan'] ?? '' ?></textarea>
                </div>

                <!-- File Lama -->
                <?php if ($dokumen['nama_file']): ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold">File Saat Ini</label>
                    <div class="alert alert-light small">
                        <i class="fas fa-file-pdf text-danger me-2"></i><?= $dokumen['nama_file'] ?>
                        <div class="mt-2">
                            <a href="/iso00/view/<?= $dokumen['id'] ?>" target="_blank" class="me-3">Lihat</a>
                            <a href="/iso00/download/<?= $dokumen['id'] ?>">Download</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- File Baru -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">File Baru</label>
                    <input type="file" class="form-control form-control-sm" name="upload_dokumen" accept="application/pdf">
                    <small class="text-muted">Kosongkan jika tidak ganti • PDF Max 10MB</small>
                </div>

                <!-- Barcode -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Barcode</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $dokumen['barcode'] ?>">
                        <button type="button" class="btn btn-outline-secondary" onclick="generateBarcode()">
                            <i class="fas fa-barcode"></i>
                        </button>
                    </div>
                </div>

                <!-- Hidden Status -->
                <input type="hidden" name="status" value="revisi">

                <!-- Tombol -->
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
function updateKodeDokumen() {
    let ik   = document.getElementById('kode_internal').value.toUpperCase();
    let dept = document.getElementById('kode_dept').value.toUpperCase();
    let run  = document.getElementById('kode_running').value;
    let out  = document.getElementById('kode_dokumen');

    out.value = (ik && dept && run) ? ik + '-' + dept + run : "";
}

// Nama dokumen internal auto tampil
document.getElementById('kode_internal').addEventListener('change', function() {
    let name = this.options[this.selectedIndex].getAttribute('data-name') || "";
    document.getElementById('nama_internal').value = name;
    updateKodeDokumen();
});

document.getElementById('kode_internal').addEventListener('input', updateKodeDokumen);
document.getElementById('kode_dept').addEventListener('change', updateKodeDokumen);
document.getElementById('kode_running').addEventListener('input', updateKodeDokumen);

// Generate barcode otomatis
function generateBarcode() {
    let input = document.getElementById('barcode');
    if (!input.value) {
        let r = Math.random().toString(36).substring(2, 8).toUpperCase();
        let y = new Date().getFullYear();
        input.value = `DOC-${r}-${y}`;
    }
}
</script>
<?= $this->endSection() ?>
