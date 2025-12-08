<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4 px-3 px-lg-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-family: 'Poppins', 'Segoe UI', sans-serif; letter-spacing: 0.5px; font-size: 1.75rem;">
                Scan Dokumen ISO
            </h1>
            <p class="text-muted mb-0 d-flex align-items-center" style="font-family: 'Inter', sans-serif; font-size: 0.875rem;">
                <i data-feather="camera" width="14" height="14" class="me-2 opacity-75"></i>
                Scan QR/Barcode untuk membuka dokumen
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url('iso_00/list_dokumen') ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 py-2 px-3 rounded-2">
                <i data-feather="arrow-left" width="14" height="14"></i>
                <span class="d-none d-md-inline">Kembali</span>
            </a>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title fw-semibold d-flex align-items-center mb-0" 
                        style="font-family: 'Inter', sans-serif; font-size: 1rem;">
                        <i data-feather="info" width="16" height="16" class="me-2 text-primary"></i>
                        Petunjuk Scan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 36px; height: 36px;">
                                    <i data-feather="camera" width="16" height="16" class="text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="font-size: 0.9rem;">Arahkan Kamera</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                        Pastikan QR/Barcode terlihat jelas di area scanner
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 36px; height: 36px;">
                                    <i data-feather="zap" width="16" height="16" class="text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="font-size: 0.9rem;">Pencahayaan</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                        Atur pencahayaan yang cukup untuk hasil scan optimal
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 36px; height: 36px;">
                                    <i data-feather="target" width="16" height="16" class="text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="font-size: 0.9rem;">Fokus Kamera</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                        Jaga jarak optimal 15-30 cm dari QR code
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 36px; height: 36px;">
                                    <i data-feather="file-text" width="16" height="16" class="text-info"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="font-size: 0.9rem;">Hasil Scan</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                        Dokumen akan terbuka otomatis setelah scan berhasil
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title fw-semibold d-flex align-items-center mb-0" 
                        style="font-family: 'Inter', sans-serif; font-size: 1rem;">
                        <i data-feather="help-circle" width="16" height="16" class="me-2 text-primary"></i>
                        Troubleshooting
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 500;">
                            <i data-feather="alert-circle" width="12" height="12" class="me-1"></i>
                            Kamera tidak aktif?
                        </small>
                        <div class="fw-medium" style="font-size: 0.85rem;">
                            Pastikan izin kamera sudah diberikan
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 500;">
                            <i data-feather="x-circle" width="12" height="12" class="me-1"></i>
                            Scan tidak terbaca?
                        </small>
                        <div class="fw-medium" style="font-size: 0.85rem;">
                            Coba bersihkan lensa atau naikkan brightness
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 500;">
                            <i data-feather="refresh-cw" width="12" height="12" class="me-1"></i>
                            Scanner error?
                        </small>
                        <div class="fw-medium" style="font-size: 0.85rem;">
                            Refresh halaman atau coba browser lain
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-outline-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-1 py-2" 
                                onclick="restartScanner()">
                            <i data-feather="refresh-cw" width="12" height="12"></i>
                            Restart Scanner
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scanner Area -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-medium d-flex align-items-center" style="font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                <i data-feather="camera" width="14" height="14" class="me-2 text-primary"></i>
                Scanner Area
            </h5>
            <div class="d-flex align-items-center gap-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="torchToggle">
                    <label class="form-check-label" for="torchToggle" style="font-size: 0.75rem;">
                        Flash
                    </label>
                </div>
                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" onclick="toggleCamera()">
                    <i data-feather="repeat" width="12" height="12"></i>
                    <span class="d-none d-md-inline">Switch Camera</span>
                </button>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <!-- Scanner Container -->
                    <div id="scanner-container" class="position-relative">
                        <div id="reader" class="border rounded overflow-hidden bg-dark" 
                             style="min-height: 400px; max-width: 500px; margin: 0 auto;"></div>
                        
                        <!-- Scanner Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center" 
                             style="pointer-events: none;">
                            <!-- Scan Frame -->
                            <div style="width: 250px; height: 250px; border: 2px solid rgba(67, 97, 238, 0.8); 
                                        border-radius: 12px; position: relative;">
                                <!-- Corner decorations -->
                                <div style="position: absolute; top: -2px; left: -2px; width: 20px; height: 20px; 
                                            border-top: 4px solid #4361ee; border-left: 4px solid #4361ee;"></div>
                                <div style="position: absolute; top: -2px; right: -2px; width: 20px; height: 20px; 
                                            border-top: 4px solid #4361ee; border-right: 4px solid #4361ee;"></div>
                                <div style="position: absolute; bottom: -2px; left: -2px; width: 20px; height: 20px; 
                                            border-bottom: 4px solid #4361ee; border-left: 4px solid #4361ee;"></div>
                                <div style="position: absolute; bottom: -2px; right: -2px; width: 20px; height: 20px; 
                                            border-bottom: 4px solid #4361ee; border-right: 4px solid #4361ee;"></div>
                            </div>
                            
                            <!-- Scan Line Animation -->
                            <div id="scan-line" 
                                 style="width: 250px; height: 3px; background: linear-gradient(90deg, transparent, #4361ee, transparent); 
                                        position: absolute; top: 50%; transform: translateY(-50%); 
                                        animation: scan 2s ease-in-out infinite;"></div>
                            
                            <!-- Instruction Text -->
                            <div class="mt-4 text-center" style="background: rgba(0, 0, 0, 0.7); padding: 8px 16px; border-radius: 20px;">
                                <p class="text-white mb-0" style="font-size: 0.8rem; font-weight: 500;">
                                    <i data-feather="move" width="12" height="12" class="me-1"></i>
                                    Arahkan QR code ke dalam frame
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Scan Results -->
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-0 py-3">
                            <h6 class="mb-0 fw-medium d-flex align-items-center" style="font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                                <i data-feather="activity" width="14" height="14" class="me-2 text-primary"></i>
                                Scan Status
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Loading State -->
                            <div id="scan-loading" class="text-center py-4">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                    Memulai scanner...
                                </p>
                            </div>
                            
                            <!-- Results -->
                            <div id="scan-result" class="d-none">
                                <div class="text-center mb-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                        <i data-feather="check-circle" width="24" height="24" class="text-success"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-2">Scan Berhasil!</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                        QR code terdeteksi dan sedang memproses...
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1" style="font-size: 0.75rem; font-weight: 500;">
                                        Kode Terdeteksi
                                    </small>
                                    <div class="bg-light rounded p-2 border">
                                        <code id="scanned-code" class="text-primary" style="font-size: 0.8rem; word-break: break-all;"></code>
                                    </div>
                                </div>
                                
                                <div class="progress mb-3" style="height: 6px;">
                                    <div id="redirect-progress" class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 0%"></div>
                                </div>
                                
                                <div class="text-center">
                                    <p class="text-muted mb-2" style="font-size: 0.8rem;">
                                        Mengarahkan ke dokumen dalam <span id="countdown">3</span> detik
                                    </p>
                                    <button id="cancel-redirect" class="btn btn-outline-secondary btn-sm">
                                        <i data-feather="x" width="12" height="12" class="me-1"></i>
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Error State -->
                            <div id="scan-error" class="d-none text-center py-4">
                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i data-feather="alert-circle" width="24" height="24" class="text-danger"></i>
                                </div>
                                <h6 class="fw-semibold mb-2">Scanner Error</h6>
                                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                    Tidak dapat mengakses kamera
                                </p>
                                <button class="btn btn-primary btn-sm" onclick="retryCamera()">
                                    <i data-feather="refresh-cw" width="12" height="12" class="me-1"></i>
                                    Coba Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Library Scanner -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<!-- Custom CSS -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700&display=swap');

