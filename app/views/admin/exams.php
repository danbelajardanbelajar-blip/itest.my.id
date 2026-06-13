<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Manajemen Ujian</h1>
            <p>Kelola semua ujian, termasuk status dan materi yang telah dibuat.</p>
        </div>
        <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/exams/create') ?>')">
            <i class="fas fa-plus"></i>
            <span>Buat Ujian Baru</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Ujian</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Mata Pelajaran</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Durasi</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Status</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($exams)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada ujian.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($exams as $exam): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light); font-weight: 500;"><?= e($exam->title) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light);"><?= e($exam->subject_name ?? 'Umum') ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light);"><?= e($exam->duration_minutes) ?> Menit</td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <?php
                                        $statusClass = $exam->status === 'published' ? 'active' : 'draft';
                                        $statusText = $exam->status === 'published' ? 'Aktif' : 'Draft';
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; background: <?= $exam->status === 'published' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(156, 163, 175, 0.15)' ?>; color: <?= $exam->status === 'published' ? '#34d399' : '#9ca3af' ?>;"><?= $statusText ?></span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <button class="action-btn" onclick="window.router.navigate('<?= url('admin/exams/edit/' . $exam->id) ?>')" title="Edit Ujian" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #3b82f6; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                            <i class="fas fa-edit" style="font-size: 14px;"></i>
                                        </button>
                                        <button class="action-btn" onclick="deleteExam(<?= $exam->id ?>)" title="Hapus Ujian" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #ef4444; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
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
function deleteExam(id) {
    window.deleteItem('<?= url('admin/deleteExam/') ?>' + id, 'Hapus Ujian?');
}
</script>
