<div class="dashboard-view fade-in">
    <div class="view-header">
        <h1>Ringkasan Sistem</h1>
        <p>Pantau aktivitas dan statistik terkini.</p>
    </div>

    <!-- Overview Stats -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card glass-panel border-blue">
            <div class="stat-content">
                <p>Total Siswa Terdaftar</p>
                <h3><?= e($total_students ?? 0) ?></h3>
            </div>
            <div class="stat-icon bg-blue">
                <i class="fas fa-users" style="font-size: 24px; color: white;"></i>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-purple">
            <div class="stat-content">
                <p>Total Ujian Aktif</p>
                <h3><?= e($total_exams ?? 0) ?></h3>
            </div>
            <div class="stat-icon bg-purple">
                <i class="fas fa-book-open" style="font-size: 24px; color: white;"></i>
            </div>
        </div>
        <div class="admin-stat-card glass-panel border-green">
            <div class="stat-content">
                <p>Rata-rata Nilai Siswa</p>
                <h3><?= e($avg_score ?? '0.0') ?></h3>
            </div>
            <div class="stat-icon bg-green">
                <i class="fas fa-chart-line" style="font-size: 24px; color: white;"></i>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="admin-recent-section glass-panel">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: var(--text-light);">Ujian Terkini Dibuat</h3>
            <button class="text-button" onclick="window.router.navigate('<?= url('admin/exams') ?>')" style="background: none; border: none; color: #8b5cf6; cursor: pointer; font-weight: 500;">Lihat Semua</button>
        </div>

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
                    <?php if(empty($recent_exams)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada ujian.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($recent_exams as $exam): ?>
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
                                    <button class="action-btn" onclick="window.router.navigate('<?= url('admin/exams/edit/' . $exam->id) ?>')" title="Edit Ujian" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: var(--text-light); cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                        <i class="fas fa-edit" style="font-size: 14px;"></i>
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
