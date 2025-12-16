<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detail Dokumen - PDF Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    
    <style>
        body {
            background: #f8f9fa;
            padding: 0.5rem 0;
            margin: 0;
            overflow-x: hidden;
            font-size: 14px;
        }
        
        .container {
            width: 100%;
            max-width: 100%;
            padding: 0 0.5rem;
        }
        
        .pdf-viewer {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            overflow: auto; /* Changed from hidden to auto */
            height: calc(100vh - 180px);
            min-height: 400px;
            max-height: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .card {
            border: none;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .card-header {
            background: #2c3e50;
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 0.75rem;
            font-size: 14px;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .btn-back-mobile {
            display: block;
            width: calc(100% - 1rem);
            margin: 0.5rem auto;
            background: white;
            border: 1px solid #dee2e6;
            padding: 0.5rem;
            font-size: 14px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-decoration: none;
            color: #495057;
        }
        
        .btn-back-mobile:hover {
            background: #f8f9fa;
            color: #212529;
        }
        
        .mobile-btn {
            padding: 10px 15px;
            font-size: 14px;
            min-height: 44px;
            font-weight: 600;
        }
        
        .mobile-notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 13px;
            z-index: 9999;
            max-width: 90%;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        /* PDF.js Container Styles */
        #pdf-container {
            width: 100%;
            padding: 15px;
        }
        
        .pdf-page-canvas {
            display: block;
            margin: 0 auto 20px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 100%;
            background: white;
        }
        
        .page-counter {
            position: fixed;
            bottom: 60px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            z-index: 100;
        }
        
        .zoom-controls {
            position: fixed;
            bottom: 100px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            z-index: 100;
        }
        
        .zoom-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
        }
        
        /* Security styles */
        * {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-user-drag: none;
        }
        
        canvas {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
                padding: 0 1rem;
            }
            .pdf-viewer {
                height: 70vh;
                max-height: 800px;
                border-radius: 10px;
            }
            .btn-back-mobile {
                width: auto;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1000;
                max-width: 150px;
            }
        }
        
        @media (orientation: landscape) {
            .pdf-viewer {
                height: calc(100vh - 150px);
                max-height: 500px;
            }
        }
        
        @media (max-width: 768px) {
            .zoom-controls {
                bottom: 80px;
                right: 10px;
            }
            
            .page-counter {
                bottom: 40px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Back Button -->
    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-sm btn-back-mobile">
        <i class="fas fa-arrow-left me-1"></i>Kembali
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
            <?php 
            // Validasi seperti kode kedua
            if (isset($dok['id']) && isset($dok['nama_file']) && 
                strtolower(pathinfo($dok['nama_file'], PATHINFO_EXTENSION)) === 'pdf'): 
            ?>
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
                    
                    <!-- Zoom Controls -->
                    <div class="zoom-controls">
                        <button class="zoom-btn" onclick="zoomIn()" title="Zoom In">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button class="zoom-btn" onclick="zoomOut()" title="Zoom Out">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </button>
                    </div>
                    
                    <!-- Page Counter -->
                    <div class="page-counter" id="pageCounter">
                        Halaman: <span id="currentPage">1</span>/<span id="totalPages">0</span>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-3 gap-2">
                    <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="prevPage()">
                        <i class="fas fa-arrow-left"></i> Sebelumnya
                    </button>
                    <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="goToPage(1)">
                        <i class="fas fa-home"></i> Halaman 1
                    </button>
                    <button class="btn btn-sm btn-outline-secondary mobile-btn flex-fill" onclick="nextPage()">
                        Selanjutnya <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary mobile-btn" onclick="showHelp()">
                        <i class="fas fa-question-circle"></i>
                    </button>
                </div>
                
                <!-- Page Navigation -->
                <div class="mt-2 d-flex align-items-center justify-content-center gap-2">
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
                <div class="mt-3 alert alert-light small border">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-muted">Kode:</div>
                            <div class="fw-semibold text-truncate">
                                DOC-<?= date('Y') ?>-<?= isset($dok['id']) ? $dok['id'] : 'N/A' ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Status:</div>
                            <?php if (isset($dok['status'])): ?>
                                <?php if ($dok['status'] == 'approved'): ?>
                                    <span class="badge rounded-pill bg-success">Approved</span>
                                <?php elseif ($dok['status'] == 'pending'): ?>
                                    <span class="badge rounded-pill bg-warning">Pending</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill bg-secondary"><?= ucfirst($dok['status']) ?></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-success">Approved</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Tips -->
                <div class="alert alert-info small mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Tips:</strong> Gunakan tombol navigasi atau scroll. Zoom dengan tombol + dan -.
                </div>
                
            <?php else: ?>
                <!-- Jika bukan PDF atau data tidak valid -->
                <div class="text-center py-5">
                    <i class="fas fa-file text-muted fa-3x mb-3"></i>
                    <p class="text-muted">Dokumen tidak dapat ditampilkan</p>
                    <?php if (!isset($dok['id'])): ?>
                        <p class="text-danger small">Data dokumen tidak ditemukan</p>
                    <?php elseif (!isset($dok['nama_file'])): ?>
                        <p class="text-danger small">Nama file tidak tersedia</p>
                    <?php else: ?>
                        <p class="text-danger small">Format file tidak didukung (harus PDF)</p>
                    <?php endif; ?>
                    <a href="<?= base_url('/') ?>" class="btn btn-primary btn-sm mt-3">
                        <i class="fas fa-home me-1"></i>Kembali ke Beranda
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Global variables for PDF.js
let pdfDoc = null;
let currentPage = 1;
let currentScale = 1.5;
let renderTask = null;
let pdfUrl = '<?= base_url('scan/file/'.$dok['id']) ?>';

// Konfigurasi PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    // Load PDF document
    loadPDF();
    
    // Setup security features
    setupSecurity();
});

