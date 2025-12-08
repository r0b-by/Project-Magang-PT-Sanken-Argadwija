<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Dokumen ISO
        </h1>
        <div>
            <?php if (in_array(session()->get('role'), ['admin', 'dept'])): ?>
            <a href="/iso00/create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Upload Dokumen
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Documents Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Dokumen</th>
                            <th>Departemen</th>
                            <th>File</th>
                            <th>Uploader</th>
                            <th>Status</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokumen as $doc): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $doc['kode_dokumen'] ?></strong>
                                <?php if ($doc['barcode']): ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-barcode me-1"></i>
                                        <?= $doc['barcode'] ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td><?= $doc['departement'] ?></td>
                            <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <div>
                                    <div><?= $doc['nama_file'] ?></div>
                                    <small class="text-muted">
                                        <?php 
                                        // Cek file di WRITEPATH
                                        $filePath = WRITEPATH . 'uploads/' . $doc['nama_file'];
                                        if (file_exists($filePath)) {
                                            echo round(filesize($filePath) / 1024, 2) . ' KB';
                                        } else {
                                            echo 'File tidak ditemukan';
                                        }
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </td>
                           <td>
                                <div class="d-flex align-items-center">
                                    <?php if (isset($doc['foto'])): ?>
                                        <img src="/uploads/foto_user/<?= $doc['foto'] ?>" 
                                            class="profile-img me-2" 
                                            alt="Foto Uploader">
                                    <?php endif; ?>
                                    <div>
                                        <div><?= $doc['fullname'] ?? 'Unknown' ?></div>
                                        <small class="text-muted"><?= $doc['role'] ?? 'Unknown' ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-<?= 
                                    $doc['status'] == 'approved' ? 'success' : 
                                    ($doc['status'] == 'pending' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($doc['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($doc['uploaded_at'])) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Tombol View Detail -->
                                    <a href="/iso00/show/<?= $doc['id'] ?>" 
                                    class="btn btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Tombol View PDF -->
                                    <a href="/iso00/view/<?= $doc['id'] ?>" 
                                    class="btn btn-primary" target="_blank" title="Lihat PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    
                                    <!-- Tombol Download -->
                                    <a href="/iso00/download/<?= $doc['id'] ?>" 
                                    class="btn btn-success" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    
                                    <?php if (session()->get('user_id') == $doc['uploaded_by'] || session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/edit/<?= $doc['id'] ?>" 
                                    class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (session()->get('role') == 'admin'): ?>
                                    <a href="/iso00/delete/<?= $doc['id'] ?>" 
                                    class="btn btn-danger" title="Hapus"
                                    onclick="return confirm('Yakin menghapus dokumen ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>