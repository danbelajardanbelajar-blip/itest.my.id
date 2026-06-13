<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Bank Soal</h1>
            <p>Kelola semua soal untuk berbagai mata pelajaran.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="btn-secondary-admin" style="border-color: #10b981; color: #10b981; padding: 10px 16px;" title="Unduh Template Excel">
                <i class="fas fa-download"></i>
                <span class="hide-on-mobile">Unduh Template</span>
            </button>
            <label class="btn-secondary-admin" style="cursor: pointer; margin: 0; padding: 10px 16px; border-color: #3b82f6; color: #3b82f6;" title="Impor data massal dari Excel">
                <i class="fas fa-file-excel"></i>
                <span class="hide-on-mobile">Impor Excel</span>
                <input type="file" accept=".xlsx, .xls" style="display: none;">
            </label>
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/questions/create') ?>')">
                <i class="fas fa-plus"></i>
                <span>Buat Soal Baru</span>
            </button>
        </div>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 1%; text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">#</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Pertanyaan</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Opsi Jawaban</th>
                        <th style="width: 1%; text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($questions)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada soal.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($questions as $i => $q): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-muted);"><?= $i + 1 ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <div style="display: flex; gap: 6px; margin-bottom: 6px; flex-wrap: wrap;">
                                        <span style="font-size: 0.75rem; padding: 2px 8px; background: rgba(59,130,246,0.2); color: #60a5fa; border-radius: 6px;"><?= e($q->subject_name ?? 'Umum') ?></span>
                                        <?php if(isset($q->class_name)): ?>
                                            <span style="font-size: 0.75rem; padding: 2px 8px; background: rgba(16,185,129,0.2); color: #34d399; border-radius: 6px;"><?= e($q->class_name) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p style="margin: 0; color: var(--text-light); font-weight: 500; font-size: 0.95rem;"><?= nl2br(e($q->text)) ?></p>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <?php 
                                        $choices = $this->model('Question')->getChoices($q->id);
                                    ?>
                                    <ul style="margin: 0; padding-left: 16px; font-size: 0.85rem; color: var(--text-muted);">
                                        <?php foreach($choices as $idx => $choice): ?>
                                            <li style="<?= $choice->is_correct ? 'color: #10b981; font-weight: bold;' : 'color: inherit;' ?>">
                                                <?= chr(65 + $idx) ?>. <?= e($choice->choice_text) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center; vertical-align: middle;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <button class="action-btn" onclick="window.router.navigate('<?= url('admin/questions/edit/' . $q->id) ?>')" title="Edit Soal" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #3b82f6; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                            <i class="fas fa-edit" style="font-size: 14px;"></i>
                                        </button>
                                        <button class="action-btn" onclick="deleteQuestion(<?= $q->id ?>)" title="Hapus Permanen" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #ef4444; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                            <i class="fas fa-trash-alt" style="font-size: 14px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteQuestion(id) {
    Swal.fire({
        title: 'Hapus Soal?',
        text: 'Soal akan dihapus secara permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Terhapus!', 'Soal telah dihapus.', 'success');
            // TODO: Call API
        }
    });
}
</script>
