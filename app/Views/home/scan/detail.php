<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detail Dokumen - PDF Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/home/scan/detail-pdf-viewer.css')?>">
    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    
</head>
<body>
<div class="container">
    <!-- Back Button -->
    <?php
        if (! session()->has('user_id')) {
            $backUrl = base_url('/');
        } else {
            $role = session()->get('role');

            $backUrl = match ($role) {
                'admin' => base_url('dashboard/admin'),
                'dept'  => base_url('dashboard/dept'),
                default => base_url('/'),
            };
        }
    ?>

    <a href="<?= $backUrl ?>" class="btn btn-outline-primary btn-sm btn-back-mobile">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>

    <!-- Document Preview -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-file-pdf me-2"></i>
                <span style="font-size: 14px;">Preview Dokumen</span>
            </h5>
            <span class="badge bg-light text-dark">
                <i class="fas fa-shield-alt me-1"></i>Aman
            </span>
        </div>
        <div class="card-body p-2 p-md-3">
            <div class="pdf-viewer position-relative">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted small">Memuat PDF...</p>
                    <div class="progress mt-2" style="width: 80%;">
                        <div id="pdfProgress" class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- PDF.js Container -->
                <div id="pdf-container"></div>
                
                <!-- Rotate Controls -->
                <div class="rotate-controls">
                    <button class="rotate-btn" onclick="rotateLeft()" title="Rotate Left">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button class="rotate-btn" onclick="rotateRight()" title="Rotate Right">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
                
                <!-- Fullscreen Button -->
                <button class="fullscreen-btn" onclick="toggleFullscreen()" title="Fullscreen">
                    <i class="fas fa-expand" id="fullscreenIcon"></i>
                </button>
                
                <!-- Page Counter -->
                <div class="page-counter" id="pageCounter">
                    Halaman: <span id="currentPage">1</span>/<span id="totalPages">0</span>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-between mt-3 gap-2 navigation-controls">
                <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="prevPage()" id="prevBtn">
                    <i class="fas fa-arrow-left"></i> Sebelumnya
                </button>
                <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="goToPage(1)">
                    <i class="fas fa-home"></i> Halaman 1
                </button>
                <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="nextPage()" id="nextBtn">
                    Selanjutnya <i class="fas fa-arrow-right"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary mobile-btn" onclick="showHelp()">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
            
            <!-- Page Navigation -->
            <div class="mt-2 d-flex align-items-center justify-content-center gap-2 navigation-controls">
                <small class="text-muted">Langsung ke halaman:</small>
                <div class="input-group" style="width: 120px;">
                    <input type="number" 
                           id="pageInput" 
                           class="form-control form-control-sm" 
                           min="1" 
                           value="1"
                           style="height: 30px; text-align: center;">
                    <button class="btn btn-primary btn-sm" onclick="goToInputPage()" style="height: 30px;">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            <!-- Document Info -->
            <div class="mt-3 alert alert-light small border document-info">
                <div class="row">
                    <div class="col-6">
                        <div class="text-muted">Kode:</div>
                        <div class="fw-semibold text-truncate">DOC-2025-001</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted">Status:</div>
                        <span class="badge rounded-pill bg-success">Approved</span>
                    </div>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="alert alert-info small mt-2">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Tips:</strong> Tekan tombol fullscreen untuk mode layar penuh. Gunakan rotate untuk memutar dokumen.
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('js/home/scan/detail-pdfjs-viewer.js')?>"></script>
<script>
let pdfUrl = '<?= base_url('scan/file/'.$dok['id']) ?>';
// Konfigurasi PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

document.addEventListener( 'DOMContentLoaded', function () {
    loadPDF();
    setupSecurity();
} );
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>