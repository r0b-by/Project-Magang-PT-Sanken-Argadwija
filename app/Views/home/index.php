<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Scan Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        .container {
            padding: 1rem;
        }
        
        .hero-section {
            background: #2c3e50;
            color: white;
            border-radius: 10px;
            padding: 2rem 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .hero-section p {
            opacity: 0.9;
            margin-bottom: 1rem;
        }
        
        .scanner-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .btn-login {
            background: white;
            color: #2c3e50;
            border: 2px solid #2c3e50;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
        }
        
        .btn-login:hover {
            background: #2c3e50;
            color: white;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 1.5rem 1rem;
                margin-bottom: 1rem;
            }
            
            .hero-section h1 {
                font-size: 1.25rem;
            }
            
            .scanner-card {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding: 0.75rem;
            }
            
            .hero-section {
                padding: 1.25rem 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1>
                <i class="fas fa-qrcode me-2"></i>
                Sistem Scan Dokumen
            </h1>
            <p>Scan QR Code untuk mengakses dokumen</p>
            <a href="<?= base_url('/login') ?>" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </a>
        </div>
        
        <!-- Scanner Section -->
        <div class="scanner-card">
            <div class="text-center mb-3">
                <h5 class="mb-2">
                    <i class="fas fa-qrcode me-2" style="color: #2c3e50;"></i>
                    Scan Dokumen
                </h5>
                <p class="text-muted small">Arahkan kamera ke QR Code dokumen</p>
            </div>
            <?= view('Home/scan/form', ['inline' => true]) ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>