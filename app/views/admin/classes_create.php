<div class="dashboard-view fade-in">
    <div class="view-header flex-between">
        <div>
            <h1>Tambah Kelas Baru</h1>
            <p>Masukkan data kelas dan tentukan wali kelas.</p>
        </div>
        <button class="btn-secondary-admin" onclick="window.router.navigate('<?= url('admin/classes') ?>')">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 600px;">
        <form id="createClassForm" onsubmit="submitForm(event, this, '<?= url('admin/storeClass') ?>')">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Tingkat / Grade <span style="color: #ef4444;">*</span></label>
                <input type="text" name="level" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Contoh: X, XI, 10, 11">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Kelas <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required placeholder="Contoh: IPA 1, RPL A">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Wali Kelas</label>
                <select name="teacher_id" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                    <option value="" style="background: #1e1e2d;">-- Pilih Wali Kelas --</option>
                    <?php if(!empty($teachers)): foreach($teachers as $teacher): ?>
                        <option value="<?= $teacher->id ?>" style="background: #1e1e2d;"><?= htmlspecialchars($teacher->name) ?> (<?= htmlspecialchars($teacher->nip ?? '-') ?>)</option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-primary-admin" style="padding: 12px 24px;">
                    <i class="fas fa-save"></i> Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
