<div class="dashboard-view fade-in">
    <div class="view-header flex-between">
        <div>
            <h1>Edit Lembaga</h1>
            <p>Perbarui informasi data sekolah atau lembaga.</p>
        </div>
        <button class="btn-secondary-admin" onclick="window.router.navigate('<?= url('admin/schools') ?>')">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 600px;">
        <form id="editSchoolForm" onsubmit="submitForm(event, this, '<?= url('admin/updateSchool/' . $school->id) ?>')">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Nama Sekolah / Lembaga <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" required value="<?= htmlspecialchars($school->name) ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Jenjang</label>
                <input type="text" name="level" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;" value="<?= htmlspecialchars($school->level ?? '') ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem;">Alamat / Lokasi</label>
                <textarea name="address" class="form-input" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; min-height: 80px;"><?= htmlspecialchars($school->address ?? '') ?></textarea>
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-primary-admin" style="padding: 12px 24px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
