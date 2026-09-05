<div class="login-container">
    <div class="login-background">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>
    
    <div class="login-card" style="max-width: 500px;">
        <div class="login-header">
            <div class="logo-container">
                <i class="fas fa-user-plus fa-2x"></i>
            </div>
            <h1>Daftar Staf/Guru</h1>
            <p>Lengkapi data di bawah untuk membuat akun baru</p>
        </div>

        <form action="<?= url('auth/register') ?>" method="POST" class="login-form ajax-form">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div class="input-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" id="name" name="name" placeholder="Masukkan Nama Lengkap" required />
                </div>
            </div>

            <div class="input-group">
                <label for="nip">NIP / ID Pegawai</label>
                <div class="input-wrapper">
                    <i class="fas fa-hashtag input-icon"></i>
                    <input type="text" id="nip" name="nip" placeholder="Masukkan NIP atau ID Staf" required />
                </div>
            </div>

            <div class="input-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" placeholder="Masukkan Alamat Email" required />
                </div>
            </div>

            <div class="input-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required />
                </div>
            </div>

            <div class="input-group">
                <label for="password_confirm">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Ulangi Kata Sandi" required />
                </div>
            </div>

            <button type="submit" class="login-button" style="margin-top: 20px;">
                <span>Daftar Sekarang</span>
                <i class="fas fa-user-check"></i>
            </button>
            
            <div style="text-align: center; margin-top: 16px; font-size: 0.9rem;">
                <span style="color: var(--text-muted);">Sudah punya akun? </span>
                <a href="<?= url('auth/login') ?>" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Masuk di sini</a>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Sistem Ujian Terpadu &copy; <?= date('Y') ?></p>
        </div>
    </div>
</div>
