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
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function updateRemainingTime($sessionId, $remainingSeconds) {
        $this->db->query("UPDATE exam_sessions SET remaining_seconds = :sec, updated_at = NOW() WHERE id = :id");
        $this->db->bind(':sec', $remainingSeconds);
        $this->db->bind(':id', $sessionId);
        return $this->db->execute();
    }

    public function finishSession($sessionId) {
        $this->db->query("UPDATE exam_sessions SET status = 'finished', finished_at = NOW() WHERE id = :id");
        $this->db->bind(':id', $sessionId);
        return $this->db->execute();
    }

    public function saveAnswer($sessionId, $questionId, $choiceId) {
        // Cek apakah jawaban sudah ada
        $this->db->query("SELECT id FROM exam_answers WHERE session_id = :session_id AND question_id = :question_id");
        $this->db->bind(':session_id', $sessionId);
        $this->db->bind(':question_id', $questionId);
        $existing = $this->db->single();

        // Ambil data choice untuk is_correct
        $isCorrect = 0;
        if ($choiceId) {
            $this->db->query("SELECT is_correct FROM question_choices WHERE id = :choice_id");
            $this->db->bind(':choice_id', $choiceId);
            $choice = $this->db->single();
            if ($choice) $isCorrect = $choice->is_correct;
        }

        if ($existing) {
            $this->db->query("UPDATE exam_answers SET selected_choice_id = :choice_id, is_correct = :is_correct, answered_at = NOW() WHERE id = :id");
            $this->db->bind(':choice_id', $choiceId);
            $this->db->bind(':is_correct', $isCorrect);
            $this->db->bind(':id', $existing->id);
        } else {
            $this->db->query("INSERT INTO exam_answers (session_id, question_id, selected_choice_id, is_correct) VALUES (:session_id, :question_id, :choice_id, :is_correct)");
            $this->db->bind(':session_id', $sessionId);
            $this->db->bind(':question_id', $questionId);
            $this->db->bind(':choice_id', $choiceId);
            $this->db->bind(':is_correct', $isCorrect);
        }
        return $this->db->execute();
    }

    public function setFlag($sessionId, $questionId, $isDoubtful) {
        $this->db->query("UPDATE exam_answers SET is_doubtful = :is_doubtful WHERE session_id = :session_id AND question_id = :question_id");
        $this->db->bind(':is_doubtful', $isDoubtful ? 1 : 0);
        $this->db->bind(':session_id', $sessionId);
        $this->db->bind(':question_id', $questionId);
        return $this->db->execute();
    }

    public function getAnswers($sessionId) {
        $this->db->query("SELECT question_id, selected_choice_id, is_doubtful FROM exam_answers WHERE session_id = :id");
        $this->db->bind(':id', $sessionId);
        return $this->db->resultSet();
    }

    public function calculateAndSaveResult($sessionId, $examId, $studentId) {
        // Ambil konfigurasi ujian
        $this->db->query("SELECT total_questions, passing_score FROM exams WHERE id = :exam_id");
        $this->db->bind(':exam_id', $examId);
        $exam = $this->db->single();

        if (!$exam) return false;

        $totalQuestions = $exam->total_questions;
        if ($totalQuestions <= 0) {
            // Count from actual questions if total_questions was set to 0
            $this->db->query("SELECT COUNT(*) as t FROM questions WHERE subject_id = (SELECT subject_id FROM exams WHERE id = :exam_id)");
            $this->db->bind(':exam_id', $examId);
            $totalQuestions = $this->db->single()->t;
        }

        // Ambil data benar/salah
        $this->db->query("SELECT COUNT(*) as correct_count FROM exam_answers WHERE session_id = :session_id AND is_correct = 1");
        $this->db->bind(':session_id', $sessionId);
        $correct = $this->db->single()->correct_count;

        $this->db->query("SELECT COUNT(*) as answered_count FROM exam_answers WHERE session_id = :session_id AND selected_choice_id IS NOT NULL");
        $this->db->bind(':session_id', $sessionId);
        $answered = $this->db->single()->answered_count;

        $wrong = $answered - $correct;
        $unanswered = $totalQuestions - $answered;

        // Hitung skor (0-100)
        $score = $totalQuestions > 0 ? ($correct / $totalQuestions) * 100 : 0;
        $status = $score >= $exam->passing_score ? 'passed' : 'failed';

        // Simpan ke result
        $this->db->query("INSERT INTO results (exam_id, student_id, session_id, total_questions, correct_count, wrong_count, unanswered_count, score, status)
                          VALUES (:exam_id, :student_id, :session_id, :total, :correct, :wrong, :unanswered, :score, :status)");
        $this->db->bind(':exam_id', $examId);
        $this->db->bind(':student_id', $studentId);
        $this->db->bind(':session_id', $sessionId);
        $this->db->bind(':total', $totalQuestions);
        $this->db->bind(':correct', $correct);
        $this->db->bind(':wrong', $wrong);
        $this->db->bind(':unanswered', $unanswered);
        $this->db->bind(':score', $score);
        $this->db->bind(':status', $status);
        
        return $this->db->execute();
    }
}
