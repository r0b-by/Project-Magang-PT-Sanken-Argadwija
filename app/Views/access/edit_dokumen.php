<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Dokumen Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
.form-check-input-lg {
    width: 1.4rem;
    height: 1.4rem;
    cursor: pointer;
}
.card-selectable {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.card-selectable:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.card-selectable input[type="radio"] {
    display: none;
}
.card-selectable.selected {
    border: 2px solid #0d6efd;
    background-color: #e7f1ff;
}
.card-selectable .owned-indicator {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background-color: #198754;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <h4 class="mb-4">
        Edit Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <div class="row">
        <!-- ================= KIRI: Dokumen Dimiliki Holder Lain ================= -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Dimiliki Holder Lain</h6>
                    <?php foreach ($dokumen as $d): ?>
                    <?php if(!empty($d['assigned_holder_id']) && $d['assigned_holder_id'] != $holder['id']): ?>
                        <?php
                            // Ambil kode holder dari id holder yang memiliki dokumen ini
                            $holder_other = array_filter($all_holders, function($h) use ($d) {
                                return $h['id'] == $d['assigned_holder_id'];
                            });
                            $holder_code_other = !empty($holder_other) ? array_values($holder_other)[0]['holder_code'] : '-';
                        ?>
                        <label class="card card-selectable p-3 bg-light text-muted mb-3">
                            <input type="radio" disabled>
                            <div>
                                <strong><?= esc($d['kode_dokumen']) ?></strong><br>
                                <small><?= esc($d['nama_dokumen_internal']) ?></small>
                            </div>
                            <span class="badge bg-secondary mt-2 w-100 text-center">
                                Dimiliki holder: <?= esc($holder_code_other) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- ================= TENGAH: Dokumen Belum Dimiliki ================= -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Belum Dimiliki</h6>
                    <form id="assign-form" action="<?= base_url('access/update-dokumen/' . $holder['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <?php foreach ($dokumen as $d): ?>
                            <?php if(empty($d['assigned_holder_id'])): ?>
                                <label class="card card-selectable p-3 mb-3">
                                    <input type="radio" name="dokumen_id" value="<?= esc($d['id']) ?>">
                                    <div>
                                        <strong><?= esc($d['kode_dokumen']) ?></strong><br>
                                        <small><?= esc($d['nama_dokumen_internal']) ?></small>
                                    </div>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- ================= KANAN: Tombol Aksi & Dokumen Dimiliki ================= -->
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

                <h5 class="fw-semibold mb-3">Dimiliki Holder: <strong><?= esc($holder['holder_code']) ?></strong></h5>
                <?php foreach ($dokumen as $d): ?>
                    <?php if($d['assigned_holder_id'] == $holder['id']): ?>
                        <div class="card border rounded mb-3 p-3 shadow-sm">
                            <strong>Kode Dok : <?= esc($d['kode_dokumen']) ?></strong><br>
                            <small>Dokumen : <?= esc($d['nama_dokumen_internal']) ?></small>
                            <form action="<?= base_url('access/remove-dokumen') ?>" method="post" class="mt-3">
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

<script>
document.querySelectorAll('.card-selectable').forEach(card => {
    card.addEventListener('click', function () {
        const radio = this.querySelector('input[type="radio"]');
        if (radio && !radio.disabled) {
            document.querySelectorAll('.card-selectable').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            radio.checked = true;
        }
    });
});
</script>
<?= $this->endSection() ?>