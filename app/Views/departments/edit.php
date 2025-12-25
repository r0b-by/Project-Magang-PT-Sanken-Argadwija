<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <h1 class="h4 fw-bold mb-4">Edit Department</h1>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('departments/update/'.$department['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="kode_dept" class="form-label">Kode Dept</label>
            <input type="text" class="form-control" id="kode_dept" name="kode_dept" 
                   value="<?= old('kode_dept', $department['kode_dept']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="nama_dept" class="form-label">Nama Dept</label>
            <input type="text" class="form-control" id="nama_dept" name="nama_dept" 
                   value="<?= old('nama_dept', $department['nama_dept']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('departments') ?>" class="btn btn-secondary">Batal</a>
    </form>

</div>

<?= $this->endSection() ?>
