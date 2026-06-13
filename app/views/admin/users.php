<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Manajemen Siswa</h1>
            <p>Kelola data siswa yang terdaftar di sistem.</p>
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
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_user') ?>')">
                <i class="fas fa-plus"></i>
                <span>Siswa Baru</span>
            </button>
        </div>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">NIS</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Lengkap</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Kelas</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Status Akun</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($students)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data siswa.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($students as $std): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light); font-weight: 600;"><?= e($std->nis) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light);"><?= e($std->name) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light);"><?= e($std->class_name ?? '-') ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <?php
                                        // Asumsikan semua aktif untuk sekarang, atau jika ada status di DB
                                        $status = $std->status ?? 'Aktif';
                                        $statusClass = $status === 'Aktif' ? 'active' : 'draft';
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?>" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; background: <?= $status === 'Aktif' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' ?>; color: <?= $status === 'Aktif' ? '#34d399' : '#ef4444' ?>;"><?= e($status) ?></span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <button class="action-btn" onclick="window.router.navigate('<?= url('admin/editStudent/' . $std->id) ?>')" title="Edit" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #3b82f6; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                            <i class="fas fa-edit" style="font-size: 14px;"></i>
                                        </button>
                                        <button class="action-btn" onclick="deleteStudent(<?= $std->id ?>)" title="Hapus" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #ef4444; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
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
function deleteStudent(id) {
    window.deleteItem('<?= url('admin/deleteStudent/') ?>' + id, 'Hapus Siswa?');
}
</script>
