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
}
