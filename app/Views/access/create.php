<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h3>Tambah Hak Akses Dokumen</h3>
    <hr>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <form action="/access/store" method="POST">

        <div class="mb-3">
            <label>Pilih User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                <?php foreach($users as $user): ?>
                <option value="<?= $user['id'] ?>">
                    <?= esc($user['fullname']) ?> (<?= esc($user['username']) ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Pilih Dokumen yang Diizinkan</label>
            <select name="dokumen_id" class="form-control" required>
                <option value="">-- Pilih Dokumen --</option>
                <?php foreach($dokumen as $doc): ?>
                <option value="<?= $doc['id'] ?>">
                    <?= esc($doc['kode_dokumen']) ?> - <?= esc($doc['nama_dokumen_internal']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Kode Holder</label>
            <input type="text" name="holder_code" class="form-control" placeholder="cth: 1A" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/access" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection(); ?>
