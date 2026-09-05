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
}