function loadPDF() {
    const loadingTask = pdfjsLib.getDocument({
        url: pdfUrl,
        withCredentials: true
    });
    
    loadingTask.onProgress = function(progressData) {
        const progress = Math.round((progressData.loaded / progressData.total) * 100);
        document.getElementById('pdfProgress').style.width = progress + '%';
    };
    
    loadingTask.promise.then(function(pdf) {
        pdfDoc = pdf;
        document.getElementById('totalPages').textContent = pdf.numPages;
        hideLoading();
        renderPage(currentPage);
        
        // Preload next page
        if (pdf.numPages > 1) {
            setTimeout(() => renderPage(2), 500);
        }
    }).catch(function(error) {
        console.error('Error loading PDF:', error);
        document.getElementById('loadingOverlay').innerHTML = `
            <div class="text-center">
                <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 48px;"></i>
                <h5 class="text-danger mb-3">Gagal Memuat PDF</h5>
                <p class="text-muted small">${error.message || 'Terjadi kesalahan saat memuat PDF'}</p>
                <button onclick="retryLoadPDF()" class="btn btn-sm btn-primary mt-2">
                    <i class="fas fa-redo me-1"></i>Coba Lagi
                </button>
            </div>
        `;
    });
}

function retryLoadPDF() {
    document.getElementById('loadingOverlay').innerHTML = `
        <div class="spinner-border text-primary" style="width: 2.5rem; height: 2.5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted small">Memuat ulang PDF...</p>
    `;
    document.getElementById('pdf-container').innerHTML = '';
    loadPDF();
}

