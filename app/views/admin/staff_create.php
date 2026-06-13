<div class="dashboard-view fade-in">
    <div class="view-header flex-between">
        <div>
            <h1>Tambah Pegawai</h1>
            <p>Masukkan data guru atau staf tata usaha baru.</p>
        </div>
        <button class="btn-secondary-admin" onclick="window.router.navigate('<?= url('admin/staff') ?>')">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 600px;">
        <form id="createStaffForm" onsubmit="submitForm(event, this, '<?= url('admin/storeStaff') ?>')">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">NIP / ID Pegawai <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nip" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Contoh: 198012122005011001">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Nama lengkap beserta gelar">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Jenis Kelamin</label>
                <select name="gender" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    <option value="L" style="background: #1e1e2d;">Laki-laki</option>
                    <option value="P" style="background: #1e1e2d;">Perempuan</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nomor Telepon / WA</label>
                <input type="text" name="phone" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" placeholder="Contoh: 081234567890">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Password Akun <span style="color: #ef4444;">*</span></label>
                <input type="password" name="password" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Password untuk login">
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-primary-admin" style="padding: 12px 24px;">
                    <i class="fas fa-save"></i> Simpan Pegawai
                </button>
            </div>
        </form>
    </div>
</div>
