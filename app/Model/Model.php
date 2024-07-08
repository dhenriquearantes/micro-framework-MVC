<?php

namespace App\Model;

use Library\Crud\Crud;

class Model extends Crud
{
  protected $table;

  public function find(int $id): array
  {
    return $this->select("", $this->table)
      ->where(['id', '=', $id])
      ->first();
  }

  public function all(): array
  {
    return $this->select("", $this->table)
      ->order(['id', 'asc'])
      ->get();
  }

  public function create($requestData)
  {
    return $this->insert()
      ->insertTable("", $this->table)
      ->into($requestData)
      ->values($requestData)
      ->get();
  }

  public function upgrade(int $id, array $requestData)
  {
    return $this->update() 
      ->updateTable("", $this->table)
      ->set($requestData)
      ->where(["id", "=", $id])
      ->get();
  }

  public function remove(int $id)
  {
    return $this->delete()
      ->deleteTable("", $this->table)
      ->where(["id", "=", $id])
      ->get();
  }

}
