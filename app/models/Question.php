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

    public function create($data, $choices) {
        try {
            $this->db->query("INSERT INTO questions (subject_id, class_id, question_text, question_image, question_type) 
                              VALUES (:subject_id, :class_id, :question_text, :question_image, :question_type)");
            $this->db->bind(':subject_id', $data['subject_id']);
            $this->db->bind(':class_id', $data['class_id'] ?? null);
            $this->db->bind(':question_text', $data['question_text']);
            $this->db->bind(':question_image', $data['question_image'] ?? null);
            $this->db->bind(':question_type', $data['question_type'] ?? 'multiple_choice');
            $this->db->execute();

            $questionId = $this->db->lastInsertId();

            if (!empty($choices) && is_array($choices)) {
                $this->db->query("INSERT INTO question_choices (question_id, choice_label, choice_text, is_correct) 
                                  VALUES (:question_id, :choice_label, :choice_text, :is_correct)");
                foreach ($choices as $index => $choice) {
                    $this->db->bind(':question_id', $questionId);
                    $this->db->bind(':choice_label', chr(65 + $index));
                    $this->db->bind(':choice_text', $choice['text']);
                    $this->db->bind(':is_correct', $choice['is_correct'] ? 1 : 0);
                    $this->db->execute();
                }
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM questions WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute(); // Cascade will handle choices
    }

    public function getForExam($examId) {
        // Get exam details
        $this->db->query("SELECT subject_id, class_id, total_questions, random_questions FROM exams WHERE id = :exam_id");
        $this->db->bind(':exam_id', $examId);
        $exam = $this->db->single();

        if (!$exam) return [];

        // Build query
        $query = "SELECT * FROM questions WHERE subject_id = :subject_id";
        
        // Match class if exam specifies it
        if ($exam->class_id) {
            $query .= " AND (class_id = :class_id OR class_id IS NULL)";
        }

        // Randomize
        if ($exam->random_questions) {
            $query .= " ORDER BY RAND()";
        } else {
            $query .= " ORDER BY id ASC";
        }

        // Limit
        if ($exam->total_questions > 0) {
            $query .= " LIMIT " . (int)$exam->total_questions;
        }

        $this->db->query($query);
        $this->db->bind(':subject_id', $exam->subject_id);
        if ($exam->class_id) {
            $this->db->bind(':class_id', $exam->class_id);
        }

        return $this->db->resultSet();
    }
}
