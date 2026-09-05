<?php

class Middleware {
    public static function requireLogin() {
        if (!Auth::check()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (!Auth::isAdmin()) {
            die("Access Denied. Admin privileges required.");
        }
    }

    public static function requireStudent() {
        self::requireLogin();
        if (!Auth::isStudent()) {
            die("Access Denied. Student privileges required.");
        }
    }

    public static function requireTeacher() {
        self::requireLogin();
        if (!Auth::isTeacher()) {
            die("Access Denied. Teacher privileges required.");
        }
    }

    public static function requireGuest() {
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                header('Location: ' . BASE_URL . 'admin/dashboard');
                exit;
            } elseif (Auth::isTeacher()) {
                header('Location: ' . BASE_URL . 'teacher/dashboard');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'student/dashboard');
                exit;
            }
        }
    }
}
