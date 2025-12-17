<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Riwayat Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">

    <h3 class="mb-4">
        <i class="fas fa-history me-2"></i>Riwayat Revisi Dokumen
    </h3>

    <div class="card shadow-sm">
        <div class="card-body p-2 p-md-3">

            <?php if (!empty($history)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light d-none d-md-table-header-group">
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th style="width:10%">Versi</th>
                                <th style="width:20%">Nama File</th>
                                <th style="width:20%">Ruang Lingkup</th>
                                <th style="width:15%">Tujuan</th>
                                <th class="text-center" style="width:10%">Status</th>
                                <th style="width:10%">Uploader</th>
                                <th style="width:10%">Uploaded</th>
                                <th class="text-center" style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($history as $i => $row) : ?>
                            <tr>

                                <!-- MOBILE HEADER -->
                                <td class="fw-bold d-md-none bg-light" colspan="2">
                                    <?= ($i + 1) ?>. <?= esc($row['nama_file']) ?>
                                </td>

                                <!-- DESKTOP -->
                                <td class="text-center d-none d-md-table-cell"><?= $i + 1 ?></td>
                                <td class="d-none d-md-table-cell"><?= esc($row['versi']) ?></td>
                                <td class="d-none d-md-table-cell"><?= esc($row['nama_file']) ?></td>

                                <!-- MOBILE CONTENT -->
                                <td class="d-md-none">
                                    <div class="row g-1">
                                        <div class="col-4 fw-bold">Versi</div>
                                        <div class="col-8"><?= esc($row['versi']) ?></div>

                                        <div class="col-4 fw-bold">Ruang Lingkup</div>
                                        <div class="col-8"><?= esc($row['ruang_lingkup'] ?? '-') ?></div>

                                        <div class="col-4 fw-bold">Tujuan</div>
                                        <div class="col-8"><?= esc($row['tujuan'] ?? '-') ?></div>

                                        <div class="col-4 fw-bold">Status</div>
                                        <div class="col-8">
                                            <?php if ($row['status'] === 'save'): ?>
                                                <span class="badge bg-success">Save</span>
                                            <?php elseif ($row['status'] === 'non-save'): ?>
                                                <span class="badge bg-secondary">Non-Save</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Revisi</span>
                                            <?php endif ?>
                                        </div>

                                        <div class="col-4 fw-bold">Uploader</div>
                                        <div class="col-8"><?= esc($row['uploader_name']) ?></div>

                                        <div class="col-4 fw-bold">Uploaded</div>
                                        <div class="col-8">
                                            <?= !empty($row['uploaded_at']) ? date('d M Y H:i', strtotime($row['uploaded_at'])) : '-' ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- DESKTOP CONTINUE -->
                                <td class="d-none d-md-table-cell"><?= esc($row['ruang_lingkup'] ?? '-') ?></td>
                                <td class="d-none d-md-table-cell"><?= esc($row['tujuan'] ?? '-') ?></td>
                                <td class="text-center d-none d-md-table-cell">
                                    <?php if ($row['status'] === 'save'): ?>
                                        <span class="badge bg-success">Save</span>
                                    <?php elseif ($row['status'] === 'non-save'): ?>
                                        <span class="badge bg-secondary">Non-Save</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Revisi</span>
                                    <?php endif ?>
                                </td>

                                <td class="d-none d-md-table-cell"><?= esc($row['uploader_name']) ?></td>
                                <td class="d-none d-md-table-cell">
                                    <?= !empty($row['uploaded_at']) ? date('d M Y H:i', strtotime($row['uploaded_at'])) : '-' ?>
                                </td>

                                <!-- AKSI -->
                                <td class="text-center">
                                    <div class="btn-group-vertical btn-group-sm d-md-none w-100">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>" class="btn btn-primary" target="_blank">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>" class="btn btn-success">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>

                                    <div class="btn-group btn-group-sm d-none d-md-flex">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>" class="btn btn-primary" title="View" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>" class="btn btn-success" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>

                                    <?php if (session()->get('role') === 'admin'): ?>
                                        <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </a>
                                    <?php endif ?>
                                </td>

                            </tr>
                        <?php endforeach ?>

                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">Belum ada histori revisi dokumen.</p>
                </div>
            <?php endif ?>

        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="<?= site_url('iso00') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        <?php if (!empty($history)) : ?>
            <div class="d-none d-md-block text-muted small">
                Menampilkan <?= count($history) ?> revisi
            </div>
        <?php endif ?>
    </div>

</div>
<?= $this->endSection() ?>
