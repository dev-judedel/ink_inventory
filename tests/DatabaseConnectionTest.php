<?php
declare(strict_types=1);

// Simple standalone test to verify database connectivity using PDO.
// Loads credentials from the project's .env file.

$envPath = dirname(__DIR__) . '/.env';
if (!file_exists($envPath)) {
    fwrite(STDERR, ".env file not found at {$envPath}\n");
    exit(1);
}

$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

$driver = $env['DB_CONNECTION'] ?? 'mysql';
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$db   = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';

$dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=utf8mb4', $driver, $host, $port, $db);

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    // Connection succeeded
    echo "Database connection successful.\n";
    exit(0);
} catch (PDOException $e) {
    // Connection failed
    fwrite(STDERR, 'Database connection failed: ' . $e->getMessage() . "\n");
    exit(1);
}
