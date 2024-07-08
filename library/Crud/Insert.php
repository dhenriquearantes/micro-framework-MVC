<?php

namespace Library\Crud;

class Insert extends Crud
{
    public const INSERT = 'INSERT';
    public const WHERE = 'WHERE';
    public const INTO = 'INTO';
    public const VALUES = 'VALUES';

    protected $query = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function insertTable(string $schema = null, string $table = null)
    {
        $this->table = $table;
        $this->schema = $schema;
        if ($schema) {
            $this->query[self::INSERT] = "{$schema}.{$table}";

            return $this;
        }
        $this->query[self::INSERT] = "{$table}";

        return $this;
    }

    public function into($key)
    {
        $fields = array_keys($key);

        $this->query[self::INTO][] = '('.implode(', ', $fields).')';

        return $this;
    }

    public function values($values)
    {
        $fields = array_keys($values);
        $binds = array_pad($values, count($fields), '?');

        $bindsSerialized = $this->serializeValues($binds);

        $this->query[self::VALUES][] = '('.implode(',', $bindsSerialized).')';

        return $this;
    }

    public function serializeValues($values)
    {
        foreach ($values as $key2 => $value2) {
            if (is_string($value2)) {
                $values[$key2] = "'{$value2}'";
            }
        }

        return $values;
    }

    public function getSqlRaw()
    {
        $key = isset($this->query[self::INTO]) ? implode(', ', $this->query[self::INTO]) : null;
        $values = isset($this->query[self::VALUES]) ? implode(', ', $this->query[self::VALUES]) : null;

        return "INSERT INTO {$this->query[self::INSERT]} {$key} VALUES {$values};";
    }

    public function selectRaw(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function get()
    {
        $sql = $this->getSqlRaw();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function first()
    {
        $sql = $this->getSqlRaw();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }
}
