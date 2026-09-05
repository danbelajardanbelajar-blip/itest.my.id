<div class="dashboard-view fade-in">
    <div class="view-header">
        <h1>Pengaturan Sistem</h1>
        <p>Kelola konfigurasi dasar aplikasi, preferensi tampilan, dan profil institusi.</p>
    </div>

    <div class="settings-container" style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-top: 20px;">
        
        <!-- Sidebar Navigation Settings -->
        <div class="settings-sidebar glass-panel" style="padding: 0; align-self: start;">
            <div style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <h3 style="margin: 0; font-size: 1.1rem;">Kategori</h3>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li>
                    <button type="button" class="settings-tab active" data-target="tab-profile" onclick="switchTab('tab-profile')">
                        <i class="fas fa-university" style="width: 24px;"></i> Profil Institusi
                    </button>
                </li>
                <li>
                    <button type="button" class="settings-tab" data-target="tab-appearance" onclick="switchTab('tab-appearance')">
                        <i class="fas fa-desktop" style="width: 24px;"></i> Tampilan Aplikasi
                    </button>
                </li>
                <li>
                    <button type="button" class="settings-tab" data-target="tab-cbt" onclick="switchTab('tab-cbt')">
                        <i class="fas fa-cogs" style="width: 24px;"></i> Sistem Ujian (CBT)
                    </button>
                </li>
                <li>
                    <button type="button" class="settings-tab" data-target="tab-backup" onclick="switchTab('tab-backup')">
                        <i class="fas fa-database" style="width: 24px;"></i> Backup & Restore
                    </button>
                </li>
            </ul>
        </div>

        <!-- Main Content Settings -->
        <div class="settings-content glass-panel">
            
            <!-- TAB: Profil Institusi -->
            <div id="tab-profile" class="tab-pane active">
                <h2 class="tab-title">Informasi Sekolah / Lembaga</h2>
                <form action="<?= url('admin/saveSettings') ?>" method="POST" class="ajax-form">
                    <input type="hidden" name="setting_group" value="profile">
                    
                    <div class="form-group-set">
                        <label>Nama Aplikasi CBT</label>
                        <input type="text" name="app_name" class="form-input" value="<?= htmlspecialchars(APP_NAME) ?>" required>
                        <small>Nama ini akan muncul di halaman login dan header atas.</small>
                    </div>

                    <div class="form-group-set">
                        <label>Nama Institusi</label>
                        <input type="text" name="institution_name" class="form-input" value="Sekolah Demo" required>
                    </div>

                    <div class="form-group-set">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" class="form-input" style="min-height: 80px;" required>Jl. Pendidikan No. 123, Kota Pelajar</textarea>
                    </div>

                    <div class="form-group-set">
                        <label>Logo Aplikasi</label>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div class="logo-preview">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <input type="file" name="logo" accept="image/*" class="form-input" style="padding: 8px;">
                                <small style="margin-top: 5px;">Format: PNG, JPG, maks. 2MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-admin">
                            <i class="fas fa-save"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB: Tampilan Aplikasi -->
            <div id="tab-appearance" class="tab-pane" style="display: none;">
                <h2 class="tab-title">Pengaturan Tampilan</h2>
                <form action="<?= url('admin/saveSettings') ?>" method="POST" class="ajax-form">
                    <input type="hidden" name="setting_group" value="appearance">
                    
                    <div class="form-group-set">
                        <label>Warna Tema Utama</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="color" name="primary_color" value="#3b82f6" style="width: 50px; height: 40px; border: none; border-radius: 4px; cursor: pointer; background: transparent;">
                            <span>Pilih warna aksen tombol dan elemen utama.</span>
                        </div>
                    </div>

                    <div class="form-group-set">
                        <label>Gaya Sidebar</label>
                        <select name="sidebar_style" class="form-input">
                            <option value="glass">Glassmorphism (Transparan)</option>
                            <option value="solid">Solid Dark</option>
                            <option value="light">Light Mode</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-admin">
                            <i class="fas fa-save"></i> Simpan Tampilan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB: Sistem Ujian (CBT) -->
            <div id="tab-cbt" class="tab-pane" style="display: none;">
                <h2 class="tab-title">Konfigurasi Ujian (CBT)</h2>
                <form action="<?= url('admin/saveSettings') ?>" method="POST" class="ajax-form">
                    <input type="hidden" name="setting_group" value="cbt">
                    
                    <div class="form-group-set">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="global_random_questions" value="1" checked style="width: 18px; height: 18px;">
                            <span>Acak Urutan Soal Global (Default)</span>
                        </label>
                        <small style="margin-left: 28px;">Jika aktif, urutan soal untuk ujian baru akan diacak secara bawaan.</small>
                    </div>

                    <div class="form-group-set" style="margin-top: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="global_random_options" value="1" checked style="width: 18px; height: 18px;">
                            <span>Acak Opsi Jawaban Global (Default)</span>
                        </label>
                    </div>

                    <div class="form-group-set">
                        <label>Toleransi Keterlambatan (Menit)</label>
                        <input type="number" name="delay_tolerance" class="form-input" value="15" style="max-width: 150px;">
                        <small>Batas waktu siswa masih bisa login dan memulai ujian setelah jadwal dimulai.</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-admin">
                            <i class="fas fa-save"></i> Simpan Konfigurasi CBT
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB: Backup & Restore -->
            <div id="tab-backup" class="tab-pane" style="display: none;">
                <h2 class="tab-title">Backup & Restore Database</h2>
                
                <div style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin-bottom: 25px;">
                    <h4 style="margin: 0 0 10px 0; color: #3b82f6;"><i class="fas fa-info-circle"></i> Cadangkan Data Anda secara Berkala</h4>
                    <p style="margin: 0; font-size: 0.9rem; color: var(--text-color);">Fitur ini memungkinkan Anda untuk mengunduh seluruh data aplikasi (Soal, Nilai, Pengguna) dan mengembalikannya jika terjadi kendala pada server.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Backup Panel -->
                    <div class="glass-panel" style="text-align: center; padding: 30px 20px;">
                        <i class="fas fa-cloud-download-alt" style="font-size: 3rem; color: #10b981; margin-bottom: 15px;"></i>
                        <h3 style="margin-bottom: 10px;">Download Backup</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">Unduh salinan database Anda (berformat .sql) ke perangkat lokal.</p>
                        <a href="<?= url('admin/backupDatabase') ?>" target="_blank" class="btn-primary-admin" style="display: inline-block; text-decoration: none; background: #10b981; border-color: #10b981;">
                            <i class="fas fa-download"></i> Buat Backup Sekarang
                        </a>
                    </div>

                    <!-- Restore Panel -->
                    <div class="glass-panel" style="text-align: center; padding: 30px 20px; border: 1px solid rgba(239, 68, 68, 0.3);">
                        <form action="<?= url('admin/restoreDatabase') ?>" method="POST" enctype="multipart/form-data" class="ajax-form">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #ef4444; margin-bottom: 15px;"></i>
                            <h3 style="margin-bottom: 10px; color: #ef4444;">Restore Database</h3>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">⚠️ Peringatan: Proses ini akan menimpa/menghapus seluruh data saat ini!</p>
                            
                            <input type="file" name="sql_file" accept=".sql" required style="width: 100%; margin-bottom: 15px; padding: 5px; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; background: rgba(0,0,0,0.2); color: white;">
                            
                            <button type="submit" class="btn-primary-admin" style="background: #ef4444; border-color: #ef4444;">
                                <i class="fas fa-upload"></i> Restore Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .settings-container {
        grid-template-columns: 1fr !important;
    }
}

.settings-tab {
    width: 100%; 
    text-align: left; 
    padding: 16px 20px; 
    background: transparent; 
    color: var(--text-muted); 
    border: none; 
    border-left: 3px solid transparent; 
    cursor: pointer; 
    transition: all 0.3s;
    font-size: 1rem;
    outline: none;
}
.settings-tab:hover {
    background: rgba(255,255,255,0.05);
    color: #fff;
}
.settings-tab.active {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    border-left: 3px solid #3b82f6;
}

.tab-title {
    font-size: 1.25rem; 
    margin-bottom: 24px; 
    padding-bottom: 12px; 
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.form-group-set {
    margin-bottom: 20px;
}
.form-group-set label {
    display: block; 
    margin-bottom: 8px; 
    color: var(--text-color); 
    font-weight: 500;
}
.form-input {
    width: 100%; 
    padding: 12px; 
    background: rgba(0,0,0,0.2); 
    border: 1px solid rgba(255,255,255,0.1); 
    border-radius: 8px; 
    color: #fff;
}
.form-input:focus {
    border-color: #3b82f6;
    outline: none;
}
.form-group-set small {
    color: var(--text-muted); 
    font-size: 0.8rem; 
    margin-top: 6px; 
    display: block;
}

.logo-preview {
    width: 64px; 
    height: 64px; 
    background: rgba(255,255,255,0.1); 
    border-radius: 12px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 24px; 
    color: #3b82f6;
}

.form-actions {
    text-align: right; 
    margin-top: 30px; 
    padding-top: 20px; 
    border-top: 1px solid rgba(255,255,255,0.05);
}
</style>

<script>
function switchTab(tabId) {
    // Hide all tabs
    document.querySelectorAll('.tab-pane').forEach(el => {
        el.style.display = 'none';
    });
    // Remove active class from all buttons
    document.querySelectorAll('.settings-tab').forEach(el => {
        el.classList.remove('active');
    });
    
    // Show target tab
    document.getElementById(tabId).style.display = 'block';
    
    // Add active class to clicked button
    const targetBtn = document.querySelector(`button[data-target="${tabId}"]`);
    if(targetBtn) targetBtn.classList.add('active');
}
</script>
