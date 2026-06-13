<div class="auth-card card p-4">
    <div class="text-center mb-4">
        <img src="<?= asset('img/logo.png') ?>" alt="Logo" class="mb-3" style="max-height: 80px;">
        <h4 class="mb-0 fw-bold"><?= APP_NAME ?></h4>
        <p class="text-muted">Silakan login untuk melanjutkan</p>
    </div>

    <form action="<?= url('login') ?>" method="POST" class="ajax-form">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        
        <div class="mb-3">
            <label class="form-label">Username / Email / NIS</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Login</button>
        
        <div class="text-center mt-3">
            <a href="<?= url('forgot-password') ?>" class="text-decoration-none">Lupa password?</a>
        </div>
    </form>
</div>
