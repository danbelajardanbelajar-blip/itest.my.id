<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold"><i class="fas fa-clipboard-list text-primary me-2"></i> Ujian Tersedia</h4>
        <p class="text-muted">Berikut adalah daftar ujian yang dapat Anda kerjakan saat ini.</p>
    </div>
</div>

<div class="row">
    <?php if (empty($upcoming_exams)): ?>
        <div class="col-12">
            <div class="alert alert-light border shadow-sm text-center py-5">
                <i class="fas fa-calendar-times fs-1 text-muted mb-3"></i>
                <h6 class="text-muted mb-0">Saat ini tidak ada ujian yang tersedia untuk Anda.</h6>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($upcoming_exams as $exam): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary"><?= e($exam->subject_name) ?></span>
                            <span class="badge bg-secondary"><i class="fas fa-clock me-1"></i> <?= $exam->duration_minutes ?> Menit</span>
                        </div>
                        <h5 class="fw-bold mb-2"><?= e($exam->title) ?></h5>
                        <div class="small text-muted mb-3">
                            <div><i class="fas fa-calendar-alt me-1"></i> Mulai: <?= date('d M Y H:i', strtotime($exam->start_time)) ?></div>
                            <div><i class="fas fa-flag-checkered me-1"></i> Selesai: <?= date('d M Y H:i', strtotime($exam->end_time)) ?></div>
                        </div>
                        <a href="<?= url('student/exam_start/' . $exam->id) ?>" class="btn btn-outline-primary w-100 fw-bold">Masuk Ujian <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
