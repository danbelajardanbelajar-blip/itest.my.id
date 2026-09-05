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

            $userModel = $this->model('User');
            $user = $userModel->findByUsernameOrEmail($email);
            
            if ($user) {
                // Generate password sementara 8 karakter alphanumeric
                $tempPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                
                // Update ke database
                $userModel->updatePasswordByEmail($email, $tempPassword);

                // Load PHPMailer
                $autoloadPath = BASE_PATH . '/../vendor/autoload.php';
                $phpmailerPath = BASE_PATH . '/../vendor/phpmailer/src/PHPMailer.php';
                
                if (file_exists($autoloadPath)) {
                    require_once $autoloadPath;
                } else {
                    require_once BASE_PATH . '/../vendor/phpmailer/src/Exception.php';
                    require_once BASE_PATH . '/../vendor/phpmailer/src/PHPMailer.php';
                    require_once BASE_PATH . '/../vendor/phpmailer/src/SMTP.php';
                }

                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    // Konfigurasi SMTP (Silakan ganti dengan kredensial asli nanti)
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; 
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'email_anda@gmail.com'; // TODO: Ganti
                    $mail->Password   = 'password_aplikasi_anda'; // TODO: Ganti
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Pengirim & Penerima
                    $mail->setFrom('no-reply@itest.my.id', 'iTest CBT System');
                    $mail->addAddress($email, $user->name);

                    // Konten
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password Akun iTest CBT';
                    $mail->Body    = "
                        <h3>Halo, {$user->name}</h3>
                        <p>Kami telah menerima permintaan reset password untuk akun Anda.</p>
                        <p>Password sementara Anda adalah: <b>{$tempPassword}</b></p>
                        <p>Silakan login menggunakan password sementara tersebut dan SEGERA ganti password Anda di menu Pengaturan Akun demi keamanan.</p>
                        <br>
                        <p>Salam,<br>Tim Administrator iTest CBT</p>
                    ";
                    $mail->AltBody = "Halo, {$user->name}\nPassword sementara Anda adalah: {$tempPassword}\nSilakan login dan segera ganti password Anda.";

                    $mail->send();
                } catch (Exception $e) {
                    // Log error but still return success visually or return error
                    $this->jsonResponse(['status' => 'error', 'message' => 'Gagal mengirim email: ' . $mail->ErrorInfo]);
                }
            }

            // Return success (meniru behavior sistem yang tidak memberi tahu jika email salah demi keamanan)
            $this->jsonResponse([
                'status' => 'success',
                'message' => 'Jika email Anda terdaftar, password sementara telah dikirim.',
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
