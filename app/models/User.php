<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findByUsernameOrEmail($identifier) {
        $this->db->query("SELECT * FROM users WHERE username = :identifier OR email = :identifier");
        $this->db->bind(':identifier', $identifier);
        return $this->db->single();
    }

    public function getAll($role = null) {
        if ($role && in_array($role, ['admin', 'teacher', 'student'])) {
            $this->db->query("SELECT * FROM users WHERE role = :role ORDER BY id DESC");
            $this->db->bind(':role', $role);
        } else {
            $this->db->query("SELECT * FROM users ORDER BY id DESC");
        }
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'] ?? 'student';
        $status = $data['status'] ?? 'active';

        $this->db->query("INSERT INTO users (name, username, email, password, role, status) VALUES (:name, :username, :email, :password, :role, :status)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':role', $role);
        $this->db->bind(':status', $status);
        
        return $this->db->execute();
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->db->query("UPDATE users SET name = :name, username = :username, email = :email, role = :role, status = :status, password = :password WHERE id = :id");
            $this->db->bind(':password', $hashedPassword);
        } else {
            $this->db->query("UPDATE users SET name = :name, username = :username, email = :email, role = :role, status = :status WHERE id = :id");
        }

        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role'] ?? 'student');
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function toggleStatus($id) {
        $this->db->query("UPDATE users SET status = IF(status = 'active', 'inactive', 'active') WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function logActivity($userId, $activity, $ipAddress, $userAgent) {
        $this->db->query("INSERT INTO activity_logs (user_id, activity, ip_address, user_agent) VALUES (:user_id, :activity, :ip_address, :user_agent)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':activity', $activity);
        $this->db->bind(':ip_address', $ipAddress);
        $this->db->bind(':user_agent', $userAgent);
        return $this->db->execute();
    }

    public function updatePasswordByEmail($email, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = :password WHERE email = :email");
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }
}
