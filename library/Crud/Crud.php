<?php

namespace Library\Crud;

use App\Database;
use Library\Crud\Select;

class Crud extends Database
{
    protected $primary_key;
    protected $schema;
    protected $table;

    protected $pdo;

    protected $select;
    protected $delete;
    protected $insert;
    protected $update;

    public function __construct()
    {
        $this->pdo = $this->createConnection();
    }

    public function select(string $schema = null, string $table = null)
    {
        $this->select = new Select();
        $table = $table ?? $this->table;
        $schema = $schema ?? $this->schema;

        return $this->select->selectTable($schema, $table);
    }

    public function delete(string $schema = null, string $table = null)
    {
        $this->delete = new Delete();
        $table = $table ?? $this->table;
        $schema = $schema ?? $this->schema;

        return $this->delete->deleteTable($schema, $table);
    }

    public function insert(string $schema = null, string $table = null)
    {
        $this->insert = new Insert();
        $table = $table ?? $this->table;
        $schema = $schema ?? $this->schema;

        return $this->insert->insertTable($schema, $table);
    }

    public function update(string $schema = null, string $table = null)
    {
        $this->update = new Update();
        $table = $table ?? $this->table;
        $schema = $schema ?? $this->schema;

        return $this->update->updateTable($schema, $table);
    }
}
