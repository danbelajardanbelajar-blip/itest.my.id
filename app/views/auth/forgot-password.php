<div class="login-container">
    <div class="login-background">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>
    
    <div class="login-card">
        <div class="login-header">
            <div class="logo-container">
                <i class="fas fa-key fa-2x"></i>
            </div>
            <h1>Lupa Kata Sandi</h1>
            <p>Masukkan email Anda untuk mereset kata sandi</p>
        </div>

        <form action="<?= url('auth/forgotPassword') ?>" method="POST" class="login-form ajax-form">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div class="input-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan Email terdaftar"
                        required
                    />
                </div>
            </div>

            <button type="submit" class="login-button" style="margin-top: 24px;">
                <span>Kirim Link Reset</span>
                <i class="fas fa-paper-plane"></i>
            </button>
            
            <div style="text-align: center; margin-top: 16px; font-size: 0.9rem;">
                <a href="<?= url('auth/login') ?>" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Sistem Ujian Terpadu &copy; <?= date('Y') ?></p>
        </div>
    </div>
</div>
