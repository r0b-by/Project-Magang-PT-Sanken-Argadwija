<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Daftar Hak Akses Dokumen</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <a href="/access/create" class="btn btn-primary mb-3">+ Tambah Hak Akses</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Kode Dokumen</th>
                <th>Nama Dokumen</th>
                <th>Holder Codes</th>
                <th>Users</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Kelompokkan akses berdasarkan dokumen
            $grouped = [];
            foreach ($akses as $row) {
                $grouped[$row->dokumen_id][] = $row;
            }
            ?>

            <?php foreach ($grouped as $dokumenId => $rows): ?>
                <?php $first = $rows[0]; ?>
                <tr>
                    <td><?= esc($first->kode_dokumen) ?></td>
                    <td><?= esc($first->nama_dokumen_internal) ?></td>

                    <!-- Holder Codes -->
                    <td>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($rows as $r): ?>
                                <li><?= esc($r->holder_code) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>

                    <!-- Users -->
                    <td>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($rows as $r): ?>
                                <li><?= esc($r->fullname) ?>
                                    <a href="/access/delete/<?= $r->id ?>" 
                                       class="text-danger ms-1"
                                       onclick="return confirm('Hapus akses ini?')">
                                        (Hapus)
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>

                    <td>
                        <a href="/access/edit/<?= $first->dokumen_id ?>" class="btn btn-warning btn-sm">
                            Edit Dokumen
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
