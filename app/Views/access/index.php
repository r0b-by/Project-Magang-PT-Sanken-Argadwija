<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Daftar Hak Akses Dokumen</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <a href="/access/create" class="btn btn-primary mb-3">+ Tambah Hak Akses</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Holder Code</th>
                <th>Nama User</th>
                <th>Kode Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($akses as $row): ?>
            <tr>
                <td><?= esc($row->holder_code) ?></td>
                <td><?= esc($row->fullname) ?></td>
                <td><?= esc($row->kode_dokumen) ?></td>
                <td><?= esc($row->nama_dokumen_internal) ?></td>

                <td>
                    <a href="/access/delete/<?= $row->id ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus akses ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
