<?php

class StudentController extends Controller {

    public function __construct() {
        Middleware::requireStudent();
    }

    public function index() {
        $this->redirect('student/dashboard');
    }

    public function dashboard() {
        $student = $this->model('Student')->getById(Auth::user()->id);
        $upcoming_exams = $student ? $this->model('Exam')->getActiveForStudent($student->id) : [];

        $data = [
            'title' => 'Dashboard Siswa - ' . APP_NAME,
            'user' => Auth::user(),
            'upcoming_exams' => $upcoming_exams
        ];

        $this->view('student/dashboard', $data);
    }

    public function exams() {
        $student = $this->model('Student')->getById(Auth::user()->id);
        $upcoming_exams = $student ? $this->model('Exam')->getActiveForStudent($student->id) : [];

        $data = [
            'title' => 'Ujian Tersedia - ' . APP_NAME,
            'upcoming_exams' => $upcoming_exams
        ];
        $this->view('student/exams', $data);
    }

    public function history() {
        $student = $this->model('Student')->getById(Auth::user()->id);
        $results = $student ? $this->model('Result')->getStudentHistory($student->id) : [];

        $data = [
            'title' => 'Riwayat Ujian - ' . APP_NAME,
            'results' => $results
        ];
        $this->view('student/history', $data);
    }
    public function exam_start($id = null) {
        if (!$id) $this->redirect('student/exams');
        
        $exam = $this->model('Exam')->getById($id);
        if (!$exam) {
            $this->redirect('student/exams');
        }

        $student = $this->model('Student')->getById(Auth::user()->id);
        if (!$student) {
            $this->redirect('student/dashboard');
        }

        $examSession = clone $this->model('ExamSession');
        $session = $examSession->getActiveSession($id, $student->id);

        if (!$session) {
            // Check if already finished
            $this->db = new Database();
            $this->db->query("SELECT id FROM results WHERE exam_id = :exam_id AND student_id = :student_id");
            $this->db->bind(':exam_id', $id);
            $this->db->bind(':student_id', $student->id);
            if ($this->db->single()) {
                // Already taken
                $this->redirect('student/history');
            }

            // Start new session
            $sessionId = $examSession->startSession($id, $student->id, $exam->duration_minutes);
            $session = $examSession->getActiveSession($id, $student->id); // re-fetch to get object
        }

        $data = [
            'title' => 'Mengerjakan Ujian - ' . APP_NAME,
            'exam' => $exam,
            'session' => $session
        ];
        
        $this->view('student/exam_start', $data);
    }

    public function getQuestions($examId) {
        $student = $this->model('Student')->getById(Auth::user()->id);
        $session = $this->model('ExamSession')->getActiveSession($examId, $student->id);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Sesi tidak ditemukan']);
            return;
        }

        $questions = $this->model('Question')->getForExam($examId);
        $answers = $this->model('ExamSession')->getAnswers($session->id);
        
        // Format answers into a dictionary for easy lookup
        $ansDict = [];
        $flagDict = [];
        foreach($answers as $a) {
            $ansDict[$a->question_id] = $a->selected_choice_id;
            $flagDict[$a->question_id] = $a->is_doubtful ? true : false;
        }

        $formattedQuestions = [];
        foreach($questions as $q) {
            $choices = $this->model('Question')->getChoices($q->id);
            
            // Randomize choices if exam setting says so
            // We need to fetch exam random_choices setting
            $exam = $this->model('Exam')->getById($examId);
            if ($exam && $exam->random_choices) {
                shuffle($choices);
            }

            $formattedOptions = [];
            foreach($choices as $c) {
                $formattedOptions[] = [
                    'id' => $c->id,
                    'text' => $c->choice_text
                ];
            }

            $formattedQuestions[] = [
                'id' => $q->id,
                'text' => $q->question_text,
                'image' => $q->question_image ? asset('uploads/' . $q->question_image) : null,
                'options' => $formattedOptions,
                'selected_option_id' => $ansDict[$q->id] ?? null,
                'is_flagged' => $flagDict[$q->id] ?? false
            ];
        }

        echo json_encode([
            'status' => 'success',
            'questions' => $formattedQuestions,
            'remaining_seconds' => $session->remaining_seconds
        ]);
    }

    public function saveAnswer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examId = $_POST['exam_id'] ?? null;
            $questionId = $_POST['question_id'] ?? null;
            $choiceId = $_POST['choice_id'] ?? null; // Can be null if deselecting (optional)
            
            $student = $this->model('Student')->getById(Auth::user()->id);
            $session = $this->model('ExamSession')->getActiveSession($examId, $student->id);

            if ($session) {
                if ($this->model('ExamSession')->saveAnswer($session->id, $questionId, $choiceId)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Sesi ujian tidak valid']);
            }
        }
    }

    public function setFlag() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examId = $_POST['exam_id'] ?? null;
            $questionId = $_POST['question_id'] ?? null;
            $isDoubtful = isset($_POST['is_doubtful']) && $_POST['is_doubtful'] === 'true';
            
            $student = $this->model('Student')->getById(Auth::user()->id);
            $session = $this->model('ExamSession')->getActiveSession($examId, $student->id);

            if ($session) {
                $this->model('ExamSession')->setFlag($session->id, $questionId, $isDoubtful);
                echo json_encode(['status' => 'success']);
            }
        }
    }

    public function updateTimer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examId = $_POST['exam_id'] ?? null;
            $remaining = (int)($_POST['remaining'] ?? 0);
            
            $student = $this->model('Student')->getById(Auth::user()->id);
            $session = $this->model('ExamSession')->getActiveSession($examId, $student->id);

            if ($session) {
                // Ensure remaining time doesn't drastically increase (basic anti-cheat)
                if ($remaining <= $session->remaining_seconds) {
                    $this->model('ExamSession')->updateRemainingTime($session->id, $remaining);
                }
                echo json_encode(['status' => 'success']);
            }
        }
    }

    public function finishExam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examId = $_POST['exam_id'] ?? null;
            
            $student = $this->model('Student')->getById(Auth::user()->id);
            $session = $this->model('ExamSession')->getActiveSession($examId, $student->id);

            if ($session) {
                // Kalkulasi skor dan simpan ke result
                $this->model('ExamSession')->calculateAndSaveResult($session->id, $examId, $student->id);
                // Tandai session selesai
                $this->model('ExamSession')->finishSession($session->id);

                echo json_encode(['status' => 'success', 'redirect' => url('student/history')]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Sesi tidak ditemukan atau sudah selesai']);
            }
        }
    }
}
