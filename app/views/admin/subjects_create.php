<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="back-btn" onclick="window.router.navigate('<?= url('admin/subjects') ?>')" style="background:none; border:none; color:var(--text-muted); cursor:pointer; margin-bottom: 10px; display:flex; align-items:center; gap:5px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Tambah Mata Pelajaran</h1>
        <p>Tambahkan mata pelajaran baru ke dalam sistem.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 600px;">
        <form action="<?= url('admin/storeSubject') ?>" method="POST" class="ajax-form">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 24px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Kode Mata Pelajaran</label>
                    <input type="text" name="code" required placeholder="Contoh: MTK" style="width: 100%; padding: 10px 14px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Nama Mata Pelajaran</label>
                    <input type="text" name="name" required placeholder="Contoh: Matematika" style="width: 100%; padding: 10px 14px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px;">
                <button type="button" onclick="window.router.navigate('<?= url('admin/subjects') ?>')" style="padding: 10px 20px; border-radius: 8px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); cursor: pointer;">Batal</button>
                <button type="submit" class="btn-primary-admin" style="padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-save"></i> Simpan Mata Pelajaran
                </button>
            </div>
        </form>
    </div>
</div>
