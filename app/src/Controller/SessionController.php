<?php
namespace App\Controller;

class SessionController {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy() {
        session_destroy();
    }

  
    public static function getUserId(): ?int
    {
        // Exemple : si l'ID de l'utilisateur est stocké dans $_SESSION
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUserRole(): ?string
    {
        // Exemple : si le rôle de l'utilisateur est stocké dans $_SESSION
        return $_SESSION['role_id'] ?? null;
    }
}


?>