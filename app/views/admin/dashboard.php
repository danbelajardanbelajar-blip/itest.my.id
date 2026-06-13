<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Dashboard Admin</h2>
        <p class="text-muted">Selamat datang kembali, <?= e(Auth::user()->name) ?></p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50">Total Siswa</h6>
                        <h2 class="fw-bold mb-0"><?= $total_students ?></h2>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50">Total Ujian</h6>
                        <h2 class="fw-bold mb-0"><?= $total_exams ?></h2>
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-edit"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark-50">Ujian Aktif</h6>
                        <h2 class="fw-bold mb-0"><?= $active_exams ?></h2>
                    </div>
                    <div class="fs-1 text-dark-50">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50">Bank Soal</h6>
                        <h2 class="fw-bold mb-0">150</h2> <!-- Placeholder -->
                    </div>
                    <div class="fs-1 text-white-50">
                        <i class="fas fa-database"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white pb-0 border-0 pt-4">
                <h5 class="fw-bold">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Belum ada aktivitas.</p>
            </div>
        </div>
    </div>
</div>
