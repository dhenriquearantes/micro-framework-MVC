<?php

namespace App\Model;

use App\Database;
use PDO;

abstract class Model
{
  protected static $table;

  public static function find(int $id): array
  {
    $pdo = Database::createConnection();
    $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
    try {
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo $e->getMessage();
    }


  }

  public static function all(): array
  {
    $pdo = Database::createConnection();
    $stmt = $pdo->prepare("SELECT * FROM " . static::$table);
    try {
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo $e->getMessage(); 
    }
  }

  public static function create(array $data): bool
  {
    $pdo = Database::createConnection();

    date_default_timezone_set('America/Sao_Paulo');
    $currentDateTime = date('Y-m-d H:i:s');

    $data['created_at'] = $currentDateTime;
    $data['updated_at'] = $currentDateTime;

    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($values)";

    try {
      $stmt = $pdo->prepare($sql);
  
      foreach ($data as $key => &$value) {
        $stmt->bindParam(":$key", $value);
      }
      return $stmt->execute();
      
    } catch (\PDOException $e) {
      echo $e->getMessage(); 
    }
  }

  public static function update(int $id, array $requestData): bool
  {
    $pdo = Database::createConnection();

    date_default_timezone_set('America/Sao_Paulo');
    $currentDateTime = date('Y-m-d H:i:s');

    $requestData['updated_at'] = $currentDateTime;

    $setClause = [];
    foreach ($requestData as $key => $value) {
      $setClause[] = "$key = :$key";
    }

    $sql = "UPDATE " . static::$table . " SET " . implode(", ", $setClause) . " WHERE id = :id";

    try {
      $stmt = $pdo->prepare($sql);
  
      foreach ($requestData as $key => &$value) {
        $stmt->bindParam(":$key", $value);
      }
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      return $stmt->execute();

    } catch (\PDOException $e) {
      echo $e->getMessage(); 
    }
  }


  public static function delete(int $id)
  {
    $pdo = Database::createConnection();
    $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
    try {      
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (\PDOException $e) {
      echo $e->getMessage(); 
    }
  }
}
