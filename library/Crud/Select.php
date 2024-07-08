<?php

namespace Library\Crud;

use Exception;
use App\Database;
class Select extends Crud
{
    public const SELECT = 'SELECT';
    public const QUANTIFIER = 'QUANTIFIER';
    public const COLUMNS = 'COLUMNS';
    public const TABLE = 'TABLE';
    public const JOINS = 'JOINS';
    public const WHERE = 'WHERE';
    public const GROUP = 'GROUP';
    public const HAVING = 'HAVING';
    public const ORDER = 'ORDER';
    public const LIMIT = 'LIMIT';
    public const OFFSET = 'OFFSET';
    public const QUANTIFIER_DISTINCT = 'DISTINCT';
    public const QUANTIFIER_ALL = 'ALL';
    public const JOIN_INNER = 'INNER';
    public const JOIN_OUTER = 'OUTER';
    public const JOIN_LEFT = 'LEFT';
    public const JOIN_RIGHT = 'RIGHT';
    public const JOIN_OUTER_RIGHT = 'OUTER RIGHT';
    public const JOIN_OUTER_LEFT = 'OUTER LEFT';
    public const SQL_STAR = '*';
    public const ORDER_ASCENDING = 'ASC';
    public const ORDER_DESCENDING = 'DESC';
    public const COMBINE = 'COMBINE';
    public const COMBINE_UNION = 'UNION';
    public const COMBINE_EXCEPT = 'EXCEPT';
    public const COMBINE_INTERSECT = 'INTERSECT';

    protected $query = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function selectTable(string $schema = null, string $table = null)
    {
        $this->table = $table;
        $this->schema = $schema;

        if ($schema) {
            $this->query[self::SELECT] = "{$schema}.{$table}";

            return $this;
        }
        $this->query[self::SELECT] = "{$table}";

        return $this;
    }

    public function all()
    {
        $this->selectTable();

        return $this->get();
    }

    public function find($id)
    {
        $this->selectTable();
        $this->where([$this->primary_key, $id]);
        $this->limit(1);

        return $this->first();
    }

    public function columns(array $columns)
    {
        $this->query[self::COLUMNS] = implode(', ', $columns);

        return $this;
    }

    public function limit(int $limit)
    {
        $this->query[self::LIMIT] = $limit;

        return $this;
    }

    public function order(array $order)
    {
        if (count($order) === 1) {
            $this->query[self::ORDER][] = "{$order[0]} asc";
        } else {
            $this->query[self::ORDER][] = "{$order[0]} {$order[1]}";
        }

        return $this;
    }

    public function join($name, $on, $type = self::JOIN_INNER)
    {
        $this->query[self::JOINS][] = "{$type} JOIN {$name} ON {$on}";

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

    public function group(array $group)
    {
        $this->query[self::GROUP][] = implode(', ', $group);

        return $this;
    }

    public function offset($offset)
    {
    }

    public function getSqlRaw()
    {
        $columns = $this->query[self::COLUMNS] ?? self::SQL_STAR;

        $limit = isset($this->query[self::LIMIT]) ? ' '.self::LIMIT.' '.$this->query[self::LIMIT] : null;

        $order = isset($this->query[self::ORDER]) ? ' '.self::ORDER.' BY '.implode(', ', $this->query[self::ORDER]) : null;

        $where = isset($this->query[self::WHERE]) ? ' WHERE '.implode(' AND ', $this->query[self::WHERE]) : null;

        $join = isset($this->query[self::JOINS]) ? ' '.implode(' ', $this->query[self::JOINS]) : null;

        $group = isset($this->query[self::GROUP]) ? ' '.self::GROUP.' BY '.implode(', ', $this->query[self::GROUP]) : null;

        return "SELECT {$columns} FROM {$this->query[self::SELECT]}{$join}{$where}{$order}{$limit}{$group}";
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
