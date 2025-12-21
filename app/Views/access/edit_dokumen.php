<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Dokumen Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .form-check-input-lg {
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        accent-color: #0d6efd;
    }

    .form-check-label {
        font-size: 0.95rem;
        font-weight: 500;
        margin-left: .35rem;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-3 px-md-4 py-3">
    <h4 class="mb-3">
        Edit Dokumen Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('access/update-dokumen/' . $holder['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="holder_id" value="<?= esc($holder['id']) ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">
                        Pilih Dokumen (boleh lebih dari satu)
                    </label>

                    <div class="row g-2">
                        <?php 
                        // Buat array dokumen yang sudah diassign untuk holder ini
                        $assignedDocIds = [];
                        foreach ($dokumen as $d) {
                            if (!empty($d['assigned_holder_id']) && $d['assigned_holder_id'] == $holder['id']) {
                                $assignedDocIds[] = $d['id'];
                            }
                        }
                        ?>
                        
                        <?php foreach ($dokumen as $d): ?>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input form-check-input-lg"
                                        type="checkbox"
                                        name="dokumen_id[]"
                                        value="<?= esc($d['id']) ?>"
                                        <?= in_array($d['id'], $assignedDocIds) ? 'checked' : '' ?>
                                    >
                                    <label class="form-check-label">
                                        <?= esc($d['kode_dokumen']) ?>
                                        <br>
                                        <small class="text-muted">
                                            <?= esc($d['nama_dokumen_internal']) ?>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <small class="text-muted d-block mt-2">
                        * Dokumen hanya boleh dimiliki oleh satu holder
                    </small>
                </div>

                <div class="d-flex mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="<?= base_url('access/detail/' . $holder['holder_code']) ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
