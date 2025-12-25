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

    <?php if(session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach(session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

    <!-- Form -->
    <div class="card">
        <div class="card-body p-3 p-md-4">
            <form action="/iso00/update/<?= $dokumen['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Info Revisi -->
                <div class="mb-3">
                    <span class="badge bg-info text-white">
                        Revisi ke-<?= $dokumen['revision_no'] + 1 ?>
                    </span>
                </div>

                <!-- Kode Dokumen Terpisah -->
                <div class="mb-3 row">
                    <label class="form-label small fw-bold">Kode Dokumen *</label>

                    <!-- Kode Internal -->
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="kode_internal" required>
                            <option value="">Pilih Kode</option>
                            <?php 
                            $kodeList = [
                                'VD' => 'DVD / Audio-Video','LD' => 'LED / LCD TV','SP' => 'Speaker Aktif',
                                'CR' => 'CTV Repair','WT' => 'Mesin Cuci','WD' => 'Dispenser',
                                'HA' => 'Home Appliances','SH' => 'Solar Water Heater','AP' => 'Air Cooler',
                                'DD' => 'Dish Dryer','EO' => 'Electric Oven','MOVEN' => 'Microwave Electric',
                                'SN' => 'Kulkas','AC' => 'Air Conditioner','SC' => 'Showcase',
                                'FZ' => 'Chest Freezer','GC' => 'Gas Cooker','FN' => 'Kipas Angin',
                                'SL' => 'Setrika Listrik','SJ' => 'Rice Cooker','QW' => 'QC Produk White Goods',
                                'QB' => 'QC Produk Brown Goods'
                            ];
                            foreach ($kodeList as $kode => $name): ?>
                                <option value="<?= $kode ?>" data-name="<?= $name ?>" <?= (strpos($dokumen['kode_dokumen'], $kode) === 0) ? 'selected' : '' ?>>
                                    <?= $kode ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Kode Internal</small>
                    </div>

                    <!-- Nama Dokumen Internal -->
                    <div class="col-md-3 mb-2">
                        <input type="text" class="form-control form-control-sm" id="nama_internal"
                               name="nama_dokumen_internal"
                               value="<?= $dokumen['nama_dokumen_internal'] ?? '' ?>" readonly>
                        <small class="text-muted">Nama Dokumen Internal</small>
                    </div>

                    <!-- Kode Departemen -->
                    <div class="col-md-3 mb-2">
                        <select class="form-select form-select-sm" id="department_id" name="department_id" required>
                            <option value="">Pilih Dept</option>
                            <?php if (!empty($departments)): ?>
                                <?php foreach($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>" data-kode="<?= $dept['kode_dept'] ?>" 
                                        <?= ($dokumen['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                                        <?= $dept['kode_dept'] ?> - <?= $dept['nama_dept'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">Departemen</small>
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

                <!-- Hidden Status & Revision No -->
                <input type="hidden" name="status" value="revisi">
                <input type="hidden" name="revision_no" value="<?= $dokumen['revision_no'] + 1 ?>">

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
    // Isi Nama Dokumen Internal otomatis
    document.getElementById('kode_internal').addEventListener('change', function(){
        const selected = this.selectedOptions[0];
        document.getElementById('nama_internal').value = selected.dataset.name || '';
        updateKodeDokumen();
    });

    // Update Kode Dokumen Final otomatis
    const kodeDeptSelect = document.getElementById('department_id');
    const kodeRunning = document.getElementById('kode_running');
    const kodeFinal = document.getElementById('kode_dokumen');

    function updateKodeDokumen() {
        const kodeInternal = document.getElementById('kode_internal').value;
        const deptOption = kodeDeptSelect.selectedOptions[0];
        const kodeDept = deptOption ? deptOption.dataset.kode : '';
        const running = kodeRunning.value;

        if(kodeInternal && kodeDept && running) {
            kodeFinal.value = `${kodeInternal}-${kodeDept}${running}`;
        } else {
            kodeFinal.value = '';
        }
    }

    kodeDeptSelect.addEventListener('change', updateKodeDokumen);
    kodeRunning.addEventListener('input', updateKodeDokumen);
</script>

<?= $this->endSection() ?>
