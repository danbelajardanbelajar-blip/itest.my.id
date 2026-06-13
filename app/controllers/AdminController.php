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
            'avg_score' => 0.0, // Placeholder
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
        $data = [
            'title' => 'Hasil Ujian - ' . APP_NAME,
        ];
        $this->view('admin/results', $data);
    }

    public function staff() {
        $data = [
            'title' => 'Manajemen Pegawai - ' . APP_NAME,
        ];
        $this->view('admin/staff', $data);
    }

    public function schools() {
        $data = [
            'title' => 'Data Lembaga - ' . APP_NAME,
        ];
        $this->view('admin/schools', $data);
    }

    public function rooms() {
        $data = [
            'title' => 'Data Ruangan - ' . APP_NAME,
        ];
        $this->view('admin/rooms', $data);
    }

    public function classes() {
        $data = [
            'title' => 'Data Kelas - ' . APP_NAME,
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

    // --- API Endpoints ---

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
            $data = [
                'subject_id' => $_POST['subject_id'] ?? 1,
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'question_text' => $_POST['question_text'] ?? '',
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
}
