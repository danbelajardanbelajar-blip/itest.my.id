<?php

class School {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM schools ORDER BY name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM schools WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $this->db->query("INSERT INTO schools (name, level, address) VALUES (:name, :level, :address)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':level', $data['level'] ?? null);
        $this->db->bind(':address', $data['address'] ?? null);
        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query("UPDATE schools SET name = :name, level = :level, address = :address WHERE id = :id");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':level', $data['level'] ?? null);
        $this->db->bind(':address', $data['address'] ?? null);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM schools WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
