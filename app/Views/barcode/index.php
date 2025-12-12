<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Style untuk link tidak bisa diklik */
    .disabled-qrcode,
    .disabled-link {
        pointer-events: none;
        cursor: default;
        color: gray;
        text-decoration: none;
    }
</style>

<div class="container mt-4">

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <h3>Generate QR Code Dokumen</h3>
    <hr>

    <!-- ================================ -->
    <!-- FORM GENERATE MASSAL -->
    <!-- ================================ -->
    <form action="/barcode/generate-bulk" method="post">
        <h5>📄 Dokumen Belum Memiliki QR Code</h5>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggle(this)"></th>
                    <th>Kode Dokumen</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($belumBarcode as $dok): ?>
                <tr>
                    <td><input type="checkbox" name="dokumen[]" value="<?= $dok['id'] ?>"></td>
                    <td><?= $dok['kode_dokumen'] ?></td>
                    <td><?= $dok['nama_file'] ?></td>
                    <td>
                        <a href="/barcode/generate/<?= $dok['id'] ?>" class="btn btn-primary btn-sm">Generate</a>
                        <a href="/scan/detail/<?= $dok['id'] ?>" class="btn btn-secondary btn-sm">Cek Data</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn btn-success mt-2">Generate QR Code Massal</button>
    </form>

    <hr>

    <!-- ================================ -->
    <!-- DOKUMEN SUDAH QR -->
    <!-- ================================ -->
    <h5>📦 Dokumen Sudah Memiliki QR Code</h5>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Kode</th>
                <th>QR Code</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($sudahBarcode as $dok): ?>
            <tr>
                <td><?= $dok['kode_dokumen'] ?></td>
                <td>
                    <?php if (!empty($dok['barcodeBase64'])): ?>
                        <a class="disabled-qrcode">
                            <img src="data:image/png;base64,<?= $dok['barcodeBase64'] ?>" alt="QR Code" height="80">
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="text-muted disabled-link"><?= $dok['barcode'] ?></a>
                </td>
                <td>
                    <a href="/barcode/print/<?= $dok['id'] ?>" target="_blank" class="btn btn-success btn-sm">
                        Download PNG
                    </a>
                    <a href="/barcode/delete/<?= $dok['id'] ?>" 
                       onclick="return confirm('Hapus QR Code ini?')"
                       class="btn btn-danger btn-sm">
                       Hapus
                   </a>
                    <a href="/scan/detail/<?= $dok['id'] ?>" class="btn btn-info btn-sm">Cek Data</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
function toggle(source){
    let checkboxes = document.getElementsByName('dokumen[]');
    checkboxes.forEach(cb => cb.checked = source.checked);
}
</script>

<?= $this->endSection() ?>
