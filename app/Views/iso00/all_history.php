<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>History Revisi Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>History Revisi Dokumen
        </h1>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">#</th>
                            <th>Dokumen</th>
                            <th class="d-none d-md-table-cell text-center">Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($all_history)) : ?>
                        <?php $no = 1; foreach ($all_history as $row) : ?>
                            <tr>
                                <td class="ps-3"><?= $no++ ?></td>

                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($row['kode_dokumen']) ?>
                                        <span class="text-muted">–</span>
                                        <?= esc($row['nama_file']) ?>
                                    </div>

                                    <div class="text-muted small">
                                        Versi <?= esc($row['versi'] ?? '-') ?>
                                        <span class="mx-1">•</span>
                                        <?= esc($row['uploader_name'] ?? 'Unknown') ?>
                                        <span class="mx-1">•</span>
                                        <?= !empty($row['uploaded_at']) ? date('d M Y', strtotime($row['uploaded_at'])) : '-' ?>
                                    </div>

                                    <?php if (!empty($row['ruang_lingkup']) || !empty($row['tujuan'])) : ?>
                                        <div class="small text-muted mt-1">
                                            <?php if (!empty($row['ruang_lingkup'])) : ?>
                                                <div><strong>Lingkup:</strong> <?= esc($row['ruang_lingkup']) ?></div>
                                            <?php endif ?>
                                            <?php if (!empty($row['tujuan'])) : ?>
                                                <div><strong>Tujuan:</strong> <?= esc($row['tujuan']) ?></div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>

                                    <!-- Mobile Status -->
                                    <div class="d-block d-md-none mt-1">
                                        <?php if ($row['status'] === 'save'): ?>
                                            <span class="badge bg-success">Save</span>
                                        <?php elseif ($row['status'] === 'non-save'): ?>
                                            <span class="badge bg-secondary">Non-Save</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Revisi</span>
                                        <?php endif ?>
                                    </div>
                                </td>

                                <!-- Desktop Status -->
                                <td class="d-none d-md-table-cell text-center">
                                    <?php if ($row['status'] === 'save'): ?>
                                        <span class="badge bg-success">Save</span>
                                    <?php elseif ($row['status'] === 'non-save'): ?>
                                        <span class="badge bg-secondary">Non-Save</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Revisi</span>
                                    <?php endif ?>
                                </td>

                                <!-- Action -->
                                <td class="text-center">

                                    <!-- DESKTOP -->
                                    <div class="btn-group btn-group-sm d-none d-md-inline-flex">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>"
                                           class="btn btn-outline-primary"
                                           title="View" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>"
                                           class="btn btn-outline-success"
                                           title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <?php if (session()->get('role') === 'admin'): ?>
                                            <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                               class="btn btn-outline-danger"
                                               title="Delete"
                                               onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif ?>
                                    </div>

                                    <!-- MOBILE -->
                                    <div class="btn-group-vertical btn-group-sm d-md-none w-100">
                                        <a href="<?= site_url('iso00/history/view/'.$row['id']) ?>"
                                           class="btn btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="<?= site_url('iso00/history/download/'.$row['id']) ?>"
                                           class="btn btn-outline-success">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>

                                        <?php if (session()->get('role') === 'admin'): ?>
                                            <a href="<?= site_url('iso00/history/delete/'.$row['id']) ?>"
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Yakin ingin menghapus history revisi ini?')">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </a>
                                        <?php endif ?>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Tidak ada history revisi dokumen
                            </td>
                        </tr>
                    <?php endif ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
