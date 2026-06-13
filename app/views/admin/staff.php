<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Manajemen Pegawai Internal</h1>
            <p>Kelola data guru, tata usaha, dan pengawas sekolah (Staf).</p>
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
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_staff') ?>')">
                <i class="fas fa-plus"></i>
                <span>Tambah Pegawai</span>
            </button>
        </div>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">NIP / ID</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Lengkap</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Peran</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Status Akun</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($staff)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data pegawai.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($staff as $stf): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;">
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($stf->nip ?? '-') ?></td>
                            <td style="padding: 16px 12px; font-weight: 500; color: #fff;"><?= htmlspecialchars($stf->name) ?></td>
                            <td style="padding: 16px 12px;"><span class="badge badge-info" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; background: rgba(59, 130, 246, 0.15); color: #3b82f6;">Guru / Staff</span></td>
                            <td style="padding: 16px 12px;">
                                <?php $statusClass = ($stf->status === 'active') ? 'active' : 'draft'; ?>
                                <span class="badge badge-<?= $statusClass ?>" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; background: <?= $stf->status === 'active' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' ?>; color: <?= $stf->status === 'active' ? '#34d399' : '#ef4444' ?>;"><?= $stf->status === 'active' ? 'Aktif' : 'Nonaktif' ?></span>
                            </td>
                            <td style="padding: 16px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button class="btn-icon" onclick="window.router.navigate('<?= url('admin/editStaff/' . $stf->id) ?>')" title="Edit" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="deleteStaff(<?= $stf->id ?>)" title="Hapus" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
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
function deleteStaff(id) {
    window.deleteItem('<?= url('admin/deleteStaff/') ?>' + id, 'Hapus Pegawai?');
}
</script>
