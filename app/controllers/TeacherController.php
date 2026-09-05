<?php

class TeacherController extends Controller {

    public function __construct() {
        Middleware::requireTeacher();
    }

    public function index() {
        $this->redirect('teacher/dashboard');
    }

    public function dashboard() {
        $teacher = $this->model('Teacher')->getByUserId(Auth::user()->id);
        $exams = $this->model('Exam')->getAll();
        
        $data = [
            'title' => 'Dashboard Guru - ' . APP_NAME,
            'user' => Auth::user(),
            'teacher' => $teacher,
            'total_students' => count($this->model('Student')->getAll()),
            'total_exams' => count($exams),
            'avg_score' => $this->model('Result')->getGlobalAverageScore(),
            'recent_exams' => array_slice($exams, 0, 5)
        ];

        $this->view('teacher/dashboard', $data);
    }

    // ==================== EXAM MANAGEMENT ====================

    public function exams() {
        $data = [
            'title' => 'Manajemen Ujian - ' . APP_NAME,
            'exams' => $this->model('Exam')->getAll()
        ];
        $this->view('teacher/exams', $data);
    }

    public function create_exam() {
        $data = [
            'title' => 'Buat Ujian Baru - ' . APP_NAME,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('teacher/exams_create', $data);
    }

    public function storeExam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'subject_id' => $_POST['subject_id'] ?? 1,
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'start_time' => $_POST['start_time'] ?? date('Y-m-d H:i:s'),
                'end_time' => $_POST['end_time'] ?? date('Y-m-d H:i:s', strtotime('+1 day')),
                'duration_minutes' => $_POST['duration_minutes'] ?? 60,
                'total_questions' => $_POST['total_questions'] ?? 0,
                'passing_score' => $_POST['passing_score'] ?? 70,
                'status' => $_POST['status'] ?? 'draft'
            ];

