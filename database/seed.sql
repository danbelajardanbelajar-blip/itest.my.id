-- Default Settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('app_name', 'iTest CBT Platform'),
('institution_name', 'Sekolah Demo'),
('logo_path', 'public/assets/img/logo.png'),
('favicon_path', 'public/assets/img/favicon.png'),
('allow_student_registration', '0'),
('maintenance_mode', '0');

-- Insert Roles
INSERT INTO `roles` (`name`) VALUES ('admin'), ('student');

-- Insert Admin User (Password: 123456)
-- password_hash('123456', PASSWORD_DEFAULT)
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `status`) VALUES
(1, 'Administrator', 'admin', 'zenhkm@gmail.com', '$2y$10$gMgYoFkeXzZX/voeRQ0SKuYKaUccMJHIVNB/Ck9OIN8QjdosB8KzK', 'admin', 'active');

-- Insert Demo Class
INSERT INTO `classes` (`id`, `name`, `level`) VALUES
(1, 'X IPA 1', '10'),
(2, 'X IPS 1', '10');

-- Insert Demo Major
INSERT INTO `majors` (`id`, `name`, `code`) VALUES
(1, 'Ilmu Pengetahuan Alam', 'IPA'),
(2, 'Ilmu Pengetahuan Sosial', 'IPS');

-- Insert Student User (Password: 123)
-- password_hash('123', PASSWORD_DEFAULT)
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `status`) VALUES
(2, 'Siswa Demo', '12121212121212121', 'siswa@demo.com', '$2y$10$HvGK0CMG.Kw/utzEkVEg3e.5pS4nyPp/HkNcWL304XcErU7x0T4Ki', 'student', 'active');

-- Insert Student Detail
INSERT INTO `students` (`user_id`, `nis`, `class_id`, `major_id`, `gender`, `phone`) VALUES
(2, '12121212121212121', 1, 1, 'L', '081234567890');

-- Insert Subjects
INSERT INTO `subjects` (`id`, `name`, `code`) VALUES
(1, 'Matematika', 'MTK'),
(2, 'Bahasa Indonesia', 'BIND');
