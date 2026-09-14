<?php

class Subject {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM subjects ORDER BY name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM subjects WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $this->db->query("INSERT INTO subjects (name, code) VALUES (:name, :code)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':code', $data['code']);
        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query("UPDATE subjects SET name = :name, code = :code WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':code', $data['code']);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM subjects WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
