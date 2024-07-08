
<?php

require_once __DIR__ . '/../../vendor/autoload.php';


use Library\Crud\Select;
use PHPUnit\Framework\TestCase;

final class SelectTest extends TestCase
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
