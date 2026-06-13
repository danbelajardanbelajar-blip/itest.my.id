<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('admin/users') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Edit Siswa</h1>
        <p>Perbarui data siswa CBT.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 800px;">
        <form action="<?= url('admin/updateStudent/' . $student->id) ?>" method="POST" class="ajax-form">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">NIS</label>
                    <input type="text" name="nis" value="<?= e($student->nis) ?>" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Nama Lengkap</label>
                    <input type="text" name="name" value="<?= e($student->name) ?>" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Kelas</label>
                    <select name="class_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c->id ?>" <?= $student->class_id == $c->id ? 'selected' : '' ?>><?= e($c->level) ?> - <?= e($c->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Jenis Kelamin</label>
                    <select name="gender" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="L" <?= $student->gender == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $student->gender == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 15px; grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Ubah Password</label>
                    <input type="text" name="password" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;" placeholder="(Biarkan kosong jika tidak ingin mengubah password)">
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary-admin" style="padding: 10px 20px;">
                    <i class="fas fa-save"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
