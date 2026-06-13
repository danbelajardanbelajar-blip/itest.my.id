<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Admin - ' . APP_NAME ?></title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin-dashboard.css') ?>">
</head>
<body>

    <div class="admin-container">
        <!-- Background -->
        <div class="admin-background">
            <div class="blob blob-admin-1"></div>
            <div class="blob blob-admin-2"></div>
        </div>

        <!-- Sidebar Navigation -->
        <div class="mobile-sidebar-overlay hide-on-desktop" style="display: none;" onclick="document.querySelector('.admin-sidebar').classList.remove('mobile-open'); this.style.display='none';"></div>
        
        <aside class="admin-sidebar glass-panel">
            <div class="sidebar-brand flex-between">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div class="logo-container sm admin-logo" style="width: 36px; height: 36px;">
                        <i class="fas fa-chart-pie logo-icon white" style="font-size: 1.2rem;"></i>
                    </div>
                    <h2>AdminPanel</h2>
                </div>
                <button class="mobile-menu-close hide-on-desktop" onclick="document.querySelector('.admin-sidebar').classList.remove('mobile-open'); document.querySelector('.mobile-sidebar-overlay').style.display='none';" style="background: none; border: none; color: white;">
                    <i class="fas fa-times" style="font-size: 1.5rem;"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <?php $currentUri = $_SERVER['REQUEST_URI'] ?? ''; ?>
                
                <button class="nav-item <?= strpos($currentUri, 'admin/dashboard') !== false ? 'active' : '' ?>" onclick="window.router.navigate('<?= url('admin/dashboard') ?>')">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </button>

                <button class="nav-item <?= strpos($currentUri, 'admin/exams') !== false ? 'active' : '' ?>" onclick="window.router.navigate('<?= url('admin/exams') ?>')">
                    <i class="fas fa-book-open"></i>
                    <span>Manajemen Ujian</span>
                </button>

                <button class="nav-item <?= strpos($currentUri, 'admin/questions') !== false ? 'active' : '' ?>" onclick="window.router.navigate('<?= url('admin/questions') ?>')">
                    <i class="fas fa-database"></i>
                    <span>Bank Soal</span>
                </button>

                <button class="nav-item <?= strpos($currentUri, 'admin/results') !== false ? 'active' : '' ?>" onclick="window.router.navigate('<?= url('admin/results') ?>')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan Nilai</span>
                </button>

                <button class="nav-item <?= strpos($currentUri, 'admin/users') !== false ? 'active' : '' ?>" onclick="window.router.navigate('<?= url('admin/users') ?>')">
                    <i class="fas fa-users"></i>
                    <span>Manajemen Siswa</span>
                </button>

                <button class="nav-item" onclick="window.router.navigate('<?= url('admin/staff') ?>')">
                    <i class="fas fa-user-shield"></i>
                    <span>Manajemen Pegawai</span>
                </button>

                <button class="nav-item" onclick="window.router.navigate('<?= url('admin/schools') ?>')">
                    <i class="fas fa-building"></i>
                    <span>Data Lembaga</span>
                </button>

                <button class="nav-item" onclick="window.router.navigate('<?= url('admin/rooms') ?>')">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Data Ruangan</span>
                </button>

                <button class="nav-item" onclick="window.router.navigate('<?= url('admin/classes') ?>')">
                    <i class="fas fa-chalkboard"></i>
                    <span>Data Kelas</span>
                </button>

                <button class="nav-item" onclick="window.router.navigate('<?= url('admin/settings') ?>')">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </button>
            </nav>

            <div class="sidebar-footer">
                <div class="admin-profile" onclick="window.router.navigate('<?= url('admin/settings') ?>')" style="cursor: pointer;" title="Buka Pengaturan Akun">
                    <div class="admin-avatar" style="overflow: hidden;">
                        <span class="avatar-initials"><?= strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) ?></span>
                    </div>
                    <div class="admin-info">
                        <span class="admin-name"><?= e(Auth::user()->name ?? 'Admin') ?></span>
                        <span class="admin-role"><?= strtoupper(Auth::user()->role ?? 'ADMIN') ?></span>
                    </div>
                </div>
                <a href="<?= url('auth/logout') ?>" class="logout-button admin-logout no-spa" title="Keluar" style="text-decoration: none;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar glass-panel">
                <div style="display: flex; gap: 12px; align-items: center; width: 100%;">
                    <button class="mobile-menu-toggle btn-secondary-admin hide-on-desktop" onclick="document.querySelector('.admin-sidebar').classList.add('mobile-open'); document.querySelector('.mobile-sidebar-overlay').style.display='block';">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="search-bar" style="flex: 1;">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Cari data siswa, ujian, staf..." id="global-search">
                    </div>
                </div>
                <div class="topbar-actions">
                    <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/exams/create') ?>')">
                        <i class="fas fa-plus"></i>
                        <span>Buat Ujian Baru</span>
                    </button>
                </div>
            </header>

            <!-- SPA Content Container -->
            <div id="app-content" style="flex: 1; overflow-y: auto; overflow-x: hidden; min-height: 100%;">
                <?= $content ?>
            </div>
            
        </main>
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
