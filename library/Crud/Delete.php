<?php

namespace Library\Crud;

use Exception;

class Delete extends Crud
{
    public const DELETE = 'DELETE';
    public const WHERE = 'WHERE';

    protected $query = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteTable(string $schema = null, string $table = null)
    {
        $this->table = $table;
        $this->schema = $schema;
        if ($schema) {
            $this->query[self::DELETE] = "{$schema}.{$table}";

            return $this;
        }

        $this->query[self::DELETE] = "{$table}";

        return $this;
    }

    public function where(array $where)
    {
        $first = $where[0];

        $operator = $where[1] ?? '=';
        $operator = $operator == 'in' ? 'IN' : $operator;

        if (isset($where[2])) {
            $type = gettype($where[2]);
            $second = $where[2];
            if ($type === 'string') {
                $second = "'{$second}'";
            }
        }

        if (!isset($where[2])) {
            $operator = '=';
            $second = $where[1] ?? '';
        }

        if ($operator == 'IN') {
            $second = '('.implode(', ', $second).')';
        }

        if (!$second) {
            throw new Exception('Faltando parametros no where');
        }

        $this->query[self::WHERE][] = "{$first} {$operator} {$second}";

        return $this;
    }

    public function getSqlRaw()
    {
        $where = isset($this->query[self::WHERE]) ? ' WHERE '.implode(' and ', $this->query[self::WHERE]) : null;

        return "DELETE FROM {$this->query[self::DELETE]}{$where}";
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

        return $stmt->fetchAll();
    }

    public function first()
    {
        $sql = $this->getSqlRaw();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }
}
