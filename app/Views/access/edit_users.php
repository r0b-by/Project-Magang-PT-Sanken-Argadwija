<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Users Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container-fluid px-3 px-md-4 py-3">
    <h4 class="mb-3">
        Edit Users Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('access/update-users/' . $holder['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="holder_id" value="<?= esc($holder['id']) ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih User</label>
                    <?php
                        $assignedUserIds = array_column($assignedUsers ?? [], 'user_id');
                    ?>
                    <div class="row g-2">
                        <?php foreach ($users as $u): ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="user_ids[]" value="<?= esc($u['id']) ?>"
                                       <?= in_array($u['id'], $assignedUserIds) ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <?= esc($u['fullname']) ?>
                                    <small class="text-muted">(<?= esc($u['username']) ?>)</small>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('access') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
