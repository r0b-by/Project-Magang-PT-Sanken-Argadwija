<div class="scanner-wrapper">
    <div class="scanner-box">
        <div id="scanner-container"></div>
        
        <div id="permission-message" class="alert alert-info d-none mt-3 small" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            Izinkan akses kamera
        </div>
    </div>

    <div class="mt-3 text-center">
        <div id="scan-result-area" class="d-none">
            <div class="alert alert-success mb-2" role="alert">
                <i class="fas fa-barcode me-2"></i>
                <strong>Kode:</strong>
                <span id="scanned-code" class="ms-1 fw-bold"></span>
            </div>
            
            <button id="btn-process" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-right me-1"></i>Lihat Detail
            </button>
        </div>

        <div id="scan-status" class="text-muted small mt-2">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            <span>Memuat kamera...</span>
        </div>
    </div>
</div>

<style>
    #scanner-container {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 10px;
        overflow: hidden;
        background: #000;
    }

    #scanner-container video {
        width: 100% !important;
        height: auto !important;
        max-height: 60vh;
    }

    @media (max-width: 576px) {
        #scanner-container {
            max-height: 50vh;
        }
        
        #scanner-container video {
            max-height: 50vh;
        }
        
        .scanner-box {
            padding: 0 0.5rem;
        }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const scanner = new Html5Qrcode("scanner-container");
    let scannedCode = null;

    // Start scanner
    Html5Qrcode.getCameras().then(cameras => {
        if(cameras && cameras.length) {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const camera = cameras[0];
            
            document.getElementById('permission-message').classList.remove('d-none');
            
            scanner.start(
                camera.id,
                {
                    fps: 10,
                    qrbox: 250,
                    aspectRatio: 1.0,
                },
                decodedText => {
                    scannedCode = decodedText;
                    handleSuccessfulScan(decodedText);
                    scanner.stop();
                },
                () => {} // error callback
            ).then(() => {
                document.getElementById('permission-message').classList.add('d-none');
                document.getElementById('scan-status').innerHTML = 
                    '<i class="fas fa-camera me-2"></i>Arahkan ke QR Code';
            });
        } else {
            document.getElementById('scan-status').innerHTML = 
                '<i class="fas fa-times-circle text-danger me-2"></i>Kamera tidak tersedia';
        }
    });

    function handleSuccessfulScan(code) {
        // Vibrate on mobile
        if (navigator.vibrate) navigator.vibrate(100);
        
        document.getElementById('scan-status').innerHTML = 
            '<i class="fas fa-check-circle text-success me-2"></i>Scan berhasil';
        
        document.getElementById('scan-result-area').classList.remove('d-none');
        document.getElementById('scanned-code').textContent = code;
    }

    document.getElementById('btn-process').addEventListener('click', function() {
        if(scannedCode) {
            window.location.href = scannedCode;
        }
    });
});
</script>