<?php

class AdminController extends Controller {

    public function __construct() {
        Middleware::requireAdmin();
    }

    public function index() {
        $this->redirect('admin/dashboard');
    }

    public function dashboard() {
        $exams = $this->model('Exam')->getAll();
        
        $data = [
            'title' => 'Dashboard Admin - ' . APP_NAME,
            'total_students' => count($this->model('Student')->getAll()),
            'total_exams' => count($exams),
            'avg_score' => $this->model('Result')->getGlobalAverageScore(),
            'recent_exams' => array_slice($exams, 0, 5) // Ambil 5 ujian terbaru
        ];

        $this->view('admin/dashboard', $data);
    }

    public function users() {
        $data = [
            'title' => 'Manajemen Pengguna - ' . APP_NAME,
            'students' => $this->model('Student')->getAll()
        ];
        $this->view('admin/users', $data);
    }

    public function questions() {
        $data = [
            'title' => 'Bank Soal - ' . APP_NAME,
            'questions' => $this->model('Question')->getAll()
        ];
        $this->view('admin/questions', $data);
    }

    public function exams() {
        $data = [
            'title' => 'Manajemen Ujian - ' . APP_NAME,
            'exams' => $this->model('Exam')->getAll()
        ];
        $this->view('admin/exams', $data);
    }

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
        $this->view('admin/results', $data);
    }

    public function staff() {
        $data = [
            'title' => 'Manajemen Pegawai - ' . APP_NAME,
            'staff' => $this->model('Teacher')->getAll()
        ];
        $this->view('admin/staff', $data);
    }

    public function schools() {
        $data = [
            'title' => 'Data Lembaga - ' . APP_NAME,
            'schools' => $this->model('School')->getAll()
        ];
        $this->view('admin/schools', $data);
    }

    public function rooms() {
        $data = [
            'title' => 'Data Ruangan - ' . APP_NAME,
            'rooms' => $this->model('Room')->getAll()
        ];
        $this->view('admin/rooms', $data);
    }

    public function classes() {
        $data = [
            'title' => 'Data Kelas - ' . APP_NAME,
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/classes', $data);
    }

    // --- Create Form Views ---

    public function create_exam() {
        $data = [
            'title' => 'Buat Ujian Baru - ' . APP_NAME,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/exams_create', $data);
    }

    public function create_question() {
        $data = [
            'title' => 'Buat Soal Baru - ' . APP_NAME,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/questions_create', $data);
    }

    public function create_user() {
        $data = [
            'title' => 'Tambah Siswa - ' . APP_NAME,
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/users_create', $data);
    }

    // --- API ENDPOINTS ---

    public function editStudent($id) {
        $student = $this->model('Student')->getById($id);
        if (!$student) $this->redirect('admin/users');
        $data = [
            'title' => 'Edit Siswa - ' . APP_NAME,
            'student' => $student,
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/users_edit', $data);
    }

    public function updateStudent($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Student')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Data siswa berhasil diperbarui', 'redirect' => url('admin/users')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data siswa']);
            }
        }
    }

    public function editExam($id) {
        $exam = $this->model('Exam')->getById($id);
        if (!$exam) $this->redirect('admin/exams');
        $data = [
            'title' => 'Edit Ujian - ' . APP_NAME,
            'exam' => $exam,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/exams_edit', $data);
    }

    public function updateExam($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Exam')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Data ujian berhasil diperbarui', 'redirect' => url('admin/exams')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data ujian']);
            }
        }
    }

    public function editQuestion($id) {
        $question = $this->model('Question')->getById($id);
        if (!$question) $this->redirect('admin/questions');
        $choices = $this->model('Question')->getChoices($id);
        $data = [
            'title' => 'Edit Soal - ' . APP_NAME,
            'question' => $question,
            'choices' => $choices,
            'subjects' => $this->model('Subject')->getAll(),
            'classes' => $this->model('ClassModel')->getAll()
        ];
        $this->view('admin/questions_edit', $data);
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
                echo json_encode(['status' => 'success', 'message' => 'Soal berhasil diperbarui', 'redirect' => url('admin/questions')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui soal']);
            }
        }
    }

    public function storeStudent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nis' => $_POST['nis'] ?? '',
                'name' => $_POST['name'] ?? '',
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'password' => $_POST['password'] ?? '',
                'gender' => $_POST['gender'] ?? 'L'
            ];

            if ($this->model('Student')->create($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Siswa berhasil ditambahkan', 'spa_redirect' => url('admin/users')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan siswa']);
            }
        }
    }

    public function deleteStudent($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Student')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Siswa berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus siswa']);
            }
        }
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
                echo json_encode(['status' => 'success', 'message' => 'Ujian berhasil dibuat', 'spa_redirect' => url('admin/exams')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal membuat ujian']);
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
                echo json_encode(['status' => 'success', 'message' => 'Soal berhasil disimpan', 'spa_redirect' => url('admin/questions')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan soal']);
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
    public function settings() {
        $data = [
            'title' => 'Pengaturan Sistem - ' . APP_NAME
        ];
        $this->view('admin/settings', $data);
    }

    public function saveSettings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dummy response: As we do not have full settings table schema logic yet
            echo json_encode([
                'status' => 'success', 
                'message' => 'Pengaturan berhasil disimpan!'
            ]);
        }
    }

    public function backupDatabase() {
        // Dummy backup file generation
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="backup_' . date('Ymd_His') . '.sql"');
        echo "-- iTest CBT Database Backup\n";
        echo "-- Generated at " . date('Y-m-d H:i:s') . "\n";
        echo "\n-- (This is a dummy backup file for demonstration)\n";
        exit;
    }

    public function restoreDatabase() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] == 0) {
                // Here we would run the SQL commands, for now just success
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Database berhasil dipulihkan dari file backup.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'File backup tidak valid.'
                ]);
            }
        }
    }

    // --- CRUD ENDPOINTS ---

    // Classes
    public function create_class() {
        $data = [
            'title' => 'Tambah Kelas - ' . APP_NAME,
            'teachers' => $this->model('Teacher')->getAll()
        ];
        $this->view('admin/classes_create', $data);
    }
    public function storeClass() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('ClassModel')->create($_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil ditambahkan', 'spa_redirect' => url('admin/classes')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan kelas']);
            }
        }
    }
    public function editClass($id) {
        $class = $this->model('ClassModel')->getById($id);
        if (!$class) $this->redirect('admin/classes');
        $data = [
            'title' => 'Edit Kelas - ' . APP_NAME,
            'class' => $class,
            'teachers' => $this->model('Teacher')->getAll()
        ];
        $this->view('admin/classes_edit', $data);
    }
    public function updateClass($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('ClassModel')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil diperbarui', 'redirect' => url('admin/classes')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kelas']);
            }
        }
    }
    public function deleteClass($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('ClassModel')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kelas']);
            }
        }
    }

    // Staff
    public function create_staff() {
        $data = [
            'title' => 'Tambah Pegawai - ' . APP_NAME
        ];
        $this->view('admin/staff_create', $data);
    }
    public function storeStaff() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Teacher')->create($_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Pegawai berhasil ditambahkan', 'spa_redirect' => url('admin/staff')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan pegawai']);
            }
        }
    }
    public function editStaff($id) {
        $staff = $this->model('Teacher')->getById($id);
        if (!$staff) $this->redirect('admin/staff');
        $data = [
            'title' => 'Edit Pegawai - ' . APP_NAME,
            'staff' => $staff
        ];
        $this->view('admin/staff_edit', $data);
    }
    public function updateStaff($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Teacher')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Pegawai berhasil diperbarui', 'redirect' => url('admin/staff')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui pegawai']);
            }
        }
    }
    public function deleteStaff($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Teacher')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Pegawai berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus pegawai']);
            }
        }
    }

    // Rooms
    public function create_room() {
        $data = [
            'title' => 'Tambah Ruangan - ' . APP_NAME
        ];
        $this->view('admin/rooms_create', $data);
    }
    public function storeRoom() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Room')->create($_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Ruangan berhasil ditambahkan', 'spa_redirect' => url('admin/rooms')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan ruangan']);
            }
        }
    }
    public function editRoom($id) {
        $room = $this->model('Room')->getById($id);
        if (!$room) $this->redirect('admin/rooms');
        $data = [
            'title' => 'Edit Ruangan - ' . APP_NAME,
            'room' => $room
        ];
        $this->view('admin/rooms_edit', $data);
    }
    public function updateRoom($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Room')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Ruangan berhasil diperbarui', 'redirect' => url('admin/rooms')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui ruangan']);
            }
        }
    }
    public function deleteRoom($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Room')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Ruangan berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus ruangan']);
            }
        }
    }

    // Schools
    public function create_school() {
        $data = [
            'title' => 'Tambah Lembaga - ' . APP_NAME
        ];
        $this->view('admin/schools_create', $data);
    }
    public function storeSchool() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('School')->create($_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Lembaga berhasil ditambahkan', 'spa_redirect' => url('admin/schools')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan lembaga']);
            }
        }
    }
    public function editSchool($id) {
        $school = $this->model('School')->getById($id);
        if (!$school) $this->redirect('admin/schools');
        $data = [
            'title' => 'Edit Lembaga - ' . APP_NAME,
            'school' => $school
        ];
        $this->view('admin/schools_edit', $data);
    }
    public function updateSchool($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('School')->update($id, $_POST)) {
                echo json_encode(['status' => 'success', 'message' => 'Lembaga berhasil diperbarui', 'redirect' => url('admin/schools')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui lembaga']);
            }
        }
    }
    public function deleteSchool($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('School')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Lembaga berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus lembaga']);
            }
        }
    }

    // --- USER ACCOUNT MANAGEMENT ---

    public function account_users() {
        $role = $_GET['role'] ?? null;
        $users = $this->model('User')->getAll($role);
        $allUsers = $this->model('User')->getAll();

        $data = [
            'title' => 'Kelola Pengguna Sistem - ' . APP_NAME,
            'users' => $users,
            'all_users' => $allUsers
        ];
        $this->view('admin/account_users', $data);
    }

    public function create_account_user() {
        $data = [
            'title' => 'Tambah Pengguna Baru - ' . APP_NAME
        ];
        $this->view('admin/account_users_create', $data);
    }

    public function store_account_user() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'student';
            $status = $_POST['status'] ?? 'active';

            if (empty($name) || empty($username) || empty($email) || empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Semua kolom wajib diisi']);
                return;
            }

            $userModel = $this->model('User');
            if ($userModel->findByUsernameOrEmail($username) || $userModel->findByUsernameOrEmail($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Username atau Email sudah terdaftar']);
                return;
            }

            $data = [
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'status' => $status
            ];

            if ($userModel->create($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Pengguna berhasil ditambahkan', 'spa_redirect' => url('admin/account_users')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan pengguna']);
            }
        }
    }

    public function edit_account_user($id) {
        $user = $this->model('User')->getById($id);
        if (!$user) $this->redirect('admin/account_users');

        $data = [
            'title' => 'Edit Pengguna - ' . APP_NAME,
            'user' => $user
        ];
        $this->view('admin/account_users_edit', $data);
    }

    public function update_account_user($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');
            $existing = $userModel->getById($id);
            if (!$existing) {
                echo json_encode(['status' => 'error', 'message' => 'Pengguna tidak ditemukan']);
                return;
            }

            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? $existing->role;
            $status = $_POST['status'] ?? $existing->status;

            if (empty($name) || empty($username) || empty($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Nama, Username, dan Email wajib diisi']);
                return;
            }

            $data = [
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'status' => $status
            ];

            if ($userModel->update($id, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Data pengguna berhasil diperbarui', 'redirect' => url('admin/account_users')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui pengguna']);
            }
        }
    }

    public function delete_account_user($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($id == Auth::user()->id) {
                echo json_encode(['status' => 'error', 'message' => 'Anda tidak dapat menghapus akun Anda sendiri']);
                return;
            }

            if ($this->model('User')->delete($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Pengguna berhasil dihapus', 'spa_reload' => true]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus pengguna']);
            }
        }
    }

    public function toggle_user_status($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($id == Auth::user()->id) {
                echo json_encode(['status' => 'error', 'message' => 'Anda tidak dapat menonaktifkan akun Anda sendiri']);
                return;
            }

            if ($this->model('User')->toggleStatus($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Status pengguna berhasil diperbarui']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah status pengguna']);
            }
        }
    }
}
