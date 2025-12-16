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
    <link rel="stylesheet" href="<?= base_url('css/layouts/components/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/layouts/components/sidebar_dept.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/layouts/components/sidebar_admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/barcode/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/barcode/detail.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/barcode/dept_index.css') ?>">
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

    <!-- Components -->
    <script src=<?= base_url('js/users/edit.js')?>></script>
    <script src=<?= base_url('js/users/create.js')?>></script>
    <script src=<?= base_url('js/access/index.js')?>></script>
    <script src=<?= base_url('js/barcode/detail.js')?>></script>
    <script src=<?= base_url('js/barcode/index.js')?>></script>
    <script src=<?= base_url('js/iso00/create.js')?>></script>
    <script src=<?= base_url('js/iso00/edit.js')?>></script>
    <script src=<?= base_url('js/layouts/main.js')?>></script>
</body>
</html>