<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('admin/exams') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Edit Ujian</h1>
        <p>Perbarui jadwal, mata pelajaran, dan durasi ujian.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 900px;">
        <form action="<?= url('admin/updateExam/' . $exam->id) ?>" method="POST" class="ajax-form">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Judul Ujian</label>
                    <input type="text" name="title" value="<?= e($exam->title) ?>" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Mata Pelajaran</label>
                    <select name="subject_id" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php foreach($subjects as $s): ?>
                            <option value="<?= $s->id ?>" <?= $exam->subject_id == $s->id ? 'selected' : '' ?>><?= e($s->name) ?> (<?= e($s->code) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Kelas Terkait (Opsional)</label>
                    <select name="class_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c->id ?>" <?= $exam->class_id == $c->id ? 'selected' : '' ?>><?= e($c->level) ?> - <?= e($c->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Waktu Mulai</label>
                    <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($exam->start_time)) ?>" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Waktu Selesai</label>
                    <input type="datetime-local" name="end_time" value="<?= date('Y-m-d\TH:i', strtotime($exam->end_time)) ?>" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Durasi (Menit)</label>
                    <input type="number" name="duration_minutes" value="<?= e($exam->duration_minutes) ?>" required min="1" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">KKM / Nilai Lulus</label>
                    <input type="number" name="passing_score" value="<?= e($exam->passing_score) ?>" min="0" max="100" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                </div>
                
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Status Publikasi</label>
                    <select name="status" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="draft" <?= $exam->status == 'draft' ? 'selected' : '' ?>>Draft (Belum bisa diakses siswa)</option>
                        <option value="published" <?= $exam->status == 'published' ? 'selected' : '' ?>>Published (Tampil di dashboard siswa)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary-admin" style="padding: 10px 20px;">
                    <i class="fas fa-save"></i> Perbarui Ujian
                </button>
            </div>
        </form>
    </div>
</div>
