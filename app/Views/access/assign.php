<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-3">
        Assign Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <form method="post" action="<?= base_url('access/store-assignment') ?>">
        <?= csrf_field() ?>

        <input type="hidden" name="holder_id" value="<?= esc($holder['id']) ?>">

        <!-- ===================== -->
        <!-- DOKUMEN -->
        <!-- ===================== -->
        <div class="mb-3">
            <label class="form-label">Dokumen</label>
            <select name="dokumen_id" class="form-control" required>
    <option value="">-- Pilih Dokumen --</option>
    <?php foreach ($dokumen as $d): ?>
        <option value="<?= $d['id'] ?>">
            <?= esc($d['kode_dokumen']) ?> - <?= esc($d['nama_dokumen_internal']) ?>
        </option>
    <?php endforeach ?>
</select>
        </div>

        <!-- ===================== -->
        <!-- USERS -->
        <!-- ===================== -->
        <div class="mb-3">
            <label class="form-label">Pilih User</label>

            <?php
                // 🔥 AMAN: jika assignedUsers belum ada / kosong
                $assignedUserIds = array_column($assignedUsers ?? [], 'user_id');
            ?>

            <?php foreach ($users as $u): ?>
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="user_ids[]"
                           value="<?= $u['id'] ?>"
                           <?= in_array($u['id'], $assignedUserIds) ? 'checked' : '' ?>>

                    <label class="form-check-label">
                        <?= esc($u['fullname']) ?>
                        <small class="text-muted">(<?= esc($u['username']) ?>)</small>
                    </label>
                </div>
            <?php endforeach ?>
        </div>

        <!-- ===================== -->
        <!-- ACTION -->
        <!-- ===================== -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan
        </button>

        <a href="<?= base_url('access') ?>" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

<?= $this->endSection() ?>
