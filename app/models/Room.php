<?php

class Room {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM rooms ORDER BY name ASC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM rooms WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        $this->db->query("INSERT INTO rooms (name, capacity) VALUES (:name, :capacity)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':capacity', $data['capacity'] ?? 0);
        return $this->db->execute();
    }

    public function update($id, $data) {
        $this->db->query("UPDATE rooms SET name = :name, capacity = :capacity WHERE id = :id");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':capacity', $data['capacity'] ?? 0);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM rooms WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
