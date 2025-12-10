<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Riwayat Dokumen<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-2 px-md-3">

    <h3 class="mb-4"><i class="fas fa-history me-2"></i>Riwayat Dokumen</h3>

    <div class="card shadow-sm">
        <div class="card-body p-2 p-md-3">
            <?php if (!empty($history)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light d-none d-md-table-header-group">
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th style="width: 20%">Nama File</th>
                                <th style="width: 15%">Keterangan</th>
                                <th class="text-center" style="width: 10%">Status</th>
                                <th style="width: 15%">Uploader</th>
                                <th style="width: 15%">Uploaded At</th>
                                <th style="width: 10%">Barcode</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($history as $i => $row) : ?>
                                <tr class="vertical-align-top">
                                    <td class="text-center fw-bold d-md-none bg-light" colspan="2">
                                        <?= $i + 1 ?>. <?= esc($row['nama_file']) ?>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell"><?= $i + 1 ?></td>
                                    <td class="d-none d-md-table-cell"><?= esc($row['nama_file']) ?></td>
                                    
                                    <td class="d-md-none">
                                        <div class="row g-1">
                                            <div class="col-4 fw-bold">Keterangan:</div>
                                            <div class="col-8"><?= esc($row['keterangan']) ?></div>
                                            
                                            <div class="col-4 fw-bold">Status:</div>
                                            <div class="col-8">
                                                <?php if ($row['status'] === 'revisi'): ?>
                                                    <span class="badge bg-warning text-dark">Revisi</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Save</span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="col-4 fw-bold">Uploader:</div>
                                            <div class="col-8"><?= esc($row['uploader_name']) ?></div>
                                            
                                            <div class="col-4 fw-bold">Uploaded:</div>
                                            <div class="col-8"><?= date('d M Y H:i', strtotime($row['uploaded_at'])) ?></div>
                                            
                                            <div class="col-4 fw-bold">Barcode:</div>
                                            <div class="col-8"><?= esc($row['barcode']) ?></div>
                                        </div>
                                    </td>
                                    
                                    <td class="d-none d-md-table-cell"><?= esc($row['keterangan']) ?></td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <?php if ($row['status'] === 'revisi'): ?>
                                            <span class="badge bg-warning text-dark">Revisi</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Save</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-md-table-cell"><?= esc($row['uploader_name']) ?></td>
                                    <td class="d-none d-md-table-cell"><?= date('d M Y H:i', strtotime($row['uploaded_at'])) ?></td>
                                    <td class="d-none d-md-table-cell"><?= esc($row['barcode']) ?></td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group-vertical btn-group-sm d-md-none w-100" role="group">
                                            <a href="<?= site_url('iso00/view/'.$row['id']) ?>" class="btn btn-primary" target="_blank">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="<?= site_url('iso00/download/'.$row['id']) ?>" class="btn btn-success">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                        <div class="btn-group btn-group-sm d-none d-md-flex" role="group">
                                            <a href="<?= site_url('iso00/view/'.$row['id']) ?>" class="btn btn-primary" target="_blank" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('iso00/download/'.$row['id']) ?>" class="btn btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="d-md-none"><td colspan="1" class="p-0"></td></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">Belum ada riwayat dokumen.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="<?= site_url('iso00') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        
        <?php if (!empty($history)) : ?>
            <div class="d-none d-md-block text-muted small">
                Menampilkan <?= count($history) ?> dokumen
            </div>
        <?php endif; ?>
    </div>

</div>

<style>
    /* Custom styles for better mobile experience */
    @media (max-width: 767.98px) {
        .table > tbody > tr > td {
            border-top: 1px solid #dee2e6;
            padding: 0.75rem 0.5rem;
        }
        
        .btn-group-vertical > .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.25rem;
        }
        
        .card-body {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        h3 {
            font-size: 1.5rem;
        }
    }
</style>
<?= $this->endSection() ?>