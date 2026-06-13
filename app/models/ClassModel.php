<?php

class ClassModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT c.*, m.name as major_name, u.name as teacher_name 
                          FROM classes c
                          LEFT JOIN majors m ON c.major_id = m.id
                          LEFT JOIN teachers t ON c.teacher_id = t.id
                          LEFT JOIN users u ON t.user_id = u.id
                          ORDER BY c.level ASC, c.name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM classes WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $this->db->query("INSERT INTO classes (name, level, major_id, teacher_id) VALUES (:name, :level, :major_id, :teacher_id)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':level', $data['level']);
        $this->db->bind(':major_id', empty($data['major_id']) ? null : $data['major_id']);
        $this->db->bind(':teacher_id', empty($data['teacher_id']) ? null : $data['teacher_id']);
        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query("UPDATE classes SET name = :name, level = :level, major_id = :major_id, teacher_id = :teacher_id WHERE id = :id");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':level', $data['level']);
        $this->db->bind(':major_id', empty($data['major_id']) ? null : $data['major_id']);
        $this->db->bind(':teacher_id', empty($data['teacher_id']) ? null : $data['teacher_id']);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM classes WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
