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
        $data = [
            'title' => 'Riwayat Ujian - ' . APP_NAME
        ];
        $this->view('student/history', $data);
    }
    public function exam_start($id = null) {
        if (!$id) $this->redirect('student/exams');
        
        $exam = $this->model('Exam')->getById($id) ?? (object)['title' => 'Simulasi Ujian', 'subject_name' => 'Simulasi', 'duration_minutes' => 60];

        $data = [
            'title' => 'Mengerjakan Ujian - ' . APP_NAME,
            'exam' => $exam
        ];
        
        // Render view langsung tanpa layout biasa karena ujian punya layout sendiri
        $this->view('student/exam_start', $data);
    }
}
