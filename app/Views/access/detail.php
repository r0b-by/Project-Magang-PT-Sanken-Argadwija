<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-3">Detail Holder: <?= esc($holder['holder_code']) ?></h4>

    <div class="mb-3">
        <strong>Dokumen:</strong>

        <?php if (!empty($dokumen)): ?>
            <ul class="mt-2">
                <?php foreach ($dokumen as $d): ?>
                    <li>
                        <?= esc($d['kode_dokumen']) ?> -
                        <?= esc($d['nama_dokumen_internal']) ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php else: ?>
            <p class="text-muted mt-2">Belum ada dokumen yang di-assign</p>
        <?php endif ?>
    </div>

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
