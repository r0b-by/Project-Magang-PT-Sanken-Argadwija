<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'DMS' ?></title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/layouts/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/iso00/show.css') ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .main-content {
            min-height: calc(100vh - 64px);
            padding: 1.5rem;
            background-color: #f8f9fa;
        }

        @media (max-width: 991.98px) {
            .main-content {
                padding: 1rem;
            }
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d1f2eb;
            color: #0f5132;
            border-left: 4px solid #198754;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #664d03;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #cff4fc;
            color: #055160;
            border-left: 4px solid #0dcaf0;
        }

        .alert .btn-close {
            opacity: 0.5;
        }

        .alert .btn-close:hover {
            opacity: 1;
        }

        /* Smooth Transitions */
        a, button {
            transition: all 0.2s ease;
        }

        /* Card Enhancement */
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Table Enhancement */
        .table {
            background-color: white;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        /* Button Enhancement */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Form Control Enhancement */
        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        /* Badge Enhancement */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Loading State */
        .loading {
            pointer-events: none;
            opacity: 0.6;
        }

        /* Utility Classes */
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .shadow-sm-hover:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        /* Responsive Spacing */
        @media (max-width: 767.98px) {
            .main-content {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Desktop) -->
            <div class="col-lg-2 d-none d-lg-block px-0">
                <?php 
                $role = session()->get('role');
                if ($role === 'admin') {
                    echo view('layouts/components/sidebar_admin');
                } elseif ($role === 'dept') {
                    echo view('layouts/components/sidebar_dept');
                }
                ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 px-0">
                <!-- Navbar -->
                <?= view('layouts/components/navbar') ?>
                
                <!-- Content -->
                <main class="main-content">
                    <!-- Flash Messages -->
                    <div class="container-fluid px-2 px-md-3">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div><?= session()->getFlashdata('success') ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div><?= session()->getFlashdata('error') ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('warning')): ?>
                            <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div><?= session()->getFlashdata('warning') ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('info')): ?>
                            <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div><?= session()->getFlashdata('info') ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Page Content -->
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').each(function() {
                    $(this).fadeOut(400, function() {
                        $(this).alert('close');
                    });
                });
            }, 5000);

            // Smooth scroll to top
            $('a[href="#top"]').click(function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            });

            // Add loading state to buttons on form submit
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').addClass('loading').prop('disabled', true);
            });

            // Confirm delete actions
            $('.btn-delete, .delete-action').on('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                    return false;
                }
            });

            // Tooltip initialization
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>