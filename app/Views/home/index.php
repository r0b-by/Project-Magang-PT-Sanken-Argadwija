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