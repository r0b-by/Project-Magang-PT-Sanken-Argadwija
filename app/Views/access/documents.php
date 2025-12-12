<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h3>Dokumen Anda</h3>
    <p class="text-muted">Ditampilkan sesuai hak akses holder Anda.</p>

    <?php if(count($documents) == 0): ?>
        <div class="alert alert-info">Tidak ada dokumen yang dapat Anda akses.</div>
    <?php else: ?>

        <div class="row">
            <?php foreach($documents as $doc): ?>
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5><?= esc($doc['title']) ?></h5>
                        <p class="text-muted"><?= esc($doc['document_code']) ?></p>

                        <a href="<?= base_url('uploads/'.$doc['file_path']) ?>"
                           target="_blank" class="btn btn-primary">
                            Lihat Dokumen
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
