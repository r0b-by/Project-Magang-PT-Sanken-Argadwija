<?php if(!isset($inline)) $inline = false; ?>

<div class="scanner-wrapper">
    <div class="scanner-box position-relative">
        <div id="scanner-container"></div>
        
        <!-- Overlay Success Indicator -->
        <div id="scan-success-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-none">
            <div class="d-flex align-items-center justify-content-center h-100 success-backdrop">
                <div class="text-center text-white">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h4 class="mt-3 fw-bold success-text">Scan Berhasil!</h4>
                </div>
            </div>
        </div>

        <!-- Permission Message -->
        <div id="permission-message" class="alert alert-info d-none mt-3" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <span>Izinkan akses kamera untuk mulai scanning</span>
        </div>
    </div>

    <!-- Result Display -->
    <div class="mt-4 text-center">
        <div id="scan-result-area" class="d-none">
            <div class="alert alert-success d-flex align-items-center justify-content-center flex-wrap" role="alert">
                <i class="fas fa-barcode me-2 fs-5"></i>
                <div>
                    <strong>Kode Terdeteksi:</strong>
                    <span id="scanned-code" class="ms-2 fw-bold text-break"></span>
                </div>
            </div>
            
            <button id="btn-process" class="btn btn-custom-primary btn-lg w-100" style="display: none; max-width: 400px;">
                <i class="fas fa-arrow-right me-2"></i>Lihat Detail Dokumen
            </button>
        </div>

        <div id="scan-status" class="text-muted mt-3">
            <div class="spinner-border spinner-border-sm me-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span>Memuat kamera...</span>
        </div>
    </div>
</div>

