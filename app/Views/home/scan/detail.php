<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 1rem 0;
        }
        
        .pdf-viewer {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            height: 80vh;
        }
        
        .pdf-viewer iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .card-header {
            background: #2c3e50;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
            padding: 1rem;
        }
        
        .btn-back {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 0.5rem 0;
            }
            
            .container {
                padding: 0 0.5rem;
            }
            
            .pdf-viewer {
                height: 70vh;
            }
            
            .card-header {
                padding: 0.75rem;
            }
            
            .btn-back {
                position: static;
                margin-bottom: 1rem;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Back Button -->
    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-sm btn-back">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>

    <!-- Document Preview -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-file-pdf me-2"></i>
                Preview Dokumen
            </h5>
        </div>
        <div class="card-body p-3">
            <?php if ($dok['nama_file'] && strtolower(pathinfo($dok['nama_file'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                <div class="pdf-viewer">
                    <iframe 
                        src="<?= base_url('scan/file/'.$dok['id']) ?>#toolbar=0&navpanes=0"
                        frameborder="0"
                        allow="fullscreen">
                    </iframe>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-file text-muted fa-3x mb-3"></i>
                    <p class="text-muted">Dokumen tidak dapat ditampilkan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>