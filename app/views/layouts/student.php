<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : APP_NAME ?></title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/exam.css') ?>">
</head>
<body>

    <div class="dashboard-container">
        <!-- Background Blobs -->
        <div class="dashboard-background">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>

        <div class="dashboard-content">
            <!-- Navigation / Header -->
            <header class="dashboard-header">
                <div class="header-brand">
                    <div class="logo-container sm">
                        <i class="fas fa-book-open logo-icon" style="color: white; font-size: 1.2rem;"></i>
                    </div>
                    <h2>iTest</h2>
                </div>
                
                <button class="mobile-menu-toggle hide-on-desktop" style="background: transparent; border: none; cursor: pointer; display: flex;" onclick="document.querySelector('.header-actions').classList.add('mobile-open')">
                    <i class="fas fa-bars" style="color: var(--text-light); font-size: 1.5rem;"></i>
                </button>
                
                <div class="mobile-sidebar-overlay hide-on-desktop" style="display: none;" onclick="document.querySelector('.header-actions').classList.remove('mobile-open')"></div>

                <div class="header-actions">
                    <div class="mobile-menu-header hide-on-desktop" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <h3 style="margin: 0; color: var(--text-light);">Navigasi Siswa</h3>
                        <button class="mobile-menu-close" onclick="document.querySelector('.header-actions').classList.remove('mobile-open')" style="background:none;border:none;color:#fff;">
                            <i class="fas fa-times" style="font-size: 1.5rem;"></i>
                        </button>
                    </div>

                    <div class="user-profile" onclick="window.router.navigate('<?= url('student/profile') ?>')" style="cursor: pointer;" title="Buka Pengaturan Profil">
                        <div class="avatar" style="overflow: hidden;">
                            <i class="fas fa-user" style="color: var(--text-muted);"></i>
                        </div>
                        <div class="user-info">
                            <span class="user-name"><?= e(Auth::user()->name ?? 'Siswa') ?></span>
                            <span class="user-kelas"><?= e(Auth::user()->nis ?? 'Siswa') ?></span>
                        </div>
                    </div>
                    
                    <div class="nav-buttons-group">
                        <button onclick="window.router.navigate('<?= url('student/profile') ?>')" class="history-button" title="Setelan Profil" style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); padding: 10px 16px; border-radius: 12px; cursor: pointer; color: var(--text-light); font-weight: 600;">
                            <i class="fas fa-cog"></i>
                            <span>Profil</span>
                        </button>
                        <button onclick="window.router.navigate('<?= url('student/history') ?>')" class="history-button" title="Riwayat Nilai" style="display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); padding: 10px 16px; border-radius: 12px; cursor: pointer; color: var(--text-light); font-weight: 600;">
                            <i class="fas fa-history"></i>
                            <span>Riwayat</span>
                        </button>
                        <button onclick="window.router.navigate('<?= url('student/leaderboard') ?>')" class="history-button" title="Papan Peringkat" style="display: flex; align-items: center; gap: 8px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.05)); border: 1px solid rgba(251, 191, 36, 0.4); padding: 10px 16px; border-radius: 12px; cursor: pointer; color: #fbbf24; font-weight: bold;">
                            <i class="fas fa-trophy"></i>
                            <span>Peringkat</span>
                        </button>
                    </div>
                    <a href="<?= url('auth/logout') ?>" class="logout-button mobile-mt-auto no-spa" title="Keluar" style="text-decoration: none;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </header>

            <!-- SPA Container -->
            <div id="app-content">
                <?= $content ?>
            </div>

        </div>
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
