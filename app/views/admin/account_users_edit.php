<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('admin/account_users') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Edit Pengguna</h1>
        <p>Perbarui informasi akun, hak akses peran, atau reset kata sandi.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 700px;">
        <form action="<?= url('admin/update_account_user/' . $user->id) ?>" method="POST" class="ajax-form">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Nama Lengkap</label>
                    <input type="text" name="name" value="<?= e($user->name) ?>" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Username / ID Pengguna</label>
                    <input type="text" name="username" value="<?= e($user->username) ?>" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Alamat Email</label>
                    <input type="email" name="email" value="<?= e($user->email) ?>" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Kata Sandi Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                    <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 4px; display: block;">Isi kolom ini jika ingin mereset password pengguna.</small>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Peran Akun (Role)</label>
                        <select name="role" class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                            <option value="student" <?= $user->role === 'student' ? 'selected' : '' ?>>Siswa (Student)</option>
                            <option value="teacher" <?= $user->role === 'teacher' ? 'selected' : '' ?>>Guru (Teacher)</option>
                            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Status Akun</label>
                        <select name="status" class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                            <option value="active" <?= $user->status === 'active' ? 'selected' : '' ?>>Aktif (Dapat Login)</option>
                            <option value="inactive" <?= $user->status === 'inactive' ? 'selected' : '' ?>>Nonaktif (Diblokir)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 10px; text-align: right;">
                    <button type="submit" class="btn-primary-admin" style="padding: 12px 28px;">
                        <i class="fas fa-save"></i> Perbarui Pengguna
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
