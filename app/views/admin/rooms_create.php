<div class="dashboard-view fade-in">
    <div class="view-header flex-between">
        <div>
            <h1>Tambah Ruangan</h1>
            <p>Masukkan data ruangan fisik atau lab untuk CBT.</p>
        </div>
        <button class="btn-secondary-admin" onclick="window.router.navigate('<?= url('admin/rooms') ?>')">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 600px;">
        <form id="createRoomForm" onsubmit="submitForm(event, this, '<?= url('admin/storeRoom') ?>')">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Ruangan <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Contoh: Lab Komputer 1">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Kapasitas (Client) <span style="color: #ef4444;">*</span></label>
                <input type="number" name="capacity" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Contoh: 40">
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-primary-admin" style="padding: 12px 24px;">
                    <i class="fas fa-save"></i> Simpan Ruangan
                </button>
            </div>
        </form>
    </div>
</div>
