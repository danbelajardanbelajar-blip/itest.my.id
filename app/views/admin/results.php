<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Laporan Nilai Ujian</h1>
            <p>Analitik lengkap dari hasil ujian siswa.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn-secondary-admin" style="border-color: #3b82f6; color: #3b82f6; padding: 10px 16px;">
                <i class="fas fa-file-excel"></i>
                <span class="hide-on-mobile">Export Global Excel</span>
            </button>
            <button class="btn-secondary-admin" style="border-color: #ef4444; color: #ef4444; padding: 10px 16px;">
                <i class="fas fa-file-pdf"></i>
                <span class="hide-on-mobile">Export Global PDF</span>
            </button>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <div class="admin-stat-card glass-panel border-purple">
            <div class="stat-content">
                <p>Jumlah Peserta</p>
                <h3>0 <span style="font-size: 1rem; font-weight: normal;">Orang</span></h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-blue">
            <div class="stat-content">
                <p>Nilai Rata-rata</p>
                <h3>0.0</h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-green">
            <div class="stat-content">
                <p>Tertinggi</p>
                <h3 style="color: #10b981;">0</h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-red" style="border-bottom: 3px solid #ef4444;">
            <div class="stat-content">
                <p>Terendah</p>
                <h3 style="color: #ef4444;">0</h3>
            </div>
        </div>
    </div>

    <!-- Analytics Table -->
    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Ujian</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Mata Pelajaran</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Peserta</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Rata-rata</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Tertinggi / Terendah</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Lulus</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Export</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($results)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada hasil ujian yang terekam.</td>
                        </tr>
                    <?php else: ?>
                        <!-- Loop through exam result groups here -->
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