<style>
    /* Scanner Container Responsive */
    #scanner-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        background: #000;
        position: relative;
    }

    /* Responsive aspect ratio */
    #scanner-container video {
        width: 100% !important;
        height: auto !important;
        max-height: 70vh;
        object-fit: cover;
        border-radius: 15px;
    }

    .scanner-box {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 15px;
    }

    #scan-success-overlay {
        border-radius: 15px;
        z-index: 10;
    }

    .success-backdrop {
        background: rgba(6, 214, 160, 0.95);
        border-radius: 15px;
        backdrop-filter: blur(5px);
    }

    .success-icon {
        font-size: 5rem;
        animation: scaleIn 0.5s ease;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
    }

    .success-text {
        animation: fadeInUp 0.6s ease 0.2s both;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0) rotate(-180deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.2) rotate(10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #btn-process {
        animation: fadeInUp 0.5s ease;
    }

    /* Mobile Optimization */
    @media (max-width: 576px) {
        .scanner-box {
            padding: 0 10px;
        }

        #scanner-container {
            border-radius: 12px;
            max-width: 100%;
        }

        #scanner-container video {
            max-height: 60vh;
            border-radius: 12px;
        }

        .success-icon {
            font-size: 4rem;
        }

        .success-text {
            font-size: 1.25rem;
        }

        #btn-process {
            font-size: 1rem;
            padding: 0.65rem 1.5rem;
        }

        .alert {
            font-size: 0.9rem;
        }
    }

    /* Landscape mode for mobile */
    @media (max-width: 896px) and (orientation: landscape) {
        #scanner-container video {
            max-height: 85vh;
        }
    }

    /* QR Box overlay styling */
    #scanner-container canvas {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }

    /* Custom button styles */
    .btn-custom-primary {
        background: linear-gradient(135deg, #4361ee, #3f37c9);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        color: white;
    }

    .btn-custom-primary:active {
        transform: translateY(0);
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const scanner = new Html5Qrcode("scanner-container");
    let scannedCode = null;
    let scannerRunning = true;

    // Detect if mobile device
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    // Get optimal camera (rear camera for mobile)
    function getOptimalCamera(cameras) {
        if (!cameras || cameras.length === 0) return null;
        
        // For mobile, prefer rear camera (environment facing)
        if (isMobile && cameras.length > 1) {
            const rearCamera = cameras.find(camera => 
                camera.label.toLowerCase().includes('back') || 
                camera.label.toLowerCase().includes('rear') ||
                camera.label.toLowerCase().includes('environment')
            );
            return rearCamera || cameras[cameras.length - 1];
        }
        
        // For desktop, use first available camera
        return cameras[0];
    }

    // Calculate responsive QR box size
    function getQrBoxSize() {
        const containerWidth = document.getElementById('scanner-container').offsetWidth;
        const windowHeight = window.innerHeight;
        
        // Base size on smaller dimension
        let qrBoxSize = Math.min(containerWidth * 0.7, windowHeight * 0.4, 300);
        
        // Adjust for mobile
        if (isMobile) {
            qrBoxSize = Math.min(containerWidth * 0.8, 250);
        }
        
        return Math.floor(qrBoxSize);
    }

    // Start scanner
    Html5Qrcode.getCameras().then(cameras => {
        if(cameras && cameras.length) {
            const camera = getOptimalCamera(cameras);
            const qrBoxSize = getQrBoxSize();
            
            // Show permission message
            document.getElementById('permission-message').classList.remove('d-none');
            
            // Configure scanner with responsive settings
            const config = {
                fps: 10,
                qrbox: qrBoxSize,
                aspectRatio: isMobile ? 1.0 : 1.333333, // 4:3 for desktop, 1:1 for mobile
                disableFlip: false,
                videoConstraints: {
                    facingMode: isMobile ? { ideal: "environment" } : "user",
                    width: { ideal: isMobile ? 1280 : 1920 },
                    height: { ideal: isMobile ? 1280 : 1080 }
                }
            };

            scanner.start(
                camera.id,
                config,
                decodedText => {
                    if(scannerRunning) {
                        scannedCode = decodedText;
                        handleSuccessfulScan(decodedText);
                        scannerRunning = false;
                        scanner.stop().catch(err => console.error('Stop error:', err));
                    }
                },
                errorMessage => {
                    // Suppress console warnings for scanning errors
                }
            ).then(() => {
                // Camera started successfully
                document.getElementById('permission-message').classList.add('d-none');
                document.getElementById('scan-status').innerHTML = '<i class="fas fa-camera me-2"></i>Arahkan kamera ke QR Code';
            }).catch(err => {
                console.error('Start error:', err);
                document.getElementById('scan-status').innerHTML = 
                    '<i class="fas fa-exclamation-triangle text-danger me-2"></i>Gagal memulai kamera';
            });
        } else {
            alert("Kamera tidak ditemukan! Pastikan perangkat memiliki kamera.");
            document.getElementById('scan-status').innerHTML = 
                '<i class="fas fa-times-circle text-danger me-2"></i>Kamera tidak tersedia';
        }
    }).catch(err => {
        console.error(err);
        alert("Gagal mengakses kamera. Pastikan browser memiliki izin akses kamera.");
        document.getElementById('scan-status').innerHTML = 
            '<i class="fas fa-times-circle text-danger me-2"></i>Gagal mengakses kamera';
    });

    function handleSuccessfulScan(code) {
        // Vibrate on mobile if supported
        if (navigator.vibrate) {
            navigator.vibrate(200);
        }

        // Show success overlay
        document.getElementById('scan-success-overlay').classList.remove('d-none');
        document.getElementById('scan-status').innerHTML = 
            '<i class="fas fa-check-circle text-success me-2"></i>Scan berhasil!';
        
        // Hide overlay after 1.5 seconds and show result
        setTimeout(() => {
            document.getElementById('scan-success-overlay').classList.add('d-none');
            document.getElementById('scan-result-area').classList.remove('d-none');
            document.getElementById('scanned-code').textContent = code;
            document.getElementById('btn-process').style.display = 'inline-block';
        }, 1500);
    }

    // Handle process button click
    document.getElementById('btn-process').addEventListener('click', function() {
        if(scannedCode) {
            // Redirect to search endpoint
             window.location.href = scannedCode; // langsung menuju URL hasil scan
        }
    });

    // Handle window resize for responsive QR box
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (scannerRunning && scanner.getState() === Html5QrcodeScannerState.SCANNING) {
                // Restart scanner with new dimensions
                scanner.stop().then(() => {
                    location.reload(); // Simple approach: reload page
                }).catch(err => console.error('Resize error:', err));
            }
        }, 500);
    });
});
</script>