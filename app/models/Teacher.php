<?php

class Teacher {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT t.*, u.name, u.username, u.email, u.status 
                          FROM teachers t 
                          JOIN users u ON t.user_id = u.id 
                          ORDER BY u.name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT t.*, u.name, u.username, u.email, u.status 
                          FROM teachers t 
                          JOIN users u ON t.user_id = u.id 
                          WHERE t.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        try {
            $this->db->query("INSERT INTO users (name, username, email, password, role, status) VALUES (:name, :username, :email, :password, 'teacher', 'active')");
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':username', $data['nip']); // Default username is NIP
            $this->db->bind(':email', $data['nip'] . '@teacher.com'); // Placeholder email
            $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->execute();

            $userId = $this->db->lastInsertId();

            $this->db->query("INSERT INTO teachers (user_id, nip, gender, phone) VALUES (:user_id, :nip, :gender, :phone)");
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':nip', $data['nip']);
            $this->db->bind(':gender', $data['gender'] ?? 'L');
            $this->db->bind(':phone', $data['phone'] ?? null);
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $teacher = $this->getById($id);
        if ($teacher) {
            $this->db->query("DELETE FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $teacher->user_id);
            return $this->db->execute(); // Cascade will handle teacher record
        }
        return false;
    }

    public function update($id, $data) {
        $teacher = $this->getById($id);
        if (!$teacher) return false;

        try {
            $this->db->query("UPDATE users SET name = :name, username = :username WHERE id = :user_id");
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':username', $data['nip']);
            $this->db->bind(':user_id', $teacher->user_id);
            $this->db->execute();

            if (!empty($data['password'])) {
                $this->db->query("UPDATE users SET password = :password WHERE id = :user_id");
                $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
                $this->db->bind(':user_id', $teacher->user_id);
                $this->db->execute();
            }

            $this->db->query("UPDATE teachers SET nip = :nip, gender = :gender, phone = :phone WHERE id = :id");
            $this->db->bind(':nip', $data['nip']);
            $this->db->bind(':gender', $data['gender'] ?? 'L');
            $this->db->bind(':phone', $data['phone'] ?? null);
            $this->db->bind(':id', $id);
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
