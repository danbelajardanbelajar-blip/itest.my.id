<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findByUsernameOrEmail($identifier) {
        $this->db->query("SELECT * FROM users WHERE username = :identifier OR email = :identifier");
        $this->db->bind(':identifier', $identifier);
        return $this->db->single();
    }

    public function logActivity($userId, $activity, $ipAddress, $userAgent) {
        $this->db->query("INSERT INTO activity_logs (user_id, activity, ip_address, user_agent) VALUES (:user_id, :activity, :ip_address, :user_agent)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':activity', $activity);
        $this->db->bind(':ip_address', $ipAddress);
        $this->db->bind(':user_agent', $userAgent);
        return $this->db->execute();
    }
}
