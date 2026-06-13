<?php

class AuthController extends Controller {

    public function __construct() {
        // Constructor kosong, pemindahan middleware ke method spesifik
    }

    public function index() {
        // Alias index ke method login agar /login (POST) bisa diproses dengan benar
        $this->login();
    }

    public function login() {
        // Cek redirect jika sudah login
        Middleware::requireGuest();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validasi CSRF
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            }

            if (empty($username) || empty($password)) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Username dan password wajib diisi.']);
            }

            $userModel = $this->model('User');
            $user = $userModel->findByUsernameOrEmail($username);

            if ($user && password_verify($password, $user->password)) {
                if ($user->status !== 'active') {
                    $this->jsonResponse(['status' => 'error', 'message' => 'Akun tidak aktif.']);
                }

                // Set Session
                Auth::setSession($user);

                // Record Activity
                $userModel->logActivity($user->id, 'Login to system', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

                // Determine redirect
                $redirectUrl = BASE_URL . ($user->role === 'admin' ? 'admin/dashboard' : 'student/dashboard');

                $this->jsonResponse([
                    'status' => 'success',
                    'message' => 'Login berhasil.',
                    'redirect' => $redirectUrl
                ]);
            } else {
                $this->jsonResponse(['status' => 'error', 'message' => 'Username/Email atau Password salah.']);
            }
        }

        $this->view('auth/login', ['title' => 'Login - ' . APP_NAME]);
    }

    public function forgotPassword() {
        // Placeholder for forgot password
        $this->view('auth/forgot-password', ['title' => 'Lupa Password - ' . APP_NAME]);
    }

    public function logout() {
        Auth::logout();
        $this->redirect('login');
    }
}
