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

<div class="container-fluid px-3 px-md-4 py-4">
    <h4 class="mb-4">
        Edit Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <div class="row">

        <!-- ================= KIRI: DOKUMEN DIMILIKI HOLDER LAIN ================= -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Dimiliki Holder Lain</h6>

                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Kode Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Holder</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dokumen as $d): ?>
                                <?php if(!empty($d['assigned_holder_id']) && $d['assigned_holder_id'] != $holder['id']): ?>
                                    <?php
                                        $holder_other = array_filter(
                                            $all_holders,
                                            fn($h) => $h['id'] == $d['assigned_holder_id']
                                        );
                                        $holder_code_other = !empty($holder_other)
                                            ? array_values($holder_other)[0]['holder_code']
                                            : '-';
                                    ?>
                                    <tr class="text-muted">
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($d['kode_dokumen']) ?></td>
                                        <td><?= esc($d['nama_dokumen_internal']) ?></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= esc($holder_code_other) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- ================= TENGAH: DOKUMEN BELUM DIMILIKI ================= -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Belum Dimiliki</h6>

                    <form id="assign-form"
                          action="<?= base_url('access/update-dokumen/' . $holder['id']) ?>"
                          method="post">
                        <?= csrf_field() ?>

                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:40px;" class="text-center">Pilih</th>
                                    <th>Kode Dokumen</th>
                                    <th>Nama Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dokumen as $d): ?>
                                    <?php if(empty($d['assigned_holder_id'])): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio"
                                                       class="form-check-input form-check-input-lg"
                                                       name="dokumen_id"
                                                       value="<?= esc($d['id']) ?>">
                                            </td>
                                            <td><?= esc($d['kode_dokumen']) ?></td>
                                            <td><?= esc($d['nama_dokumen_internal']) ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>

        <!-- ================= KANAN: AKSI (TIDAK DIUBAH) ================= -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 20px;">
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" form="assign-form" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="<?= base_url('access') ?>" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <h5 class="fw-semibold mb-3">
                    Dimiliki Holder:
                    <strong><?= esc($holder['holder_code']) ?></strong>
                </h5>

                <?php foreach ($dokumen as $d): ?>
                    <?php if($d['assigned_holder_id'] == $holder['id']): ?>
                        <div class="card border rounded mb-3 p-3 shadow-sm">
                            <strong>Kode Dok : <?= esc($d['kode_dokumen']) ?></strong><br>
                            <small>Dokumen : <?= esc($d['nama_dokumen_internal']) ?></small>

                            <form action="<?= base_url('access/remove-dokumen') ?>"
                                  method="post"
                                  class="mt-3">
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
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
