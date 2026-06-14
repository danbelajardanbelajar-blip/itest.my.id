<div class="dashboard-view fade-in">
    <div class="view-header">
        <h1>Pengaturan Sistem</h1>
        <p>Kelola konfigurasi dasar aplikasi, preferensi tampilan, dan profil institusi.</p>
    </div>

    <div class="settings-container" style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-top: 20px;">
        
        <!-- Sidebar Navigation Settings -->
        <div class="settings-sidebar glass-panel" style="padding: 0;">
            <div style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <h3 style="margin: 0; font-size: 1.1rem;">Kategori</h3>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li>
                    <button class="settings-tab active" style="width: 100%; text-align: left; padding: 16px 20px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; border-left: 3px solid #3b82f6; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-university" style="width: 24px;"></i> Profil Institusi
                    </button>
                </li>
                <li>
                    <button class="settings-tab" style="width: 100%; text-align: left; padding: 16px 20px; background: transparent; color: var(--text-muted); border: none; border-left: 3px solid transparent; cursor: pointer; transition: all 0.3s;" onclick="alert('Fitur ini akan segera hadir')">
                        <i class="fas fa-desktop" style="width: 24px;"></i> Tampilan Aplikasi
                    </button>
                </li>
                <li>
                    <button class="settings-tab" style="width: 100%; text-align: left; padding: 16px 20px; background: transparent; color: var(--text-muted); border: none; border-left: 3px solid transparent; cursor: pointer; transition: all 0.3s;" onclick="alert('Fitur ini akan segera hadir')">
                        <i class="fas fa-cogs" style="width: 24px;"></i> Sistem Ujian (CBT)
                    </button>
                </li>
                <li>
                    <button class="settings-tab" style="width: 100%; text-align: left; padding: 16px 20px; background: transparent; color: var(--text-muted); border: none; border-left: 3px solid transparent; cursor: pointer; transition: all 0.3s;" onclick="alert('Fitur ini akan segera hadir')">
                        <i class="fas fa-database" style="width: 24px;"></i> Backup & Restore
                    </button>
                </li>
            </ul>
        </div>

        <!-- Main Content Settings -->
        <div class="settings-content glass-panel">
            <h2 style="font-size: 1.25rem; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">Informasi Sekolah / Lembaga</h2>
            
            <form onsubmit="event.preventDefault(); alert('Pengaturan berhasil disimpan!');">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Aplikasi CBT</label>
                    <input type="text" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" value="<?= htmlspecialchars(APP_NAME) ?>">
                    <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 4px; display: block;">Nama ini akan muncul di halaman login dan header atas.</small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Institusi</label>
                    <input type="text" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" value="SMA Negeri 1 Contoh">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Alamat Lengkap</label>
                    <textarea class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; min-height: 80px;">Jl. Pendidikan No. 123, Kota Pelajar</textarea>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Logo Aplikasi</label>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #3b82f6;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <button type="button" class="btn-secondary-admin" style="margin-bottom: 8px; font-size: 0.85rem; padding: 8px 12px;">Pilih Logo Baru</button>
                            <div style="color: var(--text-muted); font-size: 0.8rem;">Format: PNG, JPG, maks. 2MB</div>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                    <button type="submit" class="btn-primary-admin" style="padding: 12px 24px;">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
@media (max-width: 768px) {
    .settings-container {
        grid-template-columns: 1fr !important;
    }
}
.settings-tab:hover {
    background: rgba(255,255,255,0.05) !important;
    color: #fff !important;
}
.settings-tab.active:hover {
    background: rgba(59, 130, 246, 0.1) !important;
    color: #3b82f6 !important;
}
</style>
