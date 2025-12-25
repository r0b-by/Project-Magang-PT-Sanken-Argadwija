<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold">Master Department</h1>
        <a href="<?= base_url('departments/create') ?>" class="btn btn-primary">Tambah Department</a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Kode Dept</th>
                <th>Nama Dept</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($departments as $dept): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($dept['kode_dept']) ?></td>
                <td><?= esc($dept['nama_dept']) ?></td>
                <td>
                    <a href="<?= base_url('departments/edit/'.$dept['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('departments/delete/'.$dept['id']) ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus department ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($departments)): ?>
            <tr>
                <td colspan="4" class="text-center">Tidak ada data department</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
