<?php
declare(strict_types=1);

namespace Core;

/**
 * Minimal response helper for redirects and flash messages.
 */
class Response
{
    public static function redirect(string $url): self
    {
        header('Location: ' . $url);
        return new self();
    }

    public function with(string $key, string $value): self
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[$key] = $value;
        return $this;
    }
}
