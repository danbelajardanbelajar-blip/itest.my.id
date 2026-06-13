<?php

class ClassModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM classes ORDER BY level ASC, name ASC");
        return $this->db->resultSet();
    }
}
