<?php
declare(strict_types=1);

namespace Core;

/**
 * Very small auth facade returning current user id from session.
 */
class Auth
{
    public static function id(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }
}
