<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Ujian Sedang Berlangsung' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body class="bg-light">

    <!-- Sticky Exam Header -->
    <div class="exam-header shadow-sm d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold"><?= e($exam->title ?? 'Ujian') ?></h5>
            <small class="text-muted"><?= e(Auth::user()->name) ?> - <?= e($exam->subject_name ?? 'Mata Pelajaran') ?></small>
        </div>
        <div class="text-end">
            <div class="badge bg-danger fs-5 px-3 py-2" id="exam-timer">
                <i class="fas fa-clock me-2"></i> <span id="time-display">00:00:00</span>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4" id="app-content">
        <div class="row">
            <!-- Left Panel: Question -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between">
                        <h6 class="fw-bold mb-0">Soal No. <span id="current-question-no" class="fs-5">1</span></h6>
                        <div><i class="fas fa-text-height text-muted" role="button" title="Ubah Ukuran Teks"></i></div>
                    </div>
                    <div class="card-body fs-5" id="question-text-container">
                        <!-- Placeholder Question -->
                        <p>Ini adalah contoh teks soal ujian CBT yang sangat panjang dan butuh ketelitian untuk dibaca. Pilihlah satu jawaban yang paling tepat di bawah ini.</p>
                        
                        <div class="mt-4">
                            <div class="form-check mb-3 p-3 border rounded choice-item">
                                <input class="form-check-input ms-0 me-3 mt-1" type="radio" name="answer" id="choiceA" value="A">
                                <label class="form-check-label w-100 stretched-link" for="choiceA">
                                    A. Ini adalah contoh pilihan jawaban A
                                </label>
                            </div>
                            <div class="form-check mb-3 p-3 border rounded choice-item">
                                <input class="form-check-input ms-0 me-3 mt-1" type="radio" name="answer" id="choiceB" value="B">
                                <label class="form-check-label w-100 stretched-link" for="choiceB">
                                    B. Ini adalah contoh pilihan jawaban B
                                </label>
                            </div>
                            <div class="form-check mb-3 p-3 border rounded choice-item">
                                <input class="form-check-input ms-0 me-3 mt-1" type="radio" name="answer" id="choiceC" value="C">
                                <label class="form-check-label w-100 stretched-link" for="choiceC">
                                    C. Ini adalah contoh pilihan jawaban C
                                </label>
                            </div>
                            <div class="form-check mb-3 p-3 border rounded choice-item">
                                <input class="form-check-input ms-0 me-3 mt-1" type="radio" name="answer" id="choiceD" value="D">
                                <label class="form-check-label w-100 stretched-link" for="choiceD">
                                    D. Ini adalah contoh pilihan jawaban D
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white pt-0 pb-4 border-top-0 d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary px-4"><i class="fas fa-chevron-left me-2"></i> Sebelumnya</button>
                        <button class="btn btn-warning px-4 text-dark"><input type="checkbox" class="form-check-input me-2"> Ragu-ragu</button>
                        <button class="btn btn-primary px-4">Selanjutnya <i class="fas fa-chevron-right ms-2"></i></button>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Navigation Grid -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="fw-bold mb-0">Navigasi Soal</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-start" id="question-nav-grid">
                            <!-- Placeholder Nav Buttons -->
                            <?php for($i=1; $i<=25; $i++): ?>
                                <?php 
                                    $class = '';
                                    if($i==1) $class = 'active';
                                    if($i==2 || $i==3) $class = 'answered';
                                    if($i==5) $class = 'doubtful';
                                ?>
                                <button class="question-nav-btn <?= $class ?>"><?= $i ?></button>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex flex-column gap-2 pb-4">
                        <div class="d-flex align-items-center small mb-2 text-muted">
                            <span class="d-inline-block bg-success rounded me-2" style="width: 15px; height: 15px;"></span> Sudah Dijawab
                            <span class="d-inline-block bg-warning rounded ms-3 me-2" style="width: 15px; height: 15px;"></span> Ragu-ragu
                            <span class="d-inline-block bg-white border rounded ms-3 me-2" style="width: 15px; height: 15px;"></span> Belum Dijawab
                        </div>
                        <button class="btn btn-danger w-100 fw-bold mt-2"><i class="fas fa-paper-plane me-2"></i> Selesai Ujian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .choice-item:hover {
            background-color: #f8f9fa;
        }
        .choice-item:has(input:checked) {
            background-color: #e7f1ff;
            border-color: #0d6efd !important;
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fake Timer for visual demonstration
        let remainingSeconds = 3600; // 1 hour
        setInterval(() => {
            if(remainingSeconds > 0) remainingSeconds--;
            let h = Math.floor(remainingSeconds / 3600).toString().padStart(2, '0');
            let m = Math.floor((remainingSeconds % 3600) / 60).toString().padStart(2, '0');
            let s = (remainingSeconds % 60).toString().padStart(2, '0');
            document.getElementById('time-display').innerText = `${h}:${m}:${s}`;
        }, 1000);
    </script>
</body>
</html>
