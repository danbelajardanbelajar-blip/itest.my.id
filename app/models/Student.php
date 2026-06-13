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
}
