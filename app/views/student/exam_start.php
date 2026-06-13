<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : APP_NAME ?></title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/exam.css') ?>">
</head>
<body oncontextmenu="return false;" oncopy="return false;" onpaste="return false;">

    <div class="exam-container">
        <!-- Top Navigation / Header -->
        <header class="exam-header">
            <div class="exam-title">
                <i class="fas fa-map-marker-alt title-icon"></i>
                <h2><?= e($exam->title ?? 'Simulasi Ujian') ?></h2>
            </div>
            <div class="exam-timer" id="timer-container">
                <i class="fas fa-clock"></i>
                <span id="time-left">00:00</span>
            </div>
        </header>

        <div class="exam-layout">
            <!-- Main Content Area -->
            <main class="exam-main-panel glass-panel">
                <div class="question-header">
                    <h3 id="question-number">Soal No. 1</h3>
                    <button class="flag-button" id="flag-btn" onclick="toggleFlag()">
                        <i class="fas fa-flag"></i>
                        <span id="flag-text">Ragu-ragu</span>
                    </button>
                </div>

                <div class="question-content">
                    <div id="question-image" style="display: none; margin-bottom: 24px; text-align: left;">
                        <img src="" alt="Lampiran Soal" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                    </div>
                    <p class="question-text" id="question-text">Memuat soal...</p>

                    <div class="options-list" id="options-list">
                        <!-- Options will be injected here -->
                    </div>
                </div>

                <div class="exam-navigation">
                    <button class="nav-btn btn-secondary" id="btn-prev" onclick="prevQuestion()" disabled>
                        <i class="fas fa-chevron-left"></i>
                        <span>Kembali</span>
                    </button>

                    <button class="nav-btn btn-primary" id="btn-next" onclick="nextQuestion()">
                        <span>Selanjutnya</span>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="nav-btn btn-finish" id="btn-finish" onclick="finishExam()" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Selesai Ujian</span>
                    </button>
                </div>
            </main>

            <!-- Right Sidebar - Number Grid -->
            <div class="mobile-nav-toggle-wrapper">
                <button class="mobile-nav-toggle btn-secondary" onclick="toggleNav()">
                    <span id="nav-toggle-text">Lihat Peta Navigasi Soal</span>
                </button>
            </div>
            
            <aside class="exam-sidebar glass-panel nav-closed" id="exam-sidebar">
                <div class="sidebar-header">
                    <h4>Navigasi Soal</h4>
                    <div class="progress-text" id="progress-text">
                        0 / 0 Dijawab
                    </div>
                </div>

                <div class="question-grid" id="question-grid">
                    <!-- Grid buttons injected here -->
                </div>

                <div class="sidebar-legend">
                    <div class="legend-item">
                        <div class="legend-color color-answered"></div>
                        <span>Sudah Dijawab</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color color-flagged"></div>
                        <span>Ragu-ragu</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color color-default"></div>
                        <span>Belum Dijawab</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color color-active"></div>
                        <span>Sedang Aktif</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Dummy data for testing UI - will be replaced with real data later
        const questions = [
            { id: 1, text: "Apa ibukota Indonesia?", options: ["Jakarta", "Bandung", "Surabaya", "Medan"], type: "multiple_choice" },
            { id: 2, text: "Berapa hasil 5 + 5?", options: ["8", "9", "10", "11"], type: "multiple_choice" },
            { id: 3, text: "Siapa penemu lampu pijar?", options: ["Thomas Edison", "Nikola Tesla", "Albert Einstein", "Isaac Newton"], type: "multiple_choice" }
        ];

        let currentIdx = 0;
        let answers = {};
        let flagged = {};
        let timeLeft = <?= isset($exam->duration_minutes) ? $exam->duration_minutes * 60 : 3600 ?>;
        
        function renderQuestion() {
            if (questions.length === 0) return;
            const q = questions[currentIdx];
            document.getElementById('question-number').innerText = `Soal No. ${currentIdx + 1}`;
            document.getElementById('question-text').innerText = q.text;
            
            // Render Options
            const optionsList = document.getElementById('options-list');
            optionsList.innerHTML = '';
            
            q.options.forEach((opt, idx) => {
                const isSelected = answers[q.id] === idx;
                const optionLabel = String.fromCharCode(65 + idx);
                
                const div = document.createElement('div');
                div.className = `option-item ${isSelected ? 'selected' : ''}`;
                div.style.alignItems = 'flex-start';
                div.onclick = () => selectOption(q.id, idx);
                
                div.innerHTML = `
                    <div class="option-label">${optionLabel}</div>
                    <div class="option-text" style="flex: 1; display: flex; flex-direction: column;">
                        <div>${opt}</div>
                    </div>
                    ${isSelected ? '<i class="fas fa-check-circle check-icon"></i>' : ''}
                `;
                optionsList.appendChild(div);
            });

            // Update Flag
            const flagBtn = document.getElementById('flag-btn');
            const flagText = document.getElementById('flag-text');
            if (flagged[q.id]) {
                flagBtn.classList.add('active');
                flagText.innerText = 'Ragu-ragu (Ditandai)';
            } else {
                flagBtn.classList.remove('active');
                flagText.innerText = 'Ragu-ragu';
            }

            // Navigation Buttons
            document.getElementById('btn-prev').disabled = currentIdx === 0;
            if (currentIdx === questions.length - 1) {
                document.getElementById('btn-next').style.display = 'none';
                document.getElementById('btn-finish').style.display = 'flex';
            } else {
                document.getElementById('btn-next').style.display = 'flex';
                document.getElementById('btn-finish').style.display = 'none';
            }

            renderGrid();
        }

        function selectOption(qId, optIdx) {
            answers[qId] = optIdx;
            renderQuestion();
        }

        function toggleFlag() {
            const qId = questions[currentIdx].id;
            flagged[qId] = !flagged[qId];
            renderQuestion();
        }

        function nextQuestion() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                renderQuestion();
            }
        }

        function prevQuestion() {
            if (currentIdx > 0) {
                currentIdx--;
                renderQuestion();
            }
        }

        function renderGrid() {
            const grid = document.getElementById('question-grid');
            grid.innerHTML = '';
            let answeredCount = 0;

            questions.forEach((q, idx) => {
                const isAnswered = answers[q.id] !== undefined;
                const isFlagged = flagged[q.id];
                const isActive = currentIdx === idx;

                if (isAnswered) answeredCount++;

                let btnClass = "grid-btn";
                if (isActive) btnClass += " active";
                else if (isFlagged) btnClass += " flagged";
                else if (isAnswered) btnClass += " answered";
                else btnClass += " default";

                const btn = document.createElement('button');
                btn.className = btnClass;
                btn.onclick = () => { currentIdx = idx; renderQuestion(); };
                btn.innerHTML = `
                    ${idx + 1}
                    ${isFlagged ? '<div class="indicator-dot flag-dot"></div>' : ''}
                `;
                grid.appendChild(btn);
            });

            document.getElementById('progress-text').innerText = `${answeredCount} / ${questions.length} Dijawab`;
        }

        function finishExam() {
            Swal.fire({
                title: 'Selesai Ujian?',
                text: 'Apakah Anda yakin ingin menyelesaikan ujian ini? Jawaban tidak dapat diubah lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Selesai Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Logic submit here
                    Swal.fire('Berhasil', 'Jawaban berhasil disimpan!', 'success').then(() => {
                        window.location.href = '<?= url("student/history") ?>';
                    });
                }
            });
        }

        function toggleNav() {
            const sidebar = document.getElementById('exam-sidebar');
            const toggleText = document.getElementById('nav-toggle-text');
            if (sidebar.classList.contains('nav-closed')) {
                sidebar.classList.remove('nav-closed');
                sidebar.classList.add('nav-open');
                toggleText.innerText = 'Tutup Peta Navigasi Soal';
            } else {
                sidebar.classList.remove('nav-open');
                sidebar.classList.add('nav-closed');
                toggleText.innerText = 'Lihat Peta Navigasi Soal';
            }
        }

        // Timer
        const timerElement = document.getElementById('time-left');
        const timerContainer = document.getElementById('timer-container');
        setInterval(() => {
            if (timeLeft <= 0) return;
            timeLeft--;
            
            const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
            const s = (timeLeft % 60).toString().padStart(2, '0');
            timerElement.innerText = `${m}:${s}`;
            
            if (timeLeft < 300) {
                timerContainer.classList.add('timer-warning');
            }
            if (timeLeft === 0) {
                // Time up logic
                Swal.fire('Waktu Habis', 'Ujian Anda akan dikumpulkan otomatis.', 'info').then(() => {
                    window.location.href = '<?= url("student/history") ?>';
                });
            }
        }, 1000);

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            renderQuestion();
        });
    </script>
</body>
</html>
