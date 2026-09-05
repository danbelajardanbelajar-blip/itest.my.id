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
                $redirectUrl = BASE_URL . ($user->role === 'admin' ? 'admin/dashboard' : ($user->role === 'teacher' ? 'teacher/dashboard' : 'student/dashboard'));

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

    public function register() {
        Middleware::requireGuest();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            }

            $name = $_POST['name'] ?? '';
            $nip = $_POST['nip'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (empty($name) || empty($nip) || empty($email) || empty($password)) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
            }

            if ($password !== $password_confirm) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Konfirmasi password tidak cocok.']);
            }

            $userModel = $this->model('User');
            if ($userModel->findByUsernameOrEmail($email) || $userModel->findByUsernameOrEmail($nip)) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Email atau NIP sudah terdaftar.']);
            }

            $data = [
                'name' => $name,
                'nip' => $nip,
                'email' => $email,
                'password' => $password,
                'gender' => 'L', // default
                'phone' => '' // default
            ];

            if ($this->model('Teacher')->create($data)) {
                $this->jsonResponse([
                    'status' => 'success',
                    'message' => 'Pendaftaran berhasil. Silakan login.',
                    'redirect' => BASE_URL . 'login'
                ]);
            } else {
                $this->jsonResponse(['status' => 'error', 'message' => 'Gagal mendaftar. Silakan coba lagi.']);
            }
        }

        $this->view('auth/register', ['title' => 'Daftar Staf - ' . APP_NAME]);
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Invalid CSRF token.']);
            }

            if (empty($email)) {
                $this->jsonResponse(['status' => 'error', 'message' => 'Email wajib diisi.']);
            }

            // Simulasi pengiriman email
            $this->jsonResponse([
                'status' => 'success',
                'message' => 'Jika email Anda terdaftar, link reset password telah dikirim.',
                'redirect' => BASE_URL . 'login'
            ]);
        }

        $this->view('auth/forgot-password', ['title' => 'Lupa Password - ' . APP_NAME]);
    }

    public function logout() {
        Auth::logout();
        $this->redirect('login');
    }
}
