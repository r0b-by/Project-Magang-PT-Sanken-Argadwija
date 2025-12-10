<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Scan Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/home/index.css') ?>">
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