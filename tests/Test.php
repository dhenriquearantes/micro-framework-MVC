<?php

namespace Tests;

use Library\Crud\Select;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

  private $sql;

  protected function setUp(): void
  {
      $this->sql = new Select();
  }

  public function testSimpleSelectWithTableName(): void
  {
      $output = $this->sql->selectTable('rh', 'documento')->getSqlRaw();
      $this->assertEquals('SELECT * FROM rh.documento', $output);
  }

  public function testSimpleSelect(): void
  {
      $output = $this->sql->selectTable('rh','pessoa')->getSqlRaw();
      $this->assertEquals('SELECT * FROM rh.pessoa', $output);
  }



}
