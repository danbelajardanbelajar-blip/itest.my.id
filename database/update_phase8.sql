-- Update script untuk Fase 8 (Fitur Pegawai, Ruangan, Lembaga)

-- 1. Tambahkan Role 'teacher' pada tabel users
ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'student', 'teacher') NOT NULL DEFAULT 'student';

-- 1b. Tambahkan kolom major_id dan teacher_id pada tabel classes
ALTER TABLE `classes` 
ADD COLUMN `major_id` BIGINT UNSIGNED NULL AFTER `name`,
ADD COLUMN `teacher_id` BIGINT UNSIGNED NULL AFTER `major_id`,
ADD CONSTRAINT `fk_classes_major` FOREIGN KEY (`major_id`) REFERENCES `majors`(`id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_classes_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers`(`id`) ON DELETE SET NULL;

-- 2. Buat tabel rooms (Ruangan)
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `capacity` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Buat tabel schools (Lembaga)
CREATE TABLE IF NOT EXISTS `schools` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `level` VARCHAR(50) NULL,
  `address` TEXT NULL,
  `logo` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
