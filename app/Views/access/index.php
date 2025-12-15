<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Master Holder Dokumen</h4>
        <a href="<?= base_url('access/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Holder
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif ?>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Kode Holder</th>
                <th>Dokumen</th>
                <th>Total User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($holders as $h): ?>
                <tr>
                    <td><strong><?= esc($h['holder_code']) ?></strong></td>
                    <td><?= esc($h['kode_dokumen'] ?? '-') ?></td>
                    <td><?= esc($h['total_users']) ?></td>
                    <td>
                        <a href="<?= base_url('access/detail/'.$h['holder_code']) ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?= base_url('access/assign/'.$h['holder_code']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('access/delete-holder/'.$h['id']) ?>"
                           onclick="return confirm('Hapus holder ini?')"
                           class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
