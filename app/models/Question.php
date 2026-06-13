<?php

class Question {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT q.*, s.name as subject_name, c.name as class_name 
                          FROM questions q
                          LEFT JOIN subjects s ON q.subject_id = s.id
                          LEFT JOIN classes c ON q.class_id = c.id
                          ORDER BY q.created_at DESC");
        return $this->db->resultSet();
    }

    public function getChoices($questionId) {
        $this->db->query("SELECT * FROM question_choices WHERE question_id = :id ORDER BY choice_label ASC");
        $this->db->bind(':id', $questionId);
        return $this->db->resultSet();
    }
}