            if ($this->model('Exam')->create($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Ujian berhasil dibuat', 'spa_redirect' => url('teacher/exams')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal membuat ujian']);
            }
        }
    }

    public function editExam($id) {
        $exam = $this->model('Exam')->getById($id);
        if (!$exam) $this->redirect('teacher/exams');
        $data = [
            'title' => 'Edit Ujian - ' . APP_NAME,
            'exam' => $exam,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('teacher/exams_edit', $data);
    }

    public function updateExam($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Exam')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Data ujian berhasil diperbarui', 'redirect' => url('teacher/exams')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data ujian']);
            }
        }
    }

    public function deleteExam($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Exam')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Ujian berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus ujian']);
            }
        }
    }

    // ==================== QUESTION BANK ====================

    public function questions() {
        $data = [
            'title' => 'Bank Soal - ' . APP_NAME,
            'questions' => $this->model('Question')->getAll()
        ];
        $this->view('teacher/questions', $data);
    }

    public function create_question() {
        $data = [
            'title' => 'Buat Soal Baru - ' . APP_NAME,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('teacher/questions_create', $data);
    }

    public function storeQuestion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageName = null;
            if (isset($_FILES['question_image']) && $_FILES['question_image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['question_image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed) && $_FILES['question_image']['size'] <= 2097152) { // 2MB
                    $uploadDir = BASE_PATH . '/public/uploads/questions/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $imageName = time() . '_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['question_image']['tmp_name'], $uploadDir . $imageName);
                }
            }

            $data = [
                'subject_id' => $_POST['subject_id'] ?? 1,
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'question_text' => $_POST['question_text'] ?? '',
                'question_image' => $imageName,
                'question_type' => 'multiple_choice'
            ];

            // Format choices
            $choices = [];
            $options = $_POST['options'] ?? [];
            $correctOption = $_POST['correct_option'] ?? 0;
            
            foreach ($options as $index => $text) {
                if (!empty(trim($text))) {
                    $choices[] = [
                        'text' => $text,
                        'is_correct' => ($index == $correctOption)
                    ];
                }
            }

            if ($this->model('Question')->create($data, $choices)) {
                echo json_encode(['status' => 'success', 'message' => 'Soal berhasil disimpan', 'spa_redirect' => url('teacher/questions')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan soal']);
            }
        }
    }

    public function editQuestion($id) {
        $question = $this->model('Question')->getById($id);
        if (!$question) $this->redirect('teacher/questions');
        $choices = $this->model('Question')->getChoices($id);
        $data = [
            'title' => 'Edit Soal - ' . APP_NAME,
            'question' => $question,
            'choices' => $choices,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('teacher/questions_edit', $data);
    }

    public function updateQuestion($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $questionModel = $this->model('Question');
            $existingQuestion = $questionModel->getById($id);
            $imageName = $existingQuestion->question_image;

            $uploadDir = BASE_PATH . '/public/uploads/questions/';
            
            if (!empty($_POST['remove_image']) && $_POST['remove_image'] == '1') {
                if ($imageName && file_exists($uploadDir . $imageName)) {
                    unlink($uploadDir . $imageName);
                }
                $imageName = null;
            }

            if (isset($_FILES['question_image']) && $_FILES['question_image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['question_image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed) && $_FILES['question_image']['size'] <= 2097152) { // 2MB
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $newImageName = time() . '_' . uniqid() . '.' . $ext;
                    if (move_uploaded_file($_FILES['question_image']['tmp_name'], $uploadDir . $newImageName)) {
                        // Delete old image
                        if ($imageName && file_exists($uploadDir . $imageName)) {
                            unlink($uploadDir . $imageName);
                        }
                        $imageName = $newImageName;
                    }
                }
            }

            $data = [
                'subject_id' => $_POST['subject_id'],
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'question_text' => $_POST['question_text'],
                'question_image' => $imageName
            ];

            $options = $_POST['options'] ?? [];
            $correctOptionIndex = $_POST['correct_option'] ?? 0;

            $choices = [];
            foreach ($options as $index => $text) {
                if (!empty(trim($text))) {
                    $choices[] = [
                        'text' => trim($text),
                        'is_correct' => ($index == $correctOptionIndex)
                    ];
                }
            }

            if ($this->model('Question')->update($id, $data, $choices)) {
                echo json_encode(['status' => 'success', 'message' => 'Soal berhasil diperbarui', 'redirect' => url('teacher/questions')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui soal']);
            }
        }
    }

    public function deleteQuestion($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Question')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Soal berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus soal']);
            }
        }
    }

    // ==================== RESULTS & ANALYTICS ====================

    public function results() {
        $aggregates = $this->model('Result')->getExamAggregates();
        $totalParticipants = 0;
        $sumAvg = 0;
        $maxGlobal = 0;
        $minGlobal = 100;
        $examWithResults = 0;

        foreach ($aggregates as $agg) {
            $totalParticipants += $agg->participant_count;
            if ($agg->participant_count > 0) {
                $sumAvg += $agg->average_score;
                if ($agg->max_score > $maxGlobal) $maxGlobal = $agg->max_score;
                if ($agg->min_score < $minGlobal) $minGlobal = $agg->min_score;
                $examWithResults++;
            }
        }

        $globalAvg = $examWithResults > 0 ? ($sumAvg / $examWithResults) : 0;
        if ($minGlobal == 100 && $examWithResults == 0) $minGlobal = 0;

        $data = [
            'title' => 'Laporan Nilai - ' . APP_NAME,
            'aggregates' => $aggregates,
            'stats' => [
                'total_participants' => $totalParticipants,
                'global_avg' => $globalAvg,
                'max_global' => $maxGlobal,
                'min_global' => $minGlobal
            ]
        ];
        $this->view('teacher/results', $data);
    }

    public function exportExcel($examId) {
        $vendorPath = realpath(__DIR__ . '/../../../../vendor/autoload.php') ?: realpath(__DIR__ . '/../../../vendor/autoload.php') ?: '../vendor/autoload.php';
        
        if (file_exists($vendorPath)) {
            require_once $vendorPath;
        } else {
            die("Library PhpSpreadsheet (vendor/autoload.php) tidak ditemukan. Pastikan sudah di-install di public_html/vendor.");
        }

        $exam = $this->model('Exam')->getById($examId);
        if (!$exam) die("Ujian tidak ditemukan.");

        $results = $this->model('Result')->getResultsByExam($examId);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'HASIL UJIAN: ' . strtoupper($exam->title));
        $sheet->setCellValue('A2', 'MATA PELAJARAN: ' . strtoupper($exam->subject_name ?? 'Umum'));
        $sheet->setCellValue('A3', 'KELAS: ' . strtoupper($exam->class_name ?? 'Semua Kelas'));
        $sheet->setCellValue('A4', 'TANGGAL EXPORT: ' . date('d-m-Y H:i:s'));

        // Table Head
        $row = 6;
        $sheet->setCellValue('A' . $row, 'NO');
        $sheet->setCellValue('B' . $row, 'NIS');
        $sheet->setCellValue('C' . $row, 'NAMA SISWA');
        $sheet->setCellValue('D' . $row, 'KELAS');
        $sheet->setCellValue('E' . $row, 'BENAR');
        $sheet->setCellValue('F' . $row, 'SALAH / KOSONG');
        $sheet->setCellValue('G' . $row, 'NILAI AKHIR');
        $sheet->setCellValue('H' . $row, 'STATUS');

        // Data
        $row++;
        $no = 1;
        foreach ($results as $res) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $res->nis);
            $sheet->setCellValue('C' . $row, $res->student_name);
            $sheet->setCellValue('D' . $row, $res->class_name ?? '-');
            $sheet->setCellValue('E' . $row, $res->correct_count);
            $sheet->setCellValue('F' . $row, $res->total_questions - $res->correct_count);
            $sheet->setCellValue('G' . $row, $res->score);
            $sheet->setCellValue('H' . $row, $res->status == 'passed' ? 'LULUS' : 'TIDAK LULUS');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Hasil_Ujian_' . str_replace(' ', '_', $exam->title) . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
        $writer->save('php://output');
        exit;
    }
}
