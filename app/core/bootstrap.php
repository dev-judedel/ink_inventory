<?php
declare(strict_types=1);

use Core\Router;

// Autoload App and Core namespaces
spl_autoload_register(function (string $class): void {
    $prefixes = [
        'App\\'  => __DIR__ . '/../',
        'Core\\' => __DIR__ . '/',
    ];
    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($class, $prefix, $len) !== 0) {
            continue;
        }
        $relative = substr($class, $len);
        $relativePath = str_replace('\\', '/', $relative);

        // Ensure directory segments are lowercase to match folder structure
        $segments = explode('/', $relativePath);
        if (count($segments) > 1) {
            $fileName = array_pop($segments);
            $dir = implode('/', array_map('strtolower', $segments));
            $relativePath = ($dir !== '' ? $dir . '/' : '') . $fileName;
        }

        $file = $baseDir . $relativePath . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});

// Load helper functions
require_once __DIR__ . '/../utils/helpers.php';

// Initialize router and load routes
$router = new Router();
require __DIR__ . '/../routes/web.php';

// Dispatch current request
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
