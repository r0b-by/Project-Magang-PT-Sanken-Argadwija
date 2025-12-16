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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>