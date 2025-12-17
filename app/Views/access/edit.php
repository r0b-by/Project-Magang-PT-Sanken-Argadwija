<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <strong>Edit Holder</strong>
        </div>

        <form action="<?= site_url('access/update-holder/' . $holder['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="card-body">

                <!-- KODE HOLDER -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Holder</label>
                    <input type="text"
                           name="holder_code"
                           class="form-control"
                           value="<?= esc($holder['holder_code']) ?>"
                           required>
                </div>

            </div>

            <div class="card-footer text-end">
                <a href="<?= site_url('access') ?>" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
