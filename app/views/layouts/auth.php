<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : APP_NAME ?></title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Base CSS -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <!-- Login Specific CSS -->
    <link rel="stylesheet" href="<?= asset('css/login.css') ?>">
</head>
<body>

    <!-- SPA Container -->
    <div id="app-content">
        <?= $content ?>
    </div>

    <!-- Page Loader -->
    <div id="page-loader" class="page-loader" style="display: none;">
        <div class="loader"></div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="<?= asset('js/router.js') ?>"></script>
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
