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
                <h3><?= number_format($stats['total_participants']) ?> <span style="font-size: 1rem; font-weight: normal;">Orang</span></h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-blue">
            <div class="stat-content">
                <p>Nilai Rata-rata</p>
                <h3><?= number_format($stats['global_avg'], 1) ?></h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-green">
            <div class="stat-content">
                <p>Tertinggi</p>
                <h3 style="color: #10b981;"><?= number_format($stats['max_global'], 1) ?></h3>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-red" style="border-bottom: 3px solid #ef4444;">
            <div class="stat-content">
                <p>Terendah</p>
                <h3 style="color: #ef4444;"><?= number_format($stats['min_global'], 1) ?></h3>
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
                    <?php if(empty($aggregates)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada hasil ujian yang terekam.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($aggregates as $agg): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 12px; color: white; font-weight: 500;"><?= e($agg->exam_title) ?></td>
                            <td style="padding: 12px; color: #9ca3af;"><span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;"><?= e($agg->subject_name ?? 'Umum') ?></span></td>
                            <td style="padding: 12px; color: #9ca3af;"><i class="fas fa-users" style="margin-right: 5px;"></i> <?= $agg->participant_count ?></td>
                            <td style="padding: 12px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="flex: 1; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                                        <div style="height: 100%; width: <?= $agg->average_score ?? 0 ?>%; background: #3b82f6;"></div>
                                    </div>
                                    <span style="color: white; font-weight: 600; width: 40px; text-align: right;"><?= number_format($agg->average_score ?? 0, 1) ?></span>
                                </div>
                            </td>
                            <td style="padding: 12px;">
                                <span style="color: #10b981; font-weight: 600; margin-right: 10px;" title="Nilai Tertinggi"><i class="fas fa-arrow-up"></i> <?= number_format($agg->max_score ?? 0, 1) ?></span>
                                <span style="color: #ef4444; font-weight: 600;" title="Nilai Terendah"><i class="fas fa-arrow-down"></i> <?= number_format($agg->min_score ?? 0, 1) ?></span>
                            </td>
                            <td style="padding: 12px;">
                                <?php 
                                    $passRate = $agg->participant_count > 0 ? ($agg->passed_count / $agg->participant_count) * 100 : 0;
                                ?>
                                <span style="color: <?= $passRate >= 75 ? '#10b981' : ($passRate >= 50 ? '#f59e0b' : '#ef4444') ?>; font-weight: bold;"><?= number_format($passRate, 1) ?>%</span>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <button class="action-btn" onclick="window.location.href='<?= url('admin/exportExcel/' . $agg->exam_id) ?>'" title="Export Data Ujian" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); width: 32px; height: 32px; border-radius: 8px; color: #10b981; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                    <i class="fas fa-file-excel" style="font-size: 14px;"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
