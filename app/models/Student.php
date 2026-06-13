<?php

class Student {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT s.*, u.name, u.username, u.email, c.name as class_name, m.name as major_name 
                          FROM students s 
                          JOIN users u ON s.user_id = u.id 
                          LEFT JOIN classes c ON s.class_id = c.id
                          LEFT JOIN majors m ON s.major_id = m.id
                          ORDER BY u.name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT s.*, u.name, u.username, u.email, u.status, c.name as class_name, m.name as major_name 
                          FROM students s 
                          JOIN users u ON s.user_id = u.id 
                          LEFT JOIN classes c ON s.class_id = c.id
                          LEFT JOIN majors m ON s.major_id = m.id
                          WHERE s.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        try {
            $this->db->query("INSERT INTO users (name, username, email, password, role, status) VALUES (:name, :username, :email, :password, 'student', 'active')");
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':username', $data['nis']); // Default username is NIS
            $this->db->bind(':email', $data['nis'] . '@student.com'); // Placeholder email
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->execute();

            $userId = $this->db->lastInsertId();

            $this->db->query("INSERT INTO students (user_id, nis, class_id, gender) VALUES (:user_id, :nis, :class_id, :gender)");
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':nis', $data['nis']);
            $this->db->bind(':class_id', $data['class_id'] ?? null);
            $this->db->bind(':gender', $data['gender'] ?? 'L');
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $student = $this->getById($id);
        if ($student) {
            $this->db->query("DELETE FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $student->user_id);
            return $this->db->execute(); // Cascade will handle student record
        }
        return false;
    }
}
