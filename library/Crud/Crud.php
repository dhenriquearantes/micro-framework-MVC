<?php

namespace Library\Crud;
use App\Database;

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
    

  }

}