function renderPage(pageNum) {
    if (!pdfDoc) return;
    
    currentPage = pageNum;
    document.getElementById('currentPage').textContent = pageNum;
    document.getElementById('pageInput').value = pageNum;
    
    // Cancel previous render task if exists
    if (renderTask) {
        renderTask.cancel();
    }
    
    pdfDoc.getPage(pageNum).then(function(page) {
        const container = document.getElementById('pdf-container');
        let canvas = document.getElementById('pdf-canvas-' + pageNum);
        
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'pdf-canvas-' + pageNum;
            canvas.className = 'pdf-page-canvas';
            container.appendChild(canvas);
        }
        
        const viewport = page.getViewport({ scale: currentScale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        
        const context = canvas.getContext('2d');
        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };
        
        renderTask = page.render(renderContext);
        return renderTask.promise;
    }).then(function() {
        showNotification(`📄 Halaman ${pageNum} dimuat`);
        
        // Auto-scroll to current page
        const canvas = document.getElementById('pdf-canvas-' + pageNum);
        if (canvas) {
            canvas.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Preload adjacent pages
        preloadAdjacentPages(pageNum);
    }).catch(function(error) {
        if (error.name !== 'RenderingCancelled') {
            console.error('Error rendering page:', error);
            showNotification('⚠️ Gagal memuat halaman');
        }
    });
}

function preloadAdjacentPages(currentPageNum) {
    if (!pdfDoc) return;
    
    // Preload next page if exists
    if (currentPageNum < pdfDoc.numPages) {
        const nextPageNum = currentPageNum + 1;
        if (!document.getElementById('pdf-canvas-' + nextPageNum)) {
            pdfDoc.getPage(nextPageNum).then(function(page) {
                const canvas = document.createElement('canvas');
                canvas.id = 'pdf-canvas-' + nextPageNum;
                canvas.className = 'pdf-page-canvas';
                canvas.style.display = 'none';
                document.getElementById('pdf-container').appendChild(canvas);
                
                const viewport = page.getViewport({ scale: currentScale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                page.render({
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                });
            });
        }
    }
    
    // Preload previous page if exists
    if (currentPageNum > 1) {
        const prevPageNum = currentPageNum - 1;
        if (!document.getElementById('pdf-canvas-' + prevPageNum)) {
            pdfDoc.getPage(prevPageNum).then(function(page) {
                const canvas = document.createElement('canvas');
                canvas.id = 'pdf-canvas-' + prevPageNum;
                canvas.className = 'pdf-page-canvas';
                canvas.style.display = 'none';
                document.getElementById('pdf-container').appendChild(canvas);
                
                const viewport = page.getViewport({ scale: currentScale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                page.render({
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                });
            });
        }
    }
}

// Navigation functions
function prevPage() {
    if (currentPage > 1) {
        renderPage(currentPage - 1);
    } else {
        showNotification('📄 Anda di halaman pertama');
    }
}

function nextPage() {
    if (pdfDoc && currentPage < pdfDoc.numPages) {
        renderPage(currentPage + 1);
    } else {
        showNotification('📄 Anda di halaman terakhir');
    }
}

function goToPage(pageNum) {
    if (pdfDoc && pageNum >= 1 && pageNum <= pdfDoc.numPages) {
        renderPage(pageNum);
    }
}

function goToInputPage() {
    const input = document.getElementById('pageInput');
    const pageNum = parseInt(input.value);
    
    if (pdfDoc && pageNum >= 1 && pageNum <= pdfDoc.numPages) {
        renderPage(pageNum);
    } else {
        showNotification('⚠️ Nomor halaman tidak valid');
        input.value = currentPage;
    }
}

// Zoom functions
function zoomIn() {
    currentScale += 0.2;
    renderPage(currentPage);
    showNotification(`🔍 Zoom: ${currentScale.toFixed(1)}x`);
}

function zoomOut() {
    if (currentScale > 0.5) {
        currentScale -= 0.2;
        renderPage(currentPage);
        showNotification(`🔍 Zoom: ${currentScale.toFixed(1)}x`);
    } else {
        showNotification('🔍 Zoom minimum tercapai');
    }
}

function resetZoom() {
    currentScale = 1.5;
    renderPage(currentPage);
    showNotification('🔍 Zoom direset');
}

// Utility functions
function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function showNotification(message) {
    const existing = document.querySelector('.mobile-notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = 'mobile-notification';
    notification.innerHTML = message;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.remove(), 2000);
}

function showHelp() {
    alert(`📱 NAVIGASI PDF.js:
• Scroll untuk melihat halaman
• Tombol sebelumnya/selanjutnya
• Zoom dengan tombol + dan -
• Masukkan nomor halaman langsung

🔒 KEAMANAN TETAP AKTIF:
• Klik kanan diblokir
• Copy/Print diblokir
• Developer tools diblokir

⚡ PERFORMANCE:
• Halaman dipratayang
• Render optimal untuk mobile
• Scroll smooth`);
}

// Security setup
function setupSecurity() {
    // Disable Right Click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        showNotification('🔒 Klik kanan diblokir');
    });

    // Disable Shortcuts
    document.addEventListener('keydown', function(e) {
        // F12
        if (e.key === "F12") {
            e.preventDefault();
            showNotification('🔒 Developer tools diblokir');
            return false;
        }

        // Ctrl+U, Ctrl+S, Ctrl+P, Ctrl+C, Ctrl+A
        if (e.ctrlKey && ['u', 's', 'p', 'c', 'a'].includes(e.key.toLowerCase())) {
            e.preventDefault();
            showNotification('🔒 Fitur diblokir');
            return false;
        }

        // Ctrl+Shift+I / Ctrl+Shift+J (Developer Tools)
        if (e.ctrlKey && e.shiftKey && ['i', 'j'].includes(e.key.toLowerCase())) {
            e.preventDefault();
            showNotification('🔒 Developer tools diblokir');
            return false;
        }
        
        // Arrow keys for navigation
        if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
            prevPage();
            e.preventDefault();
        }
        if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
            nextPage();
            e.preventDefault();
        }
    });

    // Prevent drag
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
    });
    
    // Prevent text selection on canvas
    document.addEventListener('selectstart', function(e) {
        if (e.target.tagName === 'CANVAS') {
            e.preventDefault();
        }
    });
}

// Auto-hide loading after timeout (fallback)
setTimeout(function() {
    hideLoading();
}, 10000);

// Handle window resize
window.addEventListener('resize', function() {
    if (pdfDoc) {
        renderPage(currentPage);
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>