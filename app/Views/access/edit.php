<?= $this->extend('layouts/main') ?>
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
                    <label class="form-label">Kode Holder</label>
                    <input type="text"
                           name="holder_code"
                           class="form-control"
                           value="<?= esc($holder['holder_code']) ?>"
                           required>
                </div>

                <!-- PILIH DOKUMEN -->
                <div class="mb-3">
                    <label class="form-label">Dokumen</label>
                    <select name="dokumen_id" class="form-select">
                        <option value="">-- Tidak ada dokumen --</option>
                        <?php foreach ($dokumen as $doc): ?>
                            <option value="<?= $doc['id'] ?>"
                                <?= $holder['dokumen_id'] == $doc['id'] ? 'selected' : '' ?>>
                                <?= esc($doc['kode_dokumen']) ?> - <?= esc($doc['nama_dokumen_internal']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="card-footer text-end">
                <a href="<?= site_url('access') ?>" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
