<div class="login-container">
    <div class="login-background">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>
    
    <div class="login-card">
        <div class="login-header">
            <div class="logo-container">
                <i class="fas fa-book-open fa-2x"></i>
            </div>
            <h1>iTest</h1>
            <p>Silakan masuk untuk memulai sesi Anda</p>
        </div>

        <form action="<?= url('auth/login') ?>" method="POST" class="login-form ajax-form">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div class="input-group">
                <label for="username">Email / Username / NIS</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Masukkan Email, Username Guru, atau NIS"
                        required
                    />
                </div>
            </div>

            <div class="input-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan Kata Sandi"
                        required
                    />
                    <button
                        type="button"
                        class="toggle-password-btn"
                        onclick="const p = document.getElementById('password'); const i = this.querySelector('i'); if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); } else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }"
                        style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; padding: 4px;"
                    >
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" />
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot-password no-spa">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="login-button">
                <span>Masuk Sekarang</span>
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <div style="text-align: center; margin-top: 16px; font-size: 0.9rem;">
                <span style="color: var(--text-muted);">Bukan siswa? </span>
                <a href="<?= url('auth/register') ?>" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Daftar sebagai Staf</a>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Sistem Ujian Terpadu &copy; 2026</p>
            <div style="display: flex; gap: 16px; justify-content: center; margin-top: 12px;">
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseenter="this.style.color='var(--text-light)'" onmouseleave="this.style.color='var(--text-muted)'">Tentang Kami</a>
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseenter="this.style.color='var(--text-light)'" onmouseleave="this.style.color='var(--text-muted)'">Kebijakan Privasi</a>
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseenter="this.style.color='var(--text-light)'" onmouseleave="this.style.color='var(--text-muted)'">Bantuan</a>
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseenter="this.style.color='var(--text-light)'" onmouseleave="this.style.color='var(--text-muted)'">Feedback</a>
            </div>
        </div>
    </div>
</div>
