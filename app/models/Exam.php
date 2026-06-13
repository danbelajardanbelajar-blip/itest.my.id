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

    public function getById($id) {
        $this->db->query("SELECT e.*, s.name as subject_name, c.name as class_name 
                          FROM exams e
                          LEFT JOIN subjects s ON e.subject_id = s.id
                          LEFT JOIN classes c ON e.class_id = c.id
                          WHERE e.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($data) {
        try {
            $this->db->query("INSERT INTO exams (title, subject_id, class_id, start_time, end_time, duration_minutes, total_questions, passing_score, status) 
                              VALUES (:title, :subject_id, :class_id, :start_time, :end_time, :duration_minutes, :total_questions, :passing_score, :status)");
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':subject_id', $data['subject_id']);
            $this->db->bind(':class_id', $data['class_id'] ?? null);
            $this->db->bind(':start_time', $data['start_time']);
            $this->db->bind(':end_time', $data['end_time']);
            $this->db->bind(':duration_minutes', $data['duration_minutes']);
            $this->db->bind(':total_questions', $data['total_questions'] ?? 0);
            $this->db->bind(':passing_score', $data['passing_score'] ?? 0);
            $this->db->bind(':status', $data['status'] ?? 'draft');
            
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM exams WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute(); // Cascade will handle related tables
    }

    public function update($id, $data) {
        try {
            $this->db->query("UPDATE exams SET title = :title, subject_id = :subject_id, class_id = :class_id, 
                              start_time = :start_time, end_time = :end_time, duration_minutes = :duration_minutes, 
                              passing_score = :passing_score, status = :status WHERE id = :id");
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':subject_id', $data['subject_id']);
            $this->db->bind(':class_id', empty($data['class_id']) ? null : $data['class_id']);
            $this->db->bind(':start_time', $data['start_time']);
            $this->db->bind(':end_time', $data['end_time']);
            $this->db->bind(':duration_minutes', $data['duration_minutes']);
            $this->db->bind(':passing_score', $data['passing_score'] ?? 0);
            $this->db->bind(':status', $data['status'] ?? 'draft');
            $this->db->bind(':id', $id);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
