<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h3>Tambah Hak Akses Dokumen</h3>
    <hr>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Kolom 1: Dropdown User -->
        <div class="col-md-3">
            <label for="userSelect">Pilih User:</label>
            <select id="userSelect" class="form-control">
                <option value="">-- Pilih User --</option>
                <?php foreach($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= esc($user['fullname']) ?> (<?= esc($user['username']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Kolom 2: Tabel Dokumen -->
        <div class="col-md-6">
            <form action="/access/store" method="POST" id="accessForm">
                <table class="table table-bordered table-striped mt-3 mt-md-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Dokumen</th>
                            <th>Nama Dokumen</th>
                            <th>Status Akses</th>
                            <th>Holder Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dokumen as $i => $doc): ?>
                            <?php
                            // cek akses user default (kosong saat load)
                            $holders = [];
                            foreach($access as $acc){
                                if($acc->dokumen_id == $doc['id']){
                                    $holders[$acc->user_id] = $acc->holder_code;
                                }
                            }
                            ?>
                            <tr data-dokumen-id="<?= $doc['id'] ?>">
                                <td><?= $i+1 ?></td>
                                <td><?= esc($doc['kode_dokumen']) ?></td>
                                <td><?= esc($doc['nama_dokumen_internal']) ?></td>
                                <td class="statusAkses">-</td>
                                <td>
                                    <input type="text" name="holder_code[]" class="form-control holderInput" placeholder="cth: 1A">
                                    <input type="hidden" name="dokumen_id[]" class="dokumenInput" value="<?= $doc['id'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <input type="hidden" name="user_id[]" id="hiddenUserId">
                <button type="submit" class="btn btn-primary mt-2">Simpan Akses</button>
            </form>
        </div>
    </div>
</div>

<script>
const userSelect = document.getElementById('userSelect');
const hiddenUserId = document.getElementById('hiddenUserId');
const accessData = <?= json_encode($access) ?>; // semua akses existing

function updateDokumenStatus() {
    const selectedUser = userSelect.value;
    hiddenUserId.value = selectedUser;

    document.querySelectorAll('tbody tr').forEach(row => {
        const dokumenId = row.dataset.dokumenId;
        const statusCell = row.querySelector('.statusAkses');
        const holderInput = row.querySelector('.holderInput');

        let holder = '';
        accessData.forEach(acc => {
            if(acc.dokumen_id == dokumenId && acc.user_id == selectedUser){
                holder = acc.holder_code;
            }
        });

        if(holder){
            statusCell.textContent = "Sudah punya: " + holder;
            holderInput.value = holder;
            holderInput.disabled = true;
        } else {
            statusCell.textContent = "Belum punya";
            holderInput.value = "";
            holderInput.disabled = false;
        }
    });
}

userSelect.addEventListener('change', updateDokumenStatus);
</script>

<?= $this->endSection(); ?>
