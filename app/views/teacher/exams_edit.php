<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('teacher/exams') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Edit Ujian</h1>
        <p>Perbarui jadwal, mata pelajaran, dan durasi ujian.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 900px;">
        <form action="<?= url('teacher/updateExam/' . $exam->id) ?>" method="POST" class="ajax-form">
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

                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Gunakan Bundel Soal (Opsional)</label>
                    <select name="bundle_name" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Ambil Acak dari Semua Bank Soal --</option>
                        <?php if(!empty($bundles)): foreach($bundles as $bundle): ?>
                            <option value="<?= e($bundle) ?>" <?= (isset($exam->bundle_name) && $exam->bundle_name === $bundle) ? 'selected' : '' ?>><?= e($bundle) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <small style="color: #9ca3af; display: block; margin-top: 5px;">Jika dipilih, ujian ini HANYA akan menarik soal dari bundel yang ditentukan.</small>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Waktu Mulai (Opsional)</label>
                    <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($exam->start_time)) ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                    <small style="color: #9ca3af; display: block; margin-top: 5px;">Kosongkan jika ingin ujian langsung aktif otomatis.</small>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Waktu Selesai (Opsional)</label>
                    <input type="datetime-local" name="end_time" value="<?= date('Y', strtotime($exam->end_time)) >= 2090 ? '' : date('Y-m-d\TH:i', strtotime($exam->end_time)) ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px;">
                    <small style="color: #9ca3af; display: block; margin-top: 5px;">Kosongkan jika ujian berlaku selamanya (tanpa kedaluwarsa).</small>
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
                        <option value="draft" <?= $exam->status === 'draft' ? 'selected' : '' ?>>Draft (Belum Ditampilkan)</option>
                        <option value="published" <?= $exam->status === 'published' ? 'selected' : '' ?>>Published (Siap Dikerjakan)</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 25px; text-align: right;">
                <button type="submit" class="btn-primary-admin" style="padding: 10px 24px;">
                    <i class="fas fa-save"></i> Perbarui Ujian
                </button>
            </div>
        </form>
    </div>
</div>
