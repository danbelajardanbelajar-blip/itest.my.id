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

    public function getExamAggregates() {
        $this->db->query("
            SELECT 
                e.id as exam_id,
                e.title as exam_title,
                s.name as subject_name,
                COUNT(r.id) as participant_count,
                AVG(r.score) as average_score,
                MAX(r.score) as max_score,
                MIN(r.score) as min_score,
                SUM(CASE WHEN r.status = 'passed' THEN 1 ELSE 0 END) as passed_count
            FROM exams e
            LEFT JOIN results r ON e.id = r.exam_id
            LEFT JOIN subjects s ON e.subject_id = s.id
            GROUP BY e.id
            ORDER BY e.start_time DESC
        ");
        return $this->db->resultSet();
    }

    public function getResultsByExam($examId) {
        $this->db->query("
            SELECT r.*, s.name as student_name, s.nis, c.name as class_name, e.title as exam_title
            FROM results r
            JOIN students st ON r.student_id = st.id
            JOIN users s ON st.user_id = s.id
            LEFT JOIN classes c ON st.class_id = c.id
            JOIN exams e ON r.exam_id = e.id
            WHERE r.exam_id = :exam_id
            ORDER BY r.score DESC, s.name ASC
        ");
        $this->db->bind(':exam_id', $examId);
        return $this->db->resultSet();
    }
}
