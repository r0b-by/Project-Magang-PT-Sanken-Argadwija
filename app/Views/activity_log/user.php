<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Activity Log User</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Activity</th>
        <th>IP Address</th>
        <th>Waktu</th>
    </tr>

    <?php $no = 1; foreach ($logs as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['activity'] ?></td>
        <td><?= $row['ip_address'] ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>