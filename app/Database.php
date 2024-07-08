<?php


namespace App;

use PDO;

class Database
{

  public static function createConnection(): PDO
  {
    
    $connection = new PDO(
        'pgsql:host=localhost;port=5432;dbname=mvc',
        'postgres',
        '123456'
      );
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    
    
    return $connection;
  }


}
