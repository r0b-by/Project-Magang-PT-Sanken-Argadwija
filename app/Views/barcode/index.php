<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <h3>Generate QR Code Dokumen</h3>
    <hr>

    <!-- Form Generate Massal -->
    <form action="/barcode/generate-bulk" method="post">
        <h5>📄 Dokumen Belum Memiliki QR Code</h5>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggle(this)"></th>
                    <th>Kode Dokumen</th>
                    <th>Departement</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($belumBarcode as $dok): ?>
                <tr>
                    <td><input type="checkbox" name="dokumen[]" value="<?= $dok['id'] ?>"></td>
                    <td><?= $dok['kode_dokumen'] ?></td>
                    <td><?= $dok['departement'] ?></td>
                    <td><?= $dok['nama_file'] ?></td>
                    <td>
                        <a href="/barcode/generate/<?= $dok['id'] ?>" class="btn btn-primary btn-sm">Generate</a>
                        <a href="/scan/detail/<?= $dok['id'] ?>" class="btn btn-secondary btn-sm">Cek Data</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <button class="btn btn-success mt-2">Generate QR Code Massal</button>
    </form>

    <hr>

    <!-- Dokumen Sudah QR Code -->
    <h5>📦 Dokumen Sudah Memiliki QR Code</h5>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Departement</th>
                <th>QR Code</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($sudahBarcode as $dok): ?>
            <tr>
                <td><?= $dok['kode_dokumen'] ?></td>
                <td><?= $dok['departement'] ?></td>
                <td>
                    <style>
                        .disabled-qrcode {
                            pointer-events: none;
                            cursor: default; /* Changes the cursor from a hand icon to a default arrow */
                            color: gray;    /* Optional: styles the link to look disabled */
                            text-decoration: none; /* Optional: removes the underline */
                        }
                    </style>
                    <?php if (!empty($dok['barcodeBase64'])): ?>
                        <a class="disabled-qrcode" href="/barcode/detail/<?= $dok['id'] ?>">
                            <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" alt="QR Code" height="80">
                        </a>
                    <?php endif ?>
                </td>s
                <td>
                    <style>
                        .disabled-link {
                            pointer-events: none;
                            cursor: default; /* Changes the cursor from a hand icon to a default arrow */
                            color: gray;    /* Optional: styles the link to look disabled */
                            text-decoration: none; /* Optional: removes the underline */
                        }
                    </style>
                    <a class="text-muted disabled-link" href="/scan/detail/<?= $dok['id'] ?>"><?= $dok['barcode'] ?></a>
                </td>
                <td>
                    <a href="/barcode/print/<?= $dok['id'] ?>" target="_blank" class="btn btn-success btn-sm">Download PNG</a>
                    <a href="/barcode/delete/<?= $dok['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus QR Code ini?')">Hapus</a>
                    <a href="/scan/detail/<?= $dok['id'] ?>" class="btn btn-info btn-sm">Cek Data</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

<script>
function toggle(source){
    let checkboxes = document.getElementsByName('dokumen[]');
    for (let i = 0; i < checkboxes.length; i++){
        checkboxes[i].checked = source.checked;
    }
}
</script>

<?= $this->endSection() ?>
