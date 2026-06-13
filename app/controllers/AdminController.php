<?php

class AdminController extends Controller {

    public function __construct() {
        Middleware::requireAdmin();
    }

    public function index() {
        $this->redirect('admin/dashboard');
    }

    public function dashboard() {
        // Fetch some basic stats (Placeholder)
        $data = [
            'title' => 'Dashboard Admin - ' . APP_NAME,
            'total_students' => count($this->model('Student')->getAll()),
            'total_exams' => count($this->model('Exam')->getAll()),
            'active_exams' => 1
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
