<?php

class Exam {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT e.*, s.name as subject_name, c.name as class_name 
                          FROM exams e
                          LEFT JOIN subjects s ON e.subject_id = s.id
                          LEFT JOIN classes c ON e.class_id = c.id
                          ORDER BY e.start_time DESC");
        return $this->db->resultSet();
    }

    public function getActiveForStudent($studentId) {
        $this->db->query("
            SELECT e.*, s.name as subject_name 
            FROM exams e
            JOIN exam_participants ep ON e.id = ep.exam_id
            LEFT JOIN subjects s ON e.subject_id = s.id
            WHERE ep.student_id = :student_id 
              AND e.status = 'published'
              AND e.end_time > NOW()
            ORDER BY e.start_time ASC
        ");
        $this->db->bind(':student_id', $studentId);
        return $this->db->resultSet();
    }
}
