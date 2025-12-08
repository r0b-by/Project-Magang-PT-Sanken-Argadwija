<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Sistem Manajemen Dokumen</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 90%;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        
        .error-code {
            font-size: 6rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }
        
        .error-message {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 30px;
        }
        
        .error-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #667eea;
        }
        
        .action-buttons .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .error-stack {
            font-family: 'Courier New', monospace;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            max-height: 200px;
            overflow-y: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="text-center">
            <!-- Error Icon -->
            <div class="error-icon">
                <?php if ($statusCode == 404): ?>
                    <i class="fas fa-map-signs text-warning"></i>
                <?php elseif ($statusCode == 403): ?>
                    <i class="fas fa-ban text-danger"></i>
                <?php elseif ($statusCode == 500): ?>
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                <?php else: ?>
                    <i class="fas fa-exclamation-circle text-primary"></i>
                <?php endif; ?>
            </div>
            
            <!-- Error Code -->
            <h1 class="error-code mb-0"><?= $statusCode ?></h1>
            
            <!-- Error Message -->
            <div class="error-message">
                <?= esc($message) ?>
            </div>
            
            <!-- Error Details -->
            <div class="error-details text-start">
                <h5 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Detail Error:
                </h5>
                <p class="mb-2">
                    <strong>Waktu:</strong> <?= date('Y-m-d H:i:s') ?>
                </p>
                <p class="mb-2">
                    <strong>URL:</strong> <?= current_url() ?>
                </p>
                <p class="mb-0">
                    <strong>IP Address:</strong> <?= $this->request->getIPAddress() ?>
                </p>
            </div>
            
            <!-- Debug Info (only show in development) -->
            <?php if (isset($exception) && ENVIRONMENT == 'development'): ?>
            <div class="error-stack">
                <strong>Exception:</strong> <?= esc($exception->getMessage()) ?><br>
                <strong>File:</strong> <?= esc($exception->getFile()) ?>:<?= $exception->getLine() ?><br><br>
                <strong>Stack Trace:</strong><br>
                <?php 
                $trace = $exception->getTrace();
                foreach (array_slice($trace, 0, 5) as $index => $t):
                ?>
                    #<?= $index ?> <?= isset($t['file']) ? esc($t['file']) . ':' . $t['line'] : '[internal function]' ?><br>
                    &nbsp;&nbsp;<?= isset($t['class']) ? $t['class'] . $t['type'] : '' ?><?= $t['function'] ?>()<br>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="action-buttons mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="/" class="btn btn-primary w-100">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:history.back()" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button onclick="window.location.reload()" class="btn btn-success w-100">
                            <i class="fas fa-sync me-2"></i>Refresh
                        </button>
                    </div>
                </div>
                
                <!-- Additional Help -->
                <div class="mt-4">
                    <p class="text-muted mb-3">Masih mengalami masalah?</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/contact" class="btn btn-outline-primary">
                            <i class="fas fa-headset me-2"></i>Hubungi Support
                        </a>
                        <a href="/faq" class="btn btn-outline-secondary">
                            <i class="fas fa-question-circle me-2"></i>FAQ
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Error ID for Support -->
            <div class="mt-4 pt-3 border-top">
                <small class="text-muted">
                    Error ID: <code><?= bin2hex(random_bytes(8)) ?></code>
                    <?php if (ENVIRONMENT != 'production'): ?>
                        | Environment: <span class="badge bg-info"><?= ENVIRONMENT ?></span>
                    <?php endif; ?>
                </small>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Auto-refresh for certain errors
    document.addEventListener('DOMContentLoaded', function() {
        // If it's a 503 error (Service Unavailable), try auto-refresh
        if (<?= $statusCode ?> === 503) {
            setTimeout(function() {
                window.location.reload();
            }, 10000); // Refresh after 10 seconds
            
            // Show countdown
            let countdown = 10;
            const countdownElement = document.createElement('div');
            countdownElement.className = 'alert alert-info mt-3';
            countdownElement.innerHTML = `
                <i class="fas fa-sync fa-spin me-2"></i>
                Mencoba kembali dalam <span id="countdown">${countdown}</span> detik...
            `;
            document.querySelector('.error-details').after(countdownElement);
            
            const countdownInterval = setInterval(function() {
                countdown--;
                document.getElementById('countdown').textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
        }
        
        // Log error to console
        console.error('Error <?= $statusCode ?>: <?= esc($message) ?>');
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + R to refresh
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            window.location.reload();
        }
        // Escape to go back
        if (e.key === 'Escape') {
            window.history.back();
        }
        // Home key to go to homepage
        if (e.key === 'Home') {
            window.location.href = '/';
        }
    });
    </script>
</body>
</html>