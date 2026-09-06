<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Add bundle_name to questions
    try {
        $pdo->exec("ALTER TABLE questions ADD COLUMN bundle_name VARCHAR(100) NULL AFTER class_id");
        echo "✅ Kolom bundle_name berhasil ditambahkan ke tabel questions.<br>";
    } catch (PDOException $e) {
        echo "⚠️ Kolom bundle_name mungkin sudah ada di tabel questions: " . $e->getMessage() . "<br>";
    }

    // Add bundle_name to exams
    try {
        $pdo->exec("ALTER TABLE exams ADD COLUMN bundle_name VARCHAR(100) NULL AFTER class_id");
        echo "✅ Kolom bundle_name berhasil ditambahkan ke tabel exams.<br>";
    } catch (PDOException $e) {
        echo "⚠️ Kolom bundle_name mungkin sudah ada di tabel exams: " . $e->getMessage() . "<br>";
    }
    
    echo "<br><b>Migrasi Selesai! Anda bisa menghapus file ini.</b>";
} catch (Exception $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}
