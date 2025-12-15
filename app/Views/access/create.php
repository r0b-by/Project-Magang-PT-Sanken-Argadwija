<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container">
    <h4 class="mb-3">Tambah Holder Code</h4>

    <form method="post" action="<?= base_url('access/store-holder') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Kode Holder</label>
            <input type="text" name="holder_code" class="form-control"
                   placeholder="Contoh: 1A, 2B"
                   required>
        </div>

        <button class="btn btn-primary">Simpan & Lanjutkan</button>
        <a href="<?= base_url('access') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
