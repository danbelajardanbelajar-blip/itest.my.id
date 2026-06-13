<?php

class ExamSession {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getActiveSession($examId, $studentId) {
        $this->db->query("SELECT * FROM exam_sessions WHERE exam_id = :exam_id AND student_id = :student_id AND status = 'active'");
        $this->db->bind(':exam_id', $examId);
        $this->db->bind(':student_id', $studentId);
        return $this->db->single();
    }

    public function startSession($examId, $studentId, $durationMinutes) {
        $this->db->query("INSERT INTO exam_sessions (exam_id, student_id, started_at, remaining_seconds, status, ip_address, user_agent) 
                          VALUES (:exam_id, :student_id, NOW(), :remaining_seconds, 'active', :ip_address, :user_agent)");
        $this->db->bind(':exam_id', $examId);
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':remaining_seconds', $durationMinutes * 60);
        $this->db->bind(':ip_address', $_SERVER['REMOTE_ADDR']);
        $this->db->bind(':user_agent', $_SERVER['HTTP_USER_AGENT']);
        return $this->db->execute();
    }
}
