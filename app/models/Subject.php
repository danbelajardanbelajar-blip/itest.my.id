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
}