/* Card hover effects */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
}

/* Button hover effects */
.btn-outline-primary:hover {
    background-color: #4361ee;
    color: white;
    border-color: #4361ee;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
    border-color: #6c757d;
}

/* Scanner overlay */
#scanner-container {
    position: relative;
}

/* Scan animation */
@keyframes scan {
    0% {
        transform: translateY(-200px);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(200px);
        opacity: 0;
    }
}

/* Scanner video styling */
#reader video {
    width: 100% !important;
    height: auto !important;
    border-radius: 8px;
}

#reader__dashboard_section_csr {
    display: none !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    #reader {
        min-height: 300px !important;
    }
    
    /* Adjust scanner frame for mobile */
    #scanner-container .position-absolute > div:first-child {
        width: 200px !important;
        height: 200px !important;
    }
    
    #scan-line {
        width: 200px !important;
    }
    
    /* Mobile buttons */
    .btn-sm span.d-none.d-md-inline {
        display: none !important;
    }
    
    /* Stack scanner and results on mobile */
    .row .col-lg-8,
    .row .col-lg-4 {
        margin-bottom: 1.5rem;
    }
    
    .row .col-lg-4:last-child {
        margin-bottom: 0;
    }
}

/* Tablet adjustments */
@media (min-width: 769px) and (max-width: 991.98px) {
    #reader {
        min-height: 350px !important;
    }
}

