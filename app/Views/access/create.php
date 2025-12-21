<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container col-md-6">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3 fw-semibold">Tambah Holder Code</h4>

            <!-- FLASH MESSAGE -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('access/store-holder') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Holder</label>
                    <input
                        type="text"
                        name="holder_code"
                        class="form-control text-uppercase"
                        placeholder="Contoh: HRD, IT, FIN"
                        maxlength="10"
                        autofocus
                        required
                        value="<?= old('holder_code') ?>"
                        oninput="this.value = this.value.toUpperCase()"
                    >
                    <small class="text-muted">
                        Maksimal 10 karakter, huruf & angka.
                    </small>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan & Lanjutkan
                    </button>

                    <a href="<?= base_url('access') ?>" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
