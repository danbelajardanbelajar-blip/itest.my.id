<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4 d-flex align-items-center">
                <img src="<?= asset('img/default-user.png') ?>" alt="Student" class="rounded-circle bg-light me-4" width="80" height="80">
                <div>
                    <h3 class="fw-bold mb-1">Halo, <?= e(Auth::user()->name) ?>!</h3>
                    <p class="mb-0 text-white-50">Siap untuk mengikuti ujian hari ini? Tetap semangat dan fokus!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <h5 class="fw-bold mb-3"><i class="fas fa-clipboard-list text-primary me-2"></i> Ujian Tersedia</h5>
        
        <?php if (empty($upcoming_exams)): ?>
            <div class="alert alert-light border shadow-sm text-center py-5">
                <i class="fas fa-calendar-times fs-1 text-muted mb-3"></i>
                <h6 class="text-muted mb-0">Saat ini tidak ada ujian yang tersedia untuk Anda.</h6>
            </div>
        <?php else: ?>
            <!-- Placeholder list -->
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold"><i class="fas fa-bullhorn text-warning me-2"></i> Pengumuman Terbaru</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Belum ada pengumuman.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold"><i class="fas fa-chart-line text-success me-2"></i> Nilai Terakhir</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Belum ada nilai yang keluar.</p>
            </div>
        </div>
    </div>
</div>
