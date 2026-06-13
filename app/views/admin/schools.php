<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Data Lembaga</h1>
            <p>Kelola data instansi pendidikan, jenjang, dan logo lembaga.</p>
        </div>
        <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_school') ?>')">
            <i class="fas fa-plus"></i>
            <span>Tambah Sekolah</span>
        </button>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Kode NPSN</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Sekolah / Lembaga</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Jenjang</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Lokasi</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($schools)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data lembaga terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($schools as $school): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;">
                            <td style="padding: 16px 12px;"><?= str_pad($school->id, 8, '0', STR_PAD_LEFT) ?></td>
                            <td style="padding: 16px 12px; font-weight: 500; color: #fff;"><?= htmlspecialchars($school->name) ?></td>
                            <td style="padding: 16px 12px;"><span class="badge badge-info" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><?= htmlspecialchars($school->level ?? '-') ?></span></td>
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($school->address ?? '-') ?></td>
                            <td style="padding: 16px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button class="btn-icon" onclick="window.router.navigate('<?= url('admin/editSchool/' . $school->id) ?>')" title="Edit" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="deleteSchool(<?= $school->id ?>)" title="Hapus" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
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
function deleteSchool(id) {
    window.deleteItem('<?= url('admin/deleteSchool/') ?>' + id, 'Hapus Lembaga/Sekolah?');
}
</script>
