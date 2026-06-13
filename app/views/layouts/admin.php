<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : APP_NAME ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar p-3">
            <h4 class="text-center mb-4 fw-bold text-white"><?= APP_NAME ?></h4>
            <div class="mb-4 text-center">
                <img src="<?= asset('img/default-user.png') ?>" alt="Admin" class="rounded-circle mb-2 bg-light" width="80" height="80">
                <div class="small"><?= e(Auth::user()->name) ?></div>
                <div class="badge bg-success">Admin</div>
            </div>
            
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'admin/dashboard') !== false ? 'active' : '' ?>" href="<?= url('admin/dashboard') ?>">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                <!-- Placeholder menu -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('admin/users') ?>"><i class="fas fa-users me-2"></i> Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('admin/questions') ?>"><i class="fas fa-database me-2"></i> Bank Soal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('admin/exams') ?>"><i class="fas fa-edit me-2"></i> Ujian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url('admin/results') ?>"><i class="fas fa-chart-bar me-2"></i> Hasil Ujian</a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger no-spa" href="<?= url('auth/logout') ?>">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-panel">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
                <div class="container-fluid">
                    <button class="btn btn-light d-md-none me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="navbar-brand mb-0 h1">Administrator</span>
                </div>
            </nav>

            <div class="p-4" id="app-content">
                <?= $content ?>
            </div>
        </div>
    </div>

    <!-- Page Loader -->
    <div id="page-loader" class="page-loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= asset('js/router.js') ?>"></script>
    <script src="<?= asset('js/app.js') ?>"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
