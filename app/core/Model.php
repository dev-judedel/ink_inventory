<?php
declare(strict_types=1);

namespace Core;

use Exception;

/**
 * Very small ActiveRecord-style base model using PDO.
 */
abstract class Model
{
    protected string $table;
    protected array $fillable = [];
    protected array $attributes = [];

    public function __construct(array $attrs = [])
    {
        foreach ($attrs as $k => $v) {
            if (in_array($k, $this->fillable, true) || $k === 'id') {
                $this->attributes[$k] = $v;
            }
        }
    }

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, $value): void
    {
        if (in_array($key, $this->fillable, true) || $key === 'id') {
            $this->attributes[$key] = $value;
        }
    }

    public function save(): void
    {
        $cols = array_keys($this->attributes);
        if (isset($this->attributes['id'])) {
            $set = [];
            $params = [];
            foreach ($cols as $c) {
                if ($c === 'id') continue;
                $set[] = "$c=?";
                $params[] = $this->attributes[$c];
            }
            $params[] = $this->attributes['id'];
            $sql = "UPDATE {$this->table} SET " . implode(',', $set) . " WHERE id=?";
            DB::query($sql, $params);
        } else {
            $placeholders = implode(',', array_fill(0, count($cols), '?'));
            $sql = "INSERT INTO {$this->table} (" . implode(',', $cols) . ") VALUES ({$placeholders})";
            DB::query($sql, array_map(fn($c) => $this->attributes[$c], $cols));
            $this->attributes['id'] = (int)DB::connection()->lastInsertId();
        }
    }

    // ----- Query builder -----
    public static function query(): QueryBuilder
    {
        $inst = new static();
        return new QueryBuilder($inst->table, static::class);
    }

    public static function where(string $column, $operatorOrValue, $value = null): QueryBuilder
    {
        return static::query()->where($column, $operatorOrValue, $value);
    }

    public static function whereRaw(string $expr, array $params = []): QueryBuilder
    {
        return static::query()->whereRaw($expr, $params);
    }

    public static function orderBy(string $column, string $dir = 'asc'): QueryBuilder
    {
        return static::query()->orderBy($column, $dir);
    }

    public static function findOrFail(int $id): static
    {
        $inst = new static();
        $row = DB::query("SELECT * FROM {$inst->table} WHERE id=? LIMIT 1", [$id])->first();
        if (!$row) {
            throw new Exception('Record not found');
        }
        $model = new static($row);
        $model->attributes['id'] = (int)$row['id'];
        return $model;
    }
}

class QueryBuilder
{
    private string $table;
    private string $modelClass;
    private array $wheres = [];
    private array $params = [];
    private array $order = [];
    private ?int $limit = null;
    private bool $forUpdate = false;

    public function __construct(string $table, string $modelClass)
    {
        $this->table = $table;
        $this->modelClass = $modelClass;
    }

    public function where(string $column, $operatorOrValue, $value = null): self
    {
        if ($value === null) {
            $value = $operatorOrValue;
            $operator = '=';
        } else {
            $operator = $operatorOrValue;
        }
        $this->wheres[] = "$column $operator ?";
        $this->params[] = $value;
        return $this;
    }

    public function whereRaw(string $expr, array $params = []): self
    {
        $this->wheres[] = $expr;
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function orderBy(string $column, string $dir = 'asc'): self
    {
        $this->order[] = "$column " . strtoupper($dir);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function lockForUpdate(): self
    {
        $this->forUpdate = true;
        return $this;
    }

    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($this->wheres) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }
        if ($this->order) {
            $sql .= ' ORDER BY ' . implode(', ', $this->order);
        }
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        if ($this->forUpdate) {
            $sql .= ' FOR UPDATE';
        }
        $rows = DB::query($sql, $this->params)->all();
        return array_map(function ($row) {
            $model = new $this->modelClass($row);
            $model->attributes['id'] = (int)($row['id'] ?? 0);
            return $model;
        }, $rows);
    }

    public function paginate(int $perPage): array
    {
        $this->limit($perPage);
        return $this->get();
    }
}
