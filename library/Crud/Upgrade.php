<?php

namespace Library\Crud;

use App\Helpers;
use Exception;

class Update extends Crud
{
    public const UPDATE = 'UPDATE';
    public const WHERE = 'WHERE';
    public const SET = 'SET';
    public const LIMIT = 'LIMIT';

    protected $query = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function updateTable(string $schema = null, string $table = null)
    {
        $this->table = $table;
        $this->schema = $schema;

        if ($schema) {
            $this->query[self::UPDATE] = "{$schema}.{$table}";

            return $this;
        }
        $this->query[self::UPDATE] = "{$table}";

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

    public function set(array $fields)
    {
        if (!$fields) {
            throw new Exception('Faltando parametros no set');
        }

        $this->query[self::SET] = Helpers::formatarCamposSql($fields[0] ?? $fields);

        return $this;
    }

    public function limit(int $limit)
    {
        $this->query[self::LIMIT] = $limit;

        return $this;
    }

    public function getSqlRaw()
    {
        $set = isset($this->query[self::SET]) ? ' SET '.$this->query[self::SET] : null;

        $where = isset($this->query[self::WHERE]) ? ' WHERE '.implode(' AND ', $this->query[self::WHERE]) : null;

        $limit = isset($this->query[self::LIMIT]) ? ' '.self::LIMIT.' '.$this->query[self::LIMIT] : null;

        return "UPDATE {$this->query[self::UPDATE]}{$set}{$where}{$limit};";
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
