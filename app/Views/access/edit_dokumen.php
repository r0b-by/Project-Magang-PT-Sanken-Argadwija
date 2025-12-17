<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Dokumen Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <h4 class="mb-3">
        Edit Dokumen Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('access/update-dokumen/' . $holder['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="dokumen_id" class="form-label fw-semibold">Pilih Dokumen</label>
                    <select name="dokumen_id" id="dokumen_id" class="form-control" required>
                        <option value="">-- Pilih Dokumen --</option>
                        <?php foreach ($dokumen as $d): ?>
                            <option value="<?= esc($d['id']) ?>" 
                                <?= ($holder['dokumen_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
                                <?= esc($d['kode_dokumen']) ?> - <?= esc($d['nama_dokumen_internal']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-start mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('access') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
