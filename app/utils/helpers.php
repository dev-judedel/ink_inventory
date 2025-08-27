<?php
declare(strict_types=1);

if (!function_exists('view')) {
    function view(string $path, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include __DIR__ . '/../views/' . $path . '.php';
        return ob_get_clean();
    }
}
