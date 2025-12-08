<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Home - Sistem Scan Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #06d6a0;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0;
            margin: 0;
        }
        .container {
            padding: 0 15px;
        }
        /* Hero Section */
        .hero-section {
            background: var(--bg-gradient);
            color: white;
            padding: 3rem 1.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        .hero-section h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .hero-section h1 i {
            font-size: 2.25rem;
        }
        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.95;
            line-height: 1.6;
        }
        /* Scanner Card */
        .scanner-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            border: none;
        }
        .scanner-card h3 {
            font-size: 1.5rem;
        }
        .scanner-card p {
            font-size: 1rem;
        }
        /* Button */
        .btn-custom-primary {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-custom-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
            color: white;
        }
        /* Feature Cards */
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }
        .feature-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .feature-card h5 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #212529;
        }
        .feature-card p {
            font-size: 0.95rem;
            line-height: 1.6;
        }
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 0;
            }
            .container {
                padding: 0 10px;
            }
            .mt-5 {
                margin-top: 1.5rem !important;
            }
            .mb-5 {
                margin-bottom: 1.5rem !important;
            }
            /* Hero Section Mobile */
            .hero-section {
                padding: 2rem 1.25rem;
                margin-bottom: 1.5rem;
                border-radius: 15px;
            }
            .hero-section h1 {
                font-size: 1.75rem;
                margin-bottom: 0.75rem;
            }
            .hero-section h1 i {
                font-size: 1.5rem;
                margin-right: 0.5rem !important;
            }
            .hero-section p {
                font-size: 0.95rem;
                margin-bottom: 1.25rem !important;
            }
            .btn-custom-primary {
                padding: 0.65rem 1.5rem;
                font-size: 0.9rem;
                width: 100%;
                max-width: 300px;
            }
            /* Feature Cards Mobile - 3 Kolom Kecil */
            .feature-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin-bottom: 0.5rem;
                border-radius: 10px;
            }
            .feature-card {
                padding: 0.75rem 0.5rem;
                border-radius: 10px;
                margin-bottom: 0.75rem;
            }
            .feature-card h5 {
                font-size: 0.8rem;
                margin-bottom: 0.35rem;
                font-weight: 600;
            }
            .feature-card p {
                font-size: 0.65rem;
                line-height: 1.4;
                margin-bottom: 0;
            }
            /* Scanner Card Mobile */
            .scanner-card {
                padding: 1.5rem 1rem;
                border-radius: 15px;
            }
            .scanner-card h3 {
                font-size: 1.25rem;
                margin-bottom: 0.5rem !important;
            }
            .scanner-card h3 i {
                font-size: 1.15rem;
            }
            .scanner-card p {
                font-size: 0.875rem;
            }
            .mb-4 {
                margin-bottom: 1rem !important;
            }
            /* Grid adjustments untuk 3 kolom mobile */
            .g-4 {
                --bs-gutter-y: 0.75rem;
                --bs-gutter-x: 0.5rem;
            }
        }
        /* Extra Small Devices (< 576px) */
        @media (max-width: 576px) {
            .container {
                padding: 0 12px;
            }
            .hero-section {
                padding: 1.75rem 1rem;
                margin-bottom: 1.25rem;
            }
            .hero-section h1 {
                font-size: 1.5rem;
            }
            .hero-section h1 i {
                font-size: 1.35rem;
            }
            .hero-section p {
                font-size: 0.9rem;
            }
            .btn-custom-primary {
                padding: 0.6rem 1.25rem;
                font-size: 0.875rem;
            }
            /* Feature Cards Extra Small - Tetap 3 Kolom */
            .feature-icon {
                width: 36px;
                height: 36px;
                font-size: 0.95rem;
                margin-bottom: 0.4rem;
                border-radius: 8px;
            }
            .feature-card {
                padding: 0.65rem 0.4rem;
                border-radius: 8px;
            }
            .feature-card h5 {
                font-size: 0.75rem;
                margin-bottom: 0.3rem;
            }
            .feature-card p {
                font-size: 0.6rem;
                line-height: 1.3;
            }
            .scanner-card {
                padding: 1.25rem 0.875rem;
            }
            .scanner-card h3 {
                font-size: 1.15rem;
            }
            .scanner-card p {
                font-size: 0.825rem;
            }
        }
        /* Extra Extra Small (< 375px) */
        @media (max-width: 375px) {
            .hero-section h1 {
                font-size: 1.35rem;
            }
            .hero-section p {
                font-size: 0.85rem;
            }
            .feature-icon {
                width: 34px;
                height: 34px;
                font-size: 0.9rem;
            }
            .feature-card {
                padding: 0.6rem 0.35rem;
            }
            .feature-card h5 {
                font-size: 0.7rem;
            }
            .feature-card p {
                font-size: 0.55rem;
            }
            .g-4 {
                --bs-gutter-x: 0.4rem;
            }
        }
        /* Landscape Mode */
        @media (max-height: 600px) and (orientation: landscape) {
            .hero-section {
                padding: 1.5rem 1rem;
                margin-bottom: 1rem;
            }
            .hero-section h1 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }
            .hero-section p {
                font-size: 0.9rem;
                margin-bottom: 1rem !important;
            }
            .mb-5 {
                margin-bottom: 1rem !important;
            }
        }
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #ddd;
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
    <div id="loading-overlay" 
     style="
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(3px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
     ">
    <div class="spinner"></div>
    <p class="mt-3 fw-bold">Loading...</p>
</div>
<div class="container mt-5 mb-5">
    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1><i class="fas fa-qrcode me-2"></i>Sistem Scan Dokumen ISO</h1>
            <p class="mb-4">Scan QR Code atau Barcode untuk mengakses informasi dokumen dengan cepat dan mudah</p>
            <a href="<?= base_url('/login') ?>" class="btn btn-custom-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem
            </a>
        </div>
    </div>
    <!-- Features Section -->
    <div class="row mb-5 g-4">
        <div class="col-4">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h5>Scan Cepat</h5>
                <p class="text-muted mb-0">Gunakan kamera untuk scan QR Code atau Barcode dalam hitungan detik</p>
            </div>
        </div>
        <div class="col-4">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h5>Akses Dokumen</h5>
                <p class="text-muted mb-0">Lihat detail dan preview dokumen PDF secara langsung</p>
            </div>
        </div>
        <div class="col-4">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5>Aman & Terpercaya</h5>
                <p class="text-muted mb-0">Sistem terenkripsi untuk menjaga keamanan data dokumen Anda</p>
            </div>
        </div>
    </div>
    <!-- Scanner Section -->
    <div class="scanner-card">
        <div class="text-center mb-4">
            <h3 class="mb-2"><i class="fas fa-qrcode me-2" style="color: var(--primary-color);"></i>Scan Dokumen</h3>
            <p class="text-muted">Arahkan kamera ke QR Code atau Barcode pada dokumen</p>
        </div>
        <!-- Placeholder untuk form scanner -->
        <?= view('Home/scan/form', ['inline' => true]) ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Saat tombol login diklik, tampilkan loading
document.addEventListener("DOMContentLoaded", function() {
    const loginBtn = document.querySelector(".btn-custom-primary");

    if (loginBtn) {
        loginBtn.addEventListener("click", function(e) {
            e.preventDefault(); // cegah pindah halaman langsung

            document.getElementById("loading-overlay").style.display = "flex";

            // Delay 800ms → barulah redirect
            setTimeout(() => {
                window.location.href = loginBtn.href;
            }, 800);
        });
    }
});
</script>

</body>
</html>