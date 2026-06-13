<main class="dashboard-main">
    <!-- Welcome Banner -->
    <section class="welcome-section glass-panel">
        <div class="welcome-text">
            <h1>Selamat Datang, <?= e(Auth::user()->name ?? 'Siswa') ?>! 👋</h1>
            <p>Siap untuk belajar dan menguji kemampuanmu hari ini?</p>
        </div>
        <div class="welcome-illustration">
            <i class="fas fa-chart-line illustration-icon" style="font-size: 5rem; opacity: 0.8;"></i>
        </div>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid">
        <div class="stat-card glass-panel badge-success">
            <div class="stat-icon-wrapper">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div class="stat-details">
                <h3>0</h3>
                <p>Ujian Selesai</p>
            </div>
        </div>
        <div class="stat-card glass-panel badge-primary">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chart-bar fa-2x"></i>
            </div>
            <div class="stat-details">
                <h3>0.0</h3>
                <p>Nilai Rata-rata</p>
            </div>
        </div>
        <div class="stat-card glass-panel badge-warning">
            <div class="stat-icon-wrapper">
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
            <div class="stat-details">
                <h3><?= count($upcoming_exams) ?></h3>
                <p>Ujian Tersedia</p>
            </div>
        </div>
    </section>

    <!-- Exam List -->
    <section class="exam-list-section">
        <div class="section-header">
            <h2>Daftar Ujian Tersedia</h2>
            <p>Pilih ujian yang ingin kamu kerjakan sekarang.</p>
        </div>

        <div class="exam-grid">
            <?php if (empty($upcoming_exams)): ?>
                <div class="empty-state" style="grid-column: 1 / -1; padding: 40px; text-align: center; background: rgba(255,255,255,0.05); border-radius: 16px;">
                    <p style="color: var(--text-muted);">Momen ini belum ada ujian yang tersedia untuk Anda.</p>
                </div>
            <?php else: ?>
                <?php foreach($upcoming_exams as $exam): ?>
                    <?php
                        $statusText = 'Tersedia';
                        $statusColor = '#10b981';
                        $canEnter = true;
                        $now = time();
                        $startTime = strtotime($exam->start_time);
                        $endTime = strtotime($exam->end_time);
                        
                        if ($startTime > 0 && $now < $startTime) {
                            $statusText = 'Belum Buka';
                            $statusColor = '#f59e0b';
                            $canEnter = false;
                        } elseif ($endTime > 0 && $now > $endTime) {
                            $statusText = 'Ditutup';
                            $statusColor = '#ef4444';
                            $canEnter = false;
                        }
                    ?>
                    <div class="exam-card glass-panel" style="opacity: <?= $canEnter ? '1' : '0.6' ?>;">
                        <div class="exam-card-header">
                            <span class="subject-badge" style="background-color: <?= $statusColor ?>;"><?= $statusText ?></span>
                            <div style="flex: 1;"></div>
                            <i class="fas fa-clock time-icon"></i>
                            <span class="time-text"><?= e($exam->duration_minutes) ?> Min</span>
                        </div>
                        
                        <div class="exam-card-body">
                            <h3><?= e($exam->title) ?></h3>
                            <div class="exam-meta">
                                <div class="meta-item">
                                    <i class="fas fa-file-alt"></i>
                                    <span><?= e($exam->subject_name ?? 'Ujian') ?></span>
                                </div>
                                <?php if($exam->start_time || $exam->end_time): ?>
                                    <div class="meta-item" style="font-size: 0.75rem; margin-top: 6px; color: #ffbbaa;">
                                        Jadwal: <?= $exam->start_time ? date('d M H:i', strtotime($exam->start_time)) : '' ?> - <?= $exam->end_time ? date('d M H:i', strtotime($exam->end_time)) : '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="exam-card-footer">
                            <button 
                                onclick="if(<?= $canEnter ? 'true' : 'false' ?>) { window.router.navigate('<?= url('student/exam_start/' . $exam->id) ?>') } else { Swal.fire({icon:'error', title:'Terkunci', text:'Ujian sedang terkunci.'}) }" 
                                class="start-exam-button <?= !$canEnter ? 'disabled' : '' ?>"
                                style="filter: <?= !$canEnter ? 'grayscale(1)' : 'none' ?>; cursor: <?= !$canEnter ? 'not-allowed' : 'pointer' ?>;"
                            >
                                <i class="fas fa-play-circle"></i>
                                <span><?= $canEnter ? 'Mulai Ujian' : 'Terkunci' ?></span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
