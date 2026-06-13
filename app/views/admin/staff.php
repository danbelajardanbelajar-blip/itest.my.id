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
            <button class="btn-primary-admin" onclick="alert('Fitur ini akan segera hadir!');">
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
                        <!-- Loop through staff data here -->
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
