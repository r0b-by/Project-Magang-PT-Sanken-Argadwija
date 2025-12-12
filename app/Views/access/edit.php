<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Edit Holder Akses</h3>

    <form action="<?= site_url('holders/update/'.$holder['id']) ?>" method="POST">

        <div class="mb-3">
            <label>Kode Holder</label>
            <input type="text" name="holder_code" class="form-control"
                   value="<?= esc($holder['holder_code']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Pilih User</label>
            <select name="user_id" class="form-control" required>
                <?php foreach($users as $user): ?>
                <option value="<?= $user['id'] ?>" 
                    <?= $holder['user_id'] == $user['id'] ? 'selected' : '' ?>>
                    <?= $user['name'] ?> (<?= $user['email'] ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Pilih Dokumen</label>
            <select name="document_ids[]" class="form-control" multiple required>
                <?php foreach($documents as $doc): ?>
                <option value="<?= $doc['id'] ?>"
                    <?= in_array($doc['id'], $holderDocumentIds) ? 'selected' : '' ?>>
                    <?= $doc['document_code'] ?> - <?= $doc['title'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="<?= site_url('holders') ?>" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<?= $this->endSection() ?>
