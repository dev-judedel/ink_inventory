<?php
declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

/**
 * Simple PDO wrapper with lazy connection loaded from app/config/.env.
 */
class DB
{
    private static ?PDO $pdo = null;

    /** Obtain shared PDO connection. */
    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $envPath = __DIR__ . '/../config/.env';
            if (!file_exists($envPath)) {
                throw new PDOException('.env file not found at ' . $envPath);
            }
            $env = parse_ini_file($envPath, false, INI_SCANNER_RAW);
            $driver = $env['DB_CONNECTION'] ?? 'mysql';
            $host   = $env['DB_HOST'] ?? '127.0.0.1';
            $port   = $env['DB_PORT'] ?? '3306';
            $db     = $env['DB_DATABASE'] ?? '';
            $user   = $env['DB_USERNAME'] ?? '';
            $pass   = $env['DB_PASSWORD'] ?? '';
            $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $driver,
                $host,
                $port,
                $db
            );
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }

    public static function beginTransaction(): void
    {
        self::connection()->beginTransaction();
    }

    public static function commit(): void
    {
        self::connection()->commit();
    }

    public static function rollBack(): void
    {
        self::connection()->rollBack();
    }

    public static function query(string $sql, array $params = []): DBResult
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($params);
        return new DBResult($stmt);
    }
}

/**
 * Lightweight query result wrapper for convenience.
 */
class DBResult
{
    public function __construct(private \PDOStatement $stmt)
    {
    }

    public function all(): array
    {
        return $this->stmt->fetchAll();
    }

    public function first(): array|false
    {
        $row = $this->stmt->fetch();
        return $row === false ? false : $row;
    }
}
