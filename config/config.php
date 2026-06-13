<?php

// Konfigurasi URL Dasar
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
// Karena aplikasi bisa berjalan di subfolder, kita tentukan base_url otomatis
$script_path = dirname($_SERVER['SCRIPT_NAME']);
$base_url = $protocol . "://" . $host . ($script_path === '/' ? '' : $script_path) . '/';

define('BASE_URL', $base_url);
define('APP_NAME', 'iTest CBT');

// Konstanta Direktori
define('UPLOAD_PATH', BASE_PATH . '/public/uploads/');
