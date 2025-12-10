<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>History Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h3 class="mb-4">History Semua Dokumen</h3>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dokumen Master</th>
                        <th>Nama File</th>
                        <th>Status</th>
                        <th>Uploaded By</th>
                        <th>Uploaded At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($all_history as $history): ?>
                        <tr>
                            <td><?= $history['id'] ?></td>
                            <td><?= $history['iso00_id'] ?></td>
                            <td><?= $history['nama_file'] ?></td>
                            <td><?= $history['status'] ?></td>
                            <td><?= $history['uploader_name'] ?></td>
                            <td><?= $history['uploaded_at'] ?></td>
                            <td>
                                <a href="<?= base_url('iso00/view/'.$history['id']) ?>" class="btn btn-sm btn-primary">View</a>
                                <a href="<?= base_url('iso00/download/'.$history['id']) ?>" class="btn btn-sm btn-success">Download</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
