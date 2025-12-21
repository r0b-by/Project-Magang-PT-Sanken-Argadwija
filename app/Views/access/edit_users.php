<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?>Edit Users Holder<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .form-check-input-lg {
        width: 1.6rem;
        height: 1.6rem;
        cursor: pointer;
        accent-color: #0d6efd;
    }

    .form-check-label {
        font-size: 1rem;
        font-weight: 500;
        margin-left: 0.4rem;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-3 px-md-4 py-3">
    <h4 class="mb-3">
        Edit Users Holder: <strong><?= esc($holder['holder_code']) ?></strong>
    </h4>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('access/update-users/' . $holder['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Pilih Users</label>

                    <div class="row g-2">
                        <?php 
                        $assignedIds = array_column($assignedUsers, 'user_id'); 
                        ?>
                        <?php foreach ($users as $u): ?>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input form-check-input-lg"
                                        type="checkbox"
                                        name="user_ids[]"
                                        value="<?= esc($u['id']) ?>"
                                        <?= in_array($u['id'], $assignedIds) ? 'checked' : '' ?>
                                    >
                                    <label class="form-check-label">
                                        <?= esc($u['fullname']) ?>
                                        <small class="text-muted">(<?= esc($u['role']) ?>)</small>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <small class="text-muted d-block mt-2">
                        * Pilih satu atau lebih user untuk holder ini
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
