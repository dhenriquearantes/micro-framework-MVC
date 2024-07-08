<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Library\Crud\Insert;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Test;

final class InsertTest extends TestCase
{
    private $sql;

    protected function setUp(): void
    {
        $this->sql = new Insert();
    }

    #[Test]
    public function testSimpleInsert(): void
    {
        $insertData = [
            'id' => 1,
            'nome' => 'João da Silva',
        ];

        $output = $this->sql->insertTable('rh', 'pessoa')->into($insertData)->values($insertData)->getSqlRaw();
        $this->assertEquals("INSERT INTO rh.pessoa (id, nome) VALUES (1,'João da Silva');", $output);
    }

    #[TestCase]
    public function testInsertBatch(): void
    {
        $insertData = [
            [
                'id' => 1,
                'nome' => 'João da Silva',
            ],
            [
                'id' => 2,
                'nome' => 'Maria da Silva',
            ],
        ];

        $output = $this->sql->insertTable('rh', 'pessoa')->into($insertData[0])->values($insertData[0])->values($insertData[1])->getSqlRaw();
        $this->assertEquals("INSERT INTO rh.pessoa (id, nome) VALUES (1,'João da Silva'), (2,'Maria da Silva');", $output);
    }
}