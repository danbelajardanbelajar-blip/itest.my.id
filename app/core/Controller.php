<?php

class Controller {
    public function view($view, $data = []) {
        // Cek jika request melalui fetch API (untuk SPA)
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // Buat variabel dari array data agar bisa diakses di view
        extract($data);
        
        if ($isAjax) {
            // Jika AJAX, kita hanya kembalikan konten bagian tengah (partial view)
            if (file_exists('app/views/' . $view . '.php')) {
                require_once 'app/views/' . $view . '.php';
            } else {
                echo 'View not found.';
            }
        } else {
            // Jika bukan AJAX (reload langsung), kita kembalikan beserta layout-nya
            // Tentukan layout berdasarkan direktori view
            $layout = 'app/views/layouts/auth.php'; // default
            if ($view === 'student/exam_start') {
                $layout = null; // No layout for exam_start, it has its own HTML
            } elseif (strpos($view, 'admin/') === 0) {
                $layout = 'app/views/layouts/admin.php';
            } elseif (strpos($view, 'student/') === 0) {
                $layout = 'app/views/layouts/student.php';
            }

            // Simpan partial view ke variabel konten
            if (file_exists('app/views/' . $view . '.php')) {
                ob_start();
                require_once 'app/views/' . $view . '.php';
                $content = ob_get_clean();
            } else {
                $content = 'View not found.';
            }

            // Render layout yang sudah disuntikkan konten
            if ($layout && file_exists($layout)) {
                require_once $layout;
            } else {
                echo $content;
            }
        }
    }

    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model;
    }

    public function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}
