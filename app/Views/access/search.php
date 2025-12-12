<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h3>Hasil Pencarian Akses Dokumen</h3>

<?php if (!empty($result)) : ?>
    <ul>
        <?php foreach($result as $row): ?>
            <li>
                <?= $row['holder_code'] ?> - 
                <?= $row['doc_name'] ?> 
                (User: <?= $row['user_name'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Tidak ada hasil ditemukan.</p>
<?php endif; ?>
<?= $this->endSection() ?>