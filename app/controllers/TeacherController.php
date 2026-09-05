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
    public function exams() {
        $data = ['title' => 'Manajemen Ujian - ' . APP_NAME];
        // Placeholder
        echo "<h1>Fitur Manajemen Ujian (Guru) Segera Hadir</h1>";
    }

    public function questions() {
        $data = ['title' => 'Bank Soal - ' . APP_NAME];
        // Placeholder
        echo "<h1>Fitur Bank Soal (Guru) Segera Hadir</h1>";
    }

    public function results() {
        $data = ['title' => 'Laporan Nilai - ' . APP_NAME];
        // Placeholder
        echo "<h1>Fitur Laporan Nilai (Guru) Segera Hadir</h1>";
    }
}
