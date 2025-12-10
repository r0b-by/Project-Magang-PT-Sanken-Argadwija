<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Riwayat Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-3">

    <h3 class="mb-4"><i class="fas fa-history me-2"></i>Riwayat Dokumen</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!empty($history)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama File</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Uploader</th>
                                <th>Uploaded At</th>
                                <th>Barcode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $i => $row) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['nama_file']) ?></td>
                                    <td><?= esc($row['keterangan']) ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'revisi'): ?>
                                            <span class="badge bg-warning text-dark">Revisi</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Save</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($row['uploader_name']) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($row['uploaded_at'])) ?></td>
                                    <td><?= esc($row['barcode']) ?></td>
                                    <td>
                                        <a href="<?= site_url('iso00/view/'.$row['id']) ?>" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="<?= site_url('iso00/download/'.$row['id']) ?>" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Belum ada riwayat dokumen.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= site_url('iso00') ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

</div>
<?= $this->endSection() ?>
