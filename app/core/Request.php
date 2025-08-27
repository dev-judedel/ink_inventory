<?php
declare(strict_types=1);

namespace Core;

/**
 * Simplified request helper.
 */
class Request
{
    public static function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public static function only(array $keys): array
    {
        $data = [];
        foreach ($keys as $k) {
            if (isset($_POST[$k])) {
                $data[$k] = $_POST[$k];
            }
        }
        return $data;
    }
}
