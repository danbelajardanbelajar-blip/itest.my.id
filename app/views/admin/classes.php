<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Data Kelas</h1>
            <p>Kelola data rombongan belajar (rombel) dan tingkat/jenjang.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <label class="btn-secondary-admin" style="cursor: pointer; margin: 0; padding: 10px 16px; border-color: #3b82f6; color: #3b82f6;" title="Impor data massal dari Excel">
                <i class="fas fa-file-excel"></i>
                <span class="hide-on-mobile">Impor Excel</span>
                <input type="file" accept=".xlsx, .xls" style="display: none;">
            </label>
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_class') ?>')">
                <i class="fas fa-plus"></i>
                <span>Tambah Kelas</span>
            </button>
        </div>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Tingkat / Grade</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Kelas</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Jurusan / Program</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Wali Kelas</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($classes)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data kelas terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($classes as $class): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;">
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($class->level) ?></td>
                            <td style="padding: 16px 12px; font-weight: 500; color: #fff;"><?= htmlspecialchars($class->name) ?></td>
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($class->major_name ?? '-') ?></td>
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($class->teacher_name ?? '-') ?></td>
                            <td style="padding: 16px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button class="btn-icon" onclick="window.router.navigate('<?= url('admin/editClass/' . $class->id) ?>')" title="Edit" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="deleteClass(<?= $class->id ?>)" title="Hapus" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
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
function deleteClass(id) {
    window.deleteItem('<?= url('admin/deleteClass/') ?>' + id, 'Hapus Kelas?');
}
</script>
