<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>History Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>History Dokumen
        </h1>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">#</th>
                            <th>Dokumen</th>
                            <th class="d-none d-md-table-cell">Status</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($all_history)): ?>
                            <?php $no = 1; foreach($all_history as $history): ?>
                                <tr>
                                    <td class="ps-3"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= $history['nama_file'] ?></div>
                                        <div class="text-muted small">
                                            <?= $history['uploader_name'] ?>
                                            <span class="mx-1">•</span>
                                            <?= date('d/m/y', strtotime($history['uploaded_at'])) ?>
                                        </div>
                                        <div class="text-muted small d-block d-md-none">
                                            <span class="badge bg-info"><?= $history['status'] ?></span>
                                        </div>
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        <span class="badge bg-info"><?= $history['status'] ?></span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">

                                            <!-- View file revisi -->
                                            <a href="<?= base_url('iso00/history/view/'.$history['id']) ?>" 
                                               class="btn btn-outline-primary"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Download file revisi -->
                                            <a href="<?= base_url('iso00/history/download/'.$history['id']) ?>" 
                                               class="btn btn-outline-success"
                                               title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Tidak ada history dokumen
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
<?= $this->endSection() ?>
