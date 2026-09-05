<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('admin/account_users') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Tambah Pengguna Baru</h1>
        <p>Buat akun pengguna sistem baru (Admin, Guru, atau Siswa).</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 700px;">
        <form action="<?= url('admin/store_account_user') ?>" method="POST" class="ajax-form">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Nama Lengkap</label>
                    <input type="text" name="name" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="Contoh: Ahmad Dahlan">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Username / ID Pengguna</label>
                    <input type="text" name="username" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="Contoh: ahmad123 / NIP / NIS">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Alamat Email</label>
                    <input type="email" name="email" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="Contoh: ahmad@sekolah.sch.id">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Kata Sandi (Password)</label>
                    <input type="password" name="password" required class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="Masukkan password untuk login">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Peran Akun (Role)</label>
                        <select name="role" class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                            <option value="student">Siswa (Student)</option>
                            <option value="teacher">Guru (Teacher)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 6px; color: var(--text-color); font-weight: 500;">Status Akun</label>
                        <select name="status" class="form-control" style="width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                            <option value="active">Aktif (Dapat Login)</option>
                            <option value="inactive">Nonaktif (Diblokir)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 10px; text-align: right;">
                    <button type="submit" class="btn-primary-admin" style="padding: 12px 28px;">
                        <i class="fas fa-save"></i> Simpan Pengguna
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
