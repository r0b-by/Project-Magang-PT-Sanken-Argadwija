<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Edit Dokumen ISO<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Dokumen ISO
        </h1>
        <div>
            <a href="/iso00" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
            </a>
        </div>
    </div>
    
    <!-- Edit Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Form Edit Dokumen</h5>
                </div>
                <div class="card-body">
                    <form action="/iso00/update/<?= $dokumen['id'] ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <!-- Informasi Dokumen -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_dokumen" class="form-label">Kode Dokumen *</label>
                                    <input type="text" 
                                           class="form-control <?= session('errors.kode_dokumen') ? 'is-invalid' : '' ?>"
                                           id="kode_dokumen" 
                                           name="kode_dokumen"
                                           value="<?= old('kode_dokumen', $dokumen['kode_dokumen'] ?? '') ?>"
                                           required>
                                    <?php if (session('errors.kode_dokumen')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kode_dokumen') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departement" class="form-label">Departemen *</label>
                                    <input type="text" 
                                           class="form-control <?= session('errors.departement') ? 'is-invalid' : '' ?>"
                                           id="departement" 
                                           name="departement"
                                           value="<?= old('departement', $dokumen['departement'] ?? '') ?>"
                                           required>
                                    <?php if (session('errors.departement')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.departement') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- KETERANGAN (Field sesuai migrasi) -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan Dokumen</label>
                            <textarea class="form-control <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                                      id="keterangan" 
                                      name="keterangan"
                                      rows="4"
                                      placeholder="Masukkan keterangan dokumen..."><?= old('keterangan', $dokumen['keterangan'] ?? '') ?></textarea>
                            <?php if (session('errors.keterangan')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.keterangan') ?>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted">Deskripsi atau catatan tentang dokumen ini</small>
                        </div>
                        
                        <!-- Status Dokumen -->
                        <div class="mb-4">
                            <label for="status" class="form-label">Status Dokumen</label>
                            <select class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>"
                                    id="status" 
                                    name="status">
                                <option value="save" <?= (old('status', $dokumen['status'] ?? '') == 'save') ? 'selected' : '' ?>>Save</option>
                                <option value="revisi" <?= (old('status', $dokumen['status'] ?? '') == 'revisi') ? 'selected' : '' ?>>Revisi</option>
                            </select>
                            <?php if (session('errors.status')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.status') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Upload File Baru -->
                        <div class="mb-4">
                            <label for="upload_dokumen" class="form-label">File Dokumen Baru</label>
                            <small class="text-muted d-block mb-2">Upload file baru untuk mengganti file saat ini</small>
                            
                            <!-- File saat ini -->
                            <?php if (!empty($dokumen['nama_file'])): ?>
                            <div class="alert alert-info d-flex align-items-center mb-3">
                                <i class="fas fa-file-pdf text-danger me-3 fa-2x"></i>
                                <div>
                                    <strong>File saat ini:</strong> <?= $dokumen['nama_file'] ?>
                                    <br>
                                    <a href="/iso00/view/<?= $dokumen['id'] ?>" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-eye me-1"></i>Lihat file
                                    </a> | 
                                    <a href="/iso00/download/<?= $dokumen['id'] ?>" class="text-decoration-none">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <input type="file" 
                                   class="form-control <?= session('errors.upload_dokumen') ? 'is-invalid' : '' ?>"
                                   id="upload_dokumen" 
                                   name="upload_dokumen"
                                   accept=".pdf">
                            <?php if (session('errors.upload_dokumen')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.upload_dokumen') ?>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted">Hanya format PDF | Maksimal: 10MB</small>
                        </div>
                        
                        <?php if (empty($dokumen['barcode'])): ?>
                            <small class="text-danger fw-bold">
                                ⚠ Barcode belum dibuat — klik tombol "Generate" untuk membuat barcode!
                            </small>
                        <?php endif; ?>
                        <div class="mb-4">
                            <label for="barcode" class="form-label">Barcode</label>
                            <div class="input-group">
                                <input type="text" 
                                    class="form-control <?= session('errors.barcode') ? 'is-invalid' : '' ?>"
                                    id="barcode" 
                                    name="barcode"
                                    value="<?= old('barcode', $dokumen['barcode'] ?? '') ?>"
                                    placeholder="Kosongkan untuk generate otomatis">

                                <button type="button" 
                                        class="btn btn-outline-secondary" 
                                        onclick="generateBarcode()"
                                        title="Generate Barcode Otomatis">
                                    <i class="fas fa-barcode"></i> Generate
                                </button>

                                <?php if (session('errors.barcode')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.barcode') ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- PESAN BARCODE BELUM DIGENERATE -->
                            <?php if (empty($dokumen['barcode'])): ?>
                                <small class="text-danger fw-bold">
                                    ⚠ Barcode belum dibuat — dokumen belum bisa discan karyawan.
                                </small>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Kode unik untuk scanning dokumen</small>

                                <?php if (!empty($dokumen['barcode'])): ?>
                                <a href="/iso00/print-barcode/<?= $dokumen['id'] ?>" 
                                class="btn btn-sm btn-outline-info" 
                                target="_blank">
                                    <i class="fas fa-print me-1"></i> Cetak Barcode
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="/iso00" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info Dokumen -->
        <div class="col-lg-4">
            <!-- Info Uploader -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Upload</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Diupload Oleh</label>
                        <div class="d-flex align-items-center">
                            <?php if (!empty($dokumen['uploader_foto'])): ?>
                                <img src="/uploads/foto_user/<?= $dokumen['uploader_foto'] ?>" 
                                     class="rounded-circle me-2" 
                                     width="40" height="40"
                                     alt="Foto Uploader">
                            <?php endif; ?>
                            <div>
                                <div><?= $dokumen['uploader_name'] ?? 'Unknown' ?></div>
                                <small class="text-muted"><?= $dokumen['uploader_role'] ?? '' ?></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Tanggal Upload</label>
                        <p><?= date('d/m/Y H:i', strtotime($dokumen['uploaded_at'])) ?></p>
                    </div>
                    
                    <?php if (!empty($dokumen['updated_at'])): ?>
                    <div class="mb-3">
                        <label class="form-label text-muted">Terakhir Update</label>
                        <p><?= date('d/m/Y H:i', strtotime($dokumen['updated_at'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/iso00/view/<?= $dokumen['id'] ?>" 
                           class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                        <a href="/iso00/download/<?= $dokumen['id'] ?>" 
                           class="btn btn-outline-success">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>