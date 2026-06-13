<?php

class Auth {
    public static function setSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;
        $_SESSION['name'] = $user->name;
    }

    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function user() {
        if (self::check()) {
            return (object) [
                'id' => $_SESSION['user_id'],
                'role' => $_SESSION['role'],
                'name' => $_SESSION['name']
            ];
        }
        return null;
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function isAdmin() {
        return self::check() && $_SESSION['role'] === 'admin';
    }

    public static function isStudent() {
        return self::check() && $_SESSION['role'] === 'student';
    }
}
