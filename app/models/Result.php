<?php

class Result {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getStudentHistory($studentId) {
        $this->db->query("SELECT r.*, e.title as exam_title, e.show_score, s.name as subject_name,
                                 DATE_FORMAT(r.created_at, '%d %M %Y %H:%i') as finished_time
                          FROM results r
                          JOIN exams e ON r.exam_id = e.id
                          LEFT JOIN subjects s ON e.subject_id = s.id
                          WHERE r.student_id = :student_id
                          ORDER BY r.created_at DESC");
        $this->db->bind(':student_id', $studentId);
        return $this->db->resultSet();
    }
}
