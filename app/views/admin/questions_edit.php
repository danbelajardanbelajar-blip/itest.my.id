<div class="dashboard-view fade-in">
    <div class="view-header">
        <button class="btn-secondary-admin mb-3" onclick="window.router.navigate('<?= url('admin/questions') ?>')">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Edit Soal</h1>
        <p>Perbarui soal pada bank soal.</p>
    </div>

    <div class="admin-recent-section glass-panel" style="max-width: 900px;">
        <form action="<?= url('admin/updateQuestion/' . $question->id) ?>" method="POST" class="ajax-form">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Mata Pelajaran</label>
                    <select name="subject_id" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php foreach($subjects as $s): ?>
                            <option value="<?= $s->id ?>" <?= $question->subject_id == $s->id ? 'selected' : '' ?>><?= e($s->name) ?> (<?= e($s->code) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Kelas Terkait (Opsional)</label>
                    <select name="class_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: #1f2937; color: white; border-radius: 8px;">
                        <option value="">-- Umum / Semua Kelas --</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c->id ?>" <?= $question->class_id == $c->id ? 'selected' : '' ?>><?= e($c->level) ?> - <?= e($c->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: var(--text-color); font-weight: 500;">Teks Pertanyaan</label>
                    <textarea name="question_text" required class="form-control" rows="4" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px; resize: vertical;"><?= e($question->question_text) ?></textarea>
                </div>

                <!-- Opsi Jawaban -->
                <div style="grid-column: span 2; margin-top: 10px;">
                    <h3 style="margin-bottom: 15px; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">Pilihan Jawaban</h3>
                    <p style="color: #9ca3af; font-size: 0.9rem; margin-bottom: 15px;">Pilih bulatan di sebelah kiri untuk menentukan jawaban yang benar.</p>
                    
                    <?php 
                        $i = 0;
                        foreach($choices as $choice): 
                    ?>
                    <div style="display: flex; gap: 15px; align-items: flex-start; margin-bottom: 15px;">
                        <input type="radio" name="correct_option" value="<?= $i ?>" <?= $choice->is_correct ? 'checked' : '' ?> style="margin-top: 12px; transform: scale(1.5);">
                        <div style="flex: 1;">
                            <textarea name="options[]" class="form-control" rows="2" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px; resize: vertical;" placeholder="Opsi <?= chr(65 + $i) ?>"><?= e($choice->choice_text) ?></textarea>
                        </div>
                    </div>
                    <?php 
                        $i++;
                        endforeach; 
                        
                        // If there are less than 5 choices, pad it
                        for($j = $i; $j < 5; $j++):
                    ?>
                    <div style="display: flex; gap: 15px; align-items: flex-start; margin-bottom: 15px;">
                        <input type="radio" name="correct_option" value="<?= $j ?>" style="margin-top: 12px; transform: scale(1.5);">
                        <div style="flex: 1;">
                            <textarea name="options[]" class="form-control" rows="2" style="width: 100%; padding: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.2); color: white; border-radius: 8px; resize: vertical;" placeholder="Opsi <?= chr(65 + $j) ?>"></textarea>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary-admin" style="padding: 10px 20px;">
                    <i class="fas fa-save"></i> Perbarui Soal
                </button>
            </div>
        </form>
    </div>
</div>
