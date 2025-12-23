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
    <link rel="stylesheet" href="<?= base_url('css/layouts/components/navbar.css') ?>">
</head>
<body>

    <!-- SIDEBAR -->
    <?php 
        $role = session()->get('role');
        if ($role === 'admin') {
            echo view('layouts/components/sidebar_admin');
        } elseif ($role === 'dept') {
            echo view('layouts/components/sidebar_dept');
        }
    ?>

    <!-- NAVBAR -->
    <?= view('layouts/components/navbar') ?>

    <!-- MAIN CONTENT (INI YANG SCROLL) -->
    <main class="main-content">
        <div class="container-fluid px-3">

            <!-- FLASH MESSAGE -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>

        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts -->
    <script src="<?= base_url('js/layouts/main.js') ?>"></script>
    <script src="<?= base_url('js/layouts/components/sidebar_admin.js') ?>"></script>
    <script src="<?= base_url('js/users/edit.js') ?>"></script>
    <script src="<?= base_url('js/access/index.js') ?>"></script>
    <script src="<?= base_url('js/barcode/index.js') ?>"></script>
    <script src="<?= base_url('js/barcode/detail.js') ?>"></script>
    <script src="<?= base_url('js/iso00/create.js') ?>"></script>
    <script src="<?= base_url('js/iso00/edit.js') ?>"></script>
    
</body>
</html>
