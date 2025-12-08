<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dokumen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 1rem 0;
            /* Proteksi */
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -webkit-touch-callout: none;
        }
        
        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
            margin-bottom: 1rem;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            border: none;
        }
        
        .card-header-custom h4 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            font-size: 1.25rem;
        }
        
        .card-header-custom h4 i {
            margin-right: 0.75rem;
        }
        
        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }
        
        .section-title i {
            margin-right: 0.75rem;
        }
        
        .pdf-viewer-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background: white;
            position: relative;
            height: 80vh;
        }
        
        .pdf-viewer-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }
        
        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            body {
                padding: 0.5rem 0;
            }
            
            .container {
                padding: 0 0.5rem;
            }
            
            .card-header-custom {
                padding: 1rem;
            }
            
            .card-header-custom h4 {
                font-size: 1rem;
            }
            
            .card-body {
                padding: 1rem !important;
            }
            
            .section-title {
                font-size: 0.95rem;
                margin-bottom: 0.75rem;
            }
            
            .pdf-viewer-container {
                height: 70vh;
                border-radius: 10px;
            }
            
            .detail-card {
                border-radius: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .card-header-custom h4 i,
            .section-title i {
                font-size: 1rem;
                margin-right: 0.5rem;
            }
            
            .pdf-viewer-container {
                height: 65vh;
            }
        }
        
        /* Proteksi dari screenshot dan copy */
        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>
<body oncontextmenu="return false;">
<div class="container">
    <!-- Detail Card -->
    <div class="detail-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-file-alt"></i>
                Detail Dokumen
            </h4>
        </div>
        
        <div class="card-body p-4">
            <!-- PDF Viewer Section -->
            <?php if ($dok['nama_file'] && strtolower(pathinfo($dok['nama_file'], PATHINFO_EXTENSION)) === 'pdf'): ?>
                <div class="mt-3">
                    <div class="section-title">
                        <i class="fas fa-file-pdf"></i>
                        Preview Dokumen
                    </div>
                    <div class="pdf-viewer-container">
                        <iframe 
                            src="<?= base_url('barcode/file/'.$dok['id']) ?>#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                            frameborder="0">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Proteksi klik kanan
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
    
    // Disable keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // F12 - Developer Tools
        if (e.keyCode === 123) {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+I - Inspect
        if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
            e.preventDefault();
            return false;
        }
        // Ctrl+Shift+J - Console
        if (e.ctrlKey && e.shiftKey && e.keyCode === 74) {
            e.preventDefault();
            return false;
        }
        // Ctrl+U - View Source
        if (e.ctrlKey && e.keyCode === 85) {
            e.preventDefault();
            return false;
        }
        // Ctrl+S - Save
        if (e.ctrlKey && e.keyCode === 83) {
            e.preventDefault();
            return false;
        }
        // Ctrl+P - Print
        if (e.ctrlKey && e.keyCode === 80) {
            e.preventDefault();
            return false;
        }
        // Ctrl+C - Copy
        if (e.ctrlKey && e.keyCode === 67) {
            e.preventDefault();
            return false;
        }
    });
    
    // Disable text selection
    document.onselectstart = function() {
        return false;
    };
    
    // Disable drag
    document.ondragstart = function() {
        return false;
    };
    
    // Disable copy event
    document.addEventListener('copy', function(e) {
        e.preventDefault();
        return false;
    });
    
    // Disable cut event
    document.addEventListener('cut', function(e) {
        e.preventDefault();
        return false;
    });
    
    // Proteksi mobile - Long press
    let touchStartTime = 0;
    document.addEventListener('touchstart', function(e) {
        touchStartTime = Date.now();
    });
    
    document.addEventListener('touchend', function(e) {
        let touchDuration = Date.now() - touchStartTime;
        if (touchDuration > 500) {
            e.preventDefault();
            return false;
        }
    });
    
    // Disable iOS callout
    document.body.style.webkitTouchCallout = 'none';
</script>
</body>
</html>