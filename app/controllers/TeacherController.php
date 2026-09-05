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
        
        $data = [
            'title' => 'Dashboard Guru - ' . APP_NAME,
            'user' => Auth::user(),
            'teacher' => $teacher
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