/* Smooth transitions */
.btn, .card, .form-check-input {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar */
#scanned-code {
    max-height: 100px;
    overflow-y: auto;
}

#scanned-code::-webkit-scrollbar {
    width: 4px;
}

#scanned-code::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

#scanned-code::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

/* Loading spinner */
.spinner-border {
    width: 2rem;
    height: 2rem;
}

/* Progress bar animation */
.progress-bar-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

@keyframes progress-bar-stripes {
    0% { background-position: 1rem 0; }
    100% { background-position: 0 0; }
}

/* Camera toggle switch */
.form-check-input:checked {
    background-color: #4361ee;
    border-color: #4361ee;
}

/* Mobile specific improvements */
@media (max-width: 576px) {
    .card-header .d-flex.align-items-center.gap-2 {
        flex-wrap: wrap;
        gap: 0.5rem !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem;
    }
    
    h1.fw-bold {
        font-size: 1.5rem !important;
    }
}
</style>

<script>
// Disable right click
document.addEventListener("contextmenu", e => e.preventDefault());

// Initialize feather icons
if (typeof feather !== 'undefined') {
    feather.replace();
}

// Global variables
let html5QrCode;
let currentFacingMode = "environment"; // "user" for front, "environment" for back
let redirectTimer;
let countdownValue = 3;
let scannedUrl = "";
let isScanning = false;

// Initialize scanner
function initializeScanner(facingMode = "environment") {
    const readerDiv = document.getElementById('reader');
    
    // Clear previous scanner if exists
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(() => {
            startNewScanner(facingMode);
        }).catch(() => {
            startNewScanner(facingMode);
        });
    } else {
        startNewScanner(facingMode);
    }
}

function startNewScanner(facingMode) {
    html5QrCode = new Html5Qrcode("reader");
    
    // Hide loading, show scanner
    document.getElementById('scan-loading').style.display = 'none';
    
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0,
        disableFlip: false
    };

    html5QrCode.start(
        { facingMode: facingMode },
        config,
        onScanSuccess,
        onScanError
    ).then(() => {
        isScanning = true;
        console.log("Scanner started successfully with facing mode:", facingMode);
    }).catch(err => {
        console.error("Failed to start scanner:", err);
        showScannerError();
    });
}

// On scan success
function onScanSuccess(decodedText, decodedResult) {
    // Only process if not already scanning
    if (isScanning) {
        isScanning = false;
        
        // Stop scanner
        html5QrCode.stop().then(() => {
            showScanResult(decodedText);
        }).catch(() => {
            showScanResult(decodedText);
        });
    }
}

// On scan error (quiet errors)
function onScanError(errorMessage) {
    // Don't show error messages while scanning
}

// Show scan result
function showScanResult(decodedText) {
    scannedUrl = decodedText;
    
    // Show result section
    document.getElementById('scan-result').classList.remove('d-none');
    document.getElementById('scan-loading').style.display = 'none';
    document.getElementById('scan-error').classList.add('d-none');
    
    // Display scanned code
    document.getElementById('scanned-code').textContent = decodedText;
    
    // Start countdown
    startRedirectCountdown();
}

