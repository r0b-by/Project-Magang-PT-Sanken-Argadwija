<?php if (empty($documents)): ?>
<tr>
    <td colspan="12" class="text-center py-4 text-muted">
        <i class="fas fa-search me-2"></i>
        Tidak ada dokumen ditemukan
    </td>
</tr>
<?php return; endif; ?>

<?php $no = 1; foreach ($documents as $doc): ?>
<tr class="table-row">

    <!-- No -->
    <td class="text-center py-3" style="color:#64748B;border:1px solid #E2E8F0;">
        <?= $no++ ?>
    </td>

    <!-- No Dok -->
    <td class="py-3" style="border:1px solid #E2E8F0;">
        <div class="fw-semibold" style="color:#0F172A;">
            <?= esc($doc['kode_dokumen']) ?>
        </div>
    </td>

    <!-- File -->
    <td class="d-none d-lg-table-cell py-3" style="border:1px solid #E2E8F0;">
        <div class="d-flex align-items-center">
            <i class="fas fa-file-pdf me-2 text-danger"></i>
            <div>
                <div class="text-truncate" style="max-width:180px;color:#0F172A;"
                     title="<?= esc($doc['nama_file']) ?>">
                    <?= esc($doc['nama_file']) ?>
                </div>
            </div>
        </div>
    </td>

    <!-- Barcode -->
    <td class="py-3 text-center" style="border:1px solid #E2E8F0;">
        <?php if (!empty($doc['barcode'])): ?>
            <img src="<?= base_url('assets/images/barcode-status/barcode-ready.png') ?>" width="50">
        <?php else: ?>
            <img src="<?= base_url('assets/images/barcode-status/barcode-not-ready.png') ?>" width="50">
        <?php endif; ?>
    </td>

    <!-- Status -->
    <td class="d-none d-md-table-cell py-3" style="border: 1px solid #E2E8F0;">
    <?php
        if ($doc['status'] === 'approved') {
            $badgeColor = '#059669'; // Hijau lebih lembut
            $textColor = '#FFFFFF';
            $statusText = 'Approved';
        } elseif ($doc['status'] === 'save' || $doc['status'] === 'revisi') {
            $badgeColor = '#2563EB'; // Biru lebih cerah
            $textColor = '#FFFFFF';
            $statusText = 'save';
        } else { // unsave
            $badgeColor = '#6B7280'; // Abu-abu netral
            $textColor = '#FFFFFF';
            $statusText = 'unsaved';
        }
    ?>
    <span class="badge rounded-pill px-2 py-1" style="background: <?= $badgeColor ?>; color: <?= $textColor ?>; font-size: 12px; font-weight: 500;">
        <?= $statusText ?>
    </span>
    </td>

    <!-- Kolom Revisi -->
    <td class="d-none d-md-table-cell py-3" style="border: 1px solid #E2E8F0;">
    <?php
        if ($doc['status'] === 'unsave') {
            $badgeColor = '#DC2626'; // Merah lebih lembut
            $textColor = '#FFFFFF';
            $statusText = 'belum disimpan';
        } elseif ($doc['status'] === 'save') {
            $badgeColor = '#F59E0B'; // Oranye/kuning
            $textColor = '#1F2937'; // Teks gelap untuk kontras
            $statusText = 'menunggu revisi';
        } elseif ($doc['status'] === 'revisi' && isset($doc['revision_no'])) {
            $badgeColor = '#D97706'; // Oranye lebih gelap
            $textColor = '#FFFFFF';
            $statusText = 'revisi - ' . $doc['revision_no'];
        } else { // approved
            $badgeColor = '#059669'; // Hijau konsisten
            $textColor = '#FFFFFF';
            $statusText = 'Disetujui';
        }
    ?>
    <span class="badge rounded-pill px-2 py-1" style="background: <?= $badgeColor ?>; color: <?= $textColor ?>; font-size: 12px; font-weight: 500;">
        <?= $statusText ?>
    </span>
    </td>

    <!-- Holder -->
    <td class="d-none d-lg-table-cell text-center py-3" style="border:1px solid #E2E8F0;">
        <?php if (!empty($doc['holder_code'])): ?>
            <span class="badge rounded-pill px-3 py-1"
                  style="background:#E0E7FF;color:#1E40AF;font-weight:600;">
                <?= esc($doc['holder_code']) ?>
            </span>
        <?php else: ?>
            <span class="text-muted">—</span>
        <?php endif; ?>
    </td>

    <!-- Uploader -->
    <td class="d-none d-lg-table-cell py-3" style="border:1px solid #E2E8F0;">
        <?= esc($doc['uploader_name'] ?? '-') ?>
    </td>

    <!-- Uploaded -->
    <td class="d-none d-lg-table-cell py-3" style="border:1px solid #E2E8F0;">
        <?php if (!empty($doc['uploaded_at'])): ?>
            <div class="fw-semibold"><?= date('d/m/Y', strtotime($doc['uploaded_at'])) ?></div>
            <small class="text-muted"><?= date('H:i', strtotime($doc['uploaded_at'])) ?></small>
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>

    <!-- Updated By -->
    <td class="d-none d-lg-table-cell py-3" style="border:1px solid #E2E8F0;">
        <?= esc($doc['updater_name'] ?? '-') ?>
    </td>

    <!-- Updated -->
    <td class="d-none d-lg-table-cell py-3" style="border:1px solid #E2E8F0;">
        <?php if (!empty($doc['updated_at'])): ?>
            <div class="fw-semibold"><?= date('d/m/Y', strtotime($doc['updated_at'])) ?></div>
            <small class="text-muted"><?= date('H:i', strtotime($doc['updated_at'])) ?></small>
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>

    <!-- Aksi -->
    <td class="text-center py-3" style="border:1px solid #E2E8F0;">
        <div class="btn-group btn-group-sm">

            <a href="/iso00/show/<?= $doc['id'] ?>"
               class="btn"
               style="background:#E0E7FF;border:1px solid #C7D2FE;color:#1E40AF;"
               title="Detail">
                <i class="fas fa-eye"></i>
            </a>

            <?php if (session()->get('role') === 'admin'): ?>
                <a href="/iso00/view/<?= $doc['id'] ?>"
                   target="_blank"
                   class="btn"
                   style="background:#FEE2E2;border:1px solid #FECACA;color:#991B1B;"
                   title="PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
            <?php endif; ?>

            <?php if (
                session()->get('user_id') == $doc['uploaded_by'] ||
                session()->get('role') === 'admin'
            ): ?>
                <?php if (($doc['status'] ?? 'unsave') === 'unsave'): ?>
                    <span class="btn disabled"
                          style="background:#F1F5F9;border:1px solid #CBD5E1;color:#94A3B8;">
                        <i class="fas fa-lock"></i>
                    </span>
                <?php else: ?>
                    <a href="/iso00/edit/<?= $doc['id'] ?>"
                       class="btn"
                       style="background:#FEF3C7;border:1px solid #FDE68A;color:#92400E;"
                       title="Edit">
                        <i class="fas fa-pen"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </td>

</tr>
<?php endforeach; ?>
