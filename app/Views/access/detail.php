<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-3">Detail Holder: <?= esc($holder['holder_code']) ?></h4>

    <p>
        <strong>Dokumen:</strong>
        <?= esc($holder['kode_dokumen'] ?? '-') ?> -
        <?= esc($holder['nama_dokumen_internal'] ?? '-') ?>
    </p>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nama User</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= esc($u['fullname']) ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td>
                        <a href="<?= base_url('access/remove-user/'.$u['access_id']) ?>"
                           onclick="return confirm('Hapus user ini dari holder?')"
                           class="btn btn-danger btn-sm">
                            Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <a href="<?= base_url('access') ?>" class="btn btn-secondary">Kembali</a>
</div>

<?= $this->endSection() ?>