// Start redirect countdown
function startRedirectCountdown() {
    countdownValue = 3;
    document.getElementById('countdown').textContent = countdownValue;
    
    // Reset progress bar
    const progressBar = document.getElementById('redirect-progress');
    progressBar.style.width = '0%';
    
    // Update countdown every second
    redirectTimer = setInterval(() => {
        countdownValue--;
        document.getElementById('countdown').textContent = countdownValue;
        
        // Update progress bar
        const progress = ((3 - countdownValue) / 3) * 100;
        progressBar.style.width = progress + '%';
        
        // Redirect when countdown reaches 0
        if (countdownValue <= 0) {
            clearInterval(redirectTimer);
            window.location.href = scannedUrl;
        }
    }, 1000);
}

// Cancel redirect
document.getElementById('cancel-redirect').addEventListener('click', function() {
    clearInterval(redirectTimer);
    
    // Hide result section
    document.getElementById('scan-result').classList.add('d-none');
    document.getElementById('scan-loading').style.display = 'block';
    
    // Restart scanner
    setTimeout(() => {
        initializeScanner(currentFacingMode);
    }, 500);
});

// Toggle camera (front/back)
function toggleCamera() {
    currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
    initializeScanner(currentFacingMode);
    
    // Update button text
    const button = event.currentTarget;
    const icon = button.querySelector('i[data-feather]');
    const text = button.querySelector('span');
    
    if (text) {
        text.textContent = currentFacingMode === "environment" ? "Switch to Front" : "Switch to Back";
    }
    
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

// Restart scanner
function restartScanner() {
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(() => {
            setTimeout(() => {
                initializeScanner(currentFacingMode);
            }, 300);
        });
    } else {
        initializeScanner(currentFacingMode);
    }
}

// Show scanner error
function showScannerError() {
    document.getElementById('scan-loading').style.display = 'none';
    document.getElementById('scan-result').classList.add('d-none');
    document.getElementById('scan-error').classList.remove('d-none');
}

// Retry camera access
function retryCamera() {
    document.getElementById('scan-error').classList.add('d-none');
    document.getElementById('scan-loading').style.display = 'block';
    
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(() => {
            setTimeout(() => {
                initializeScanner(currentFacingMode);
            }, 500);
        })
        .catch(err => {
            showScannerError();
            console.error("Camera access denied:", err);
        });
}

// Torch/flash toggle (placeholder - requires specific browser support)
document.getElementById('torchToggle').addEventListener('change', function(e) {
    if (e.target.checked) {
        console.log("Flash enabled (if supported)");
        // Actual torch control requires specific browser APIs
    } else {
        console.log("Flash disabled");
    }
});

// Request camera permission and initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Show loading state
    document.getElementById('scan-loading').style.display = 'block';
    
    // Request camera permission
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(() => {
            // Initialize scanner after short delay
            setTimeout(() => {
                initializeScanner(currentFacingMode);
            }, 500);
        })
        .catch(err => {
            console.error("Camera access denied:", err);
            showScannerError();
        });
});

// Handle page visibility change
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Page is hidden, stop scanner to save resources
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().catch(() => {});
        }
    } else {
        // Page is visible again, restart scanner
        setTimeout(() => {
            if (!isScanning) {
                initializeScanner(currentFacingMode);
            }
        }, 300);
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().catch(() => {});
    }
    
    if (redirectTimer) {
        clearInterval(redirectTimer);
    }
});

// Responsive adjustments
function handleResize() {
    if (window.innerWidth <= 768) {
        // Adjust scanner box size for mobile
        const qrbox = document.querySelector('#reader div');
        if (qrbox) {
            qrbox.style.width = '200px';
            qrbox.style.height = '200px';
        }
    }
}

window.addEventListener('resize', handleResize);
window.addEventListener('load', handleResize);
</script>

<?= $this->endSection() ?>