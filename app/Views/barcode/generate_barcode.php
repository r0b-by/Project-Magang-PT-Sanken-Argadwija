<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Generate QR Code Dokumen<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 fw-bold text-dark">Generate QR Code Dokumen</h1>
            <p class="text-muted small mb-0">Generate QR Code untuk dokumen ISO</p>
        </div>
        <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="toggleAllCheckboxes()">
            <i class="fas fa-check-square me-2"></i>Pilih Semua
        </button>
    </div>

    <!-- FLASH -->
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- FORM GENERATE -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-0 py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-file-circle-plus text-primary me-2"></i>Dokumen Belum Memiliki QR Code
            </h5>
        </div>
        <div class="card-body">

            <?php if (empty($belumBarcode)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted mb-0">Semua dokumen sudah memiliki QR Code</p>
                </div>
            <?php else: ?>

            <form action="/barcode/generate-bulk" method="post">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center"><input type="checkbox" id="checkAll"></th>
                                <th>Kode Dokumen</th>
                                <th class="d-none d-md-table-cell">Nama File</th>
                                <th class="d-none d-lg-table-cell">Uploader</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($belumBarcode as $dok): ?>
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="dokumen[]" value="<?= $dok['id'] ?>" class="dok-checkbox">
                                </td>
                                <td>
                                    <div class="fw-semibold"><?= esc($dok['kode_dokumen']) ?></div>
                                    <small class="text-muted"><?= esc($dok['nama_dokumen_internal']) ?></small>
                                </td>
                                <td class="d-none d-md-table-cell"><?= esc($dok['nama_file']) ?></td>
                                <td class="d-none d-lg-table-cell"><?= esc($dok['fullname'] ?? '-') ?></td>
                                <td class="text-center">
                                    <a href="/barcode/generate/<?= $dok['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <span class="text-muted small" id="selectedCount">0 dokumen dipilih</span>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-bolt me-2"></i>Generate Massal
                    </button>
                </div>
            </form>

            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const checkAll = document.getElementById('checkAll');
const checkboxes = document.querySelectorAll('.dok-checkbox');
const counter = document.getElementById('selectedCount');

checkAll?.addEventListener('change', () => {
    checkboxes.forEach(cb => cb.checked = checkAll.checked);
    updateCount();
});

checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

function updateCount(){
    const total = [...checkboxes].filter(cb => cb.checked).length;
    counter.innerText = total + ' dokumen dipilih';
}
</script>

<?= $this->endSection() ?>
