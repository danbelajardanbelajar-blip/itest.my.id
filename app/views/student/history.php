<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold"><i class="fas fa-history text-success me-2"></i> Riwayat Ujian</h4>
        <p class="text-muted">Berikut adalah daftar ujian yang telah Anda selesaikan.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if(empty($results)): ?>
            <div class="alert alert-light text-center py-4 mb-0">
                <p class="mb-0 text-muted">Belum ada riwayat ujian yang bisa ditampilkan.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Ujian</th>
                            <th>Mata Pelajaran</th>
                            <th>Waktu Selesai</th>
                            <th class="text-center">Benar / Total</th>
                            <th class="text-center pe-4">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($results as $r): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-dark"><?= e($r->exam_title) ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary"><?= e($r->subject_name ?? 'Umum') ?></span></td>
                            <td><small class="text-muted"><i class="far fa-clock me-1"></i> <?= e($r->finished_time) ?></small></td>
                            <td class="text-center">
                                <?php if($r->show_score): ?>
                                    <span class="text-success fw-bold"><?= $r->correct_count ?></span> / <span class="text-muted"><?= $r->total_questions ?></span>
                                <?php else: ?>
                                    <span class="text-muted"><i class="fas fa-lock"></i> Rahasia</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <?php if($r->show_score): ?>
                                    <?php 
                                        $scoreClass = $r->status === 'passed' ? 'text-success' : 'text-danger';
                                    ?>
                                    <span class="fw-bold fs-5 <?= $scoreClass ?>"><?= number_format($r->score, 1) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark border">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
