<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Dokumen Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
.form-check-input-lg {
    width: 1.4rem;
    height: 1.4rem;
    cursor: pointer;
}
</style>

<div class="container-fluid px-3 px-md-4 py-3">
    <h4 class="mb-3">
        Edit Dokumen Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- ================= FORM ASSIGN ================= -->
            <!-- FORM ASSIGN -->
            <!-- FORM ASSIGN -->
            <form action="<?= base_url('access/update-dokumen/' . $holder['id']) ?>" method="post">
                <?= csrf_field() ?>

                <label class="form-label fw-semibold mb-2">
                    Pilih Dokumen (hanya satu)
                </label>

                <div class="row g-3">
                    <?php foreach ($dokumen as $d): ?>
                        <?php
                            $ownedByThis  = $d['assigned_holder_id'] == $holder['id'];
                            $ownedByOther = !empty($d['assigned_holder_id']) && !$ownedByThis;
                        ?>

                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="form-check mb-2">
                                    <input
                                        type="radio"
                                        class="form-check-input form-check-input-lg"
                                        name="dokumen_id"
                                        value="<?= esc($d['id']) ?>"
                                        <?= $ownedByThis ? 'checked' : '' ?>
                                        <?= $ownedByOther ? 'disabled' : '' ?>
                                    >
                                    <label class="form-check-label <?= $ownedByOther ? 'text-muted' : '' ?>">
                                        <strong><?= esc($d['kode_dokumen']) ?></strong><br>
                                        <small><?= esc($d['nama_dokumen_internal']) ?></small>
                                    </label>
                                </div>

                                <?php if ($ownedByOther): ?>
                                    <span class="badge bg-secondary w-100 text-center">
                                        Dimiliki holder lain
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="<?= base_url('access') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>

            <!-- ================= FORM HAPUS DOKUMEN ================= -->
            <hr class="my-4">

            <h6 class="fw-semibold mb-3">Dokumen yang Dimiliki Holder</h6>

            <div class="row g-3">
                <?php foreach ($dokumen as $d): ?>
                    <?php if ($d['assigned_holder_id'] == $holder['id']): ?>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <strong><?= esc($d['kode_dokumen']) ?></strong><br>
                                <small><?= esc($d['nama_dokumen_internal']) ?></small>

                                <form action="<?= base_url('access/remove-dokumen') ?>" method="post" class="mt-2">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="holder_id" value="<?= $holder['id'] ?>">
                                    <input type="hidden" name="dokumen_id" value="<?= $d['id'] ?>">

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger w-100"
                                            onclick="return confirm('Hapus hak akses dokumen ini?')">
                                        <i class="fas fa-trash me-1"></i> Hapus Hak Akses
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
