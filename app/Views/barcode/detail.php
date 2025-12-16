<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
    </style>
</head>
<body oncontextmenu="return false;">
<div class="container">
    <!-- Detail Card -->
    <div class="detail-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-file-alt"></i>
                Detail Dokumen
            </h4>
        </div>
        
        <div class="card-body p-4">
            <!-- PDF Viewer Section -->
            <?php if ($dok['nama_file'] && strtolower(pathinfo($dok['nama_file'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                <div class="mt-3">
                    <div class="section-title">
                        <i class="fas fa-file-pdf"></i>
                        Preview Dokumen
                    </div>
                    <div class="pdf-viewer-container">
                        <iframe 
                            src="<?= base_url('barcode/file/'.$dok['id']) ?>#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                            frameborder="0">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>