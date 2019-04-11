<?php
use Dersonsena\ORM\QueryBuilder\Syntax\SyntaxFactory;

class TableTest extends \PHPUnit\Framework\TestCase
{
    public function testTableWithoutAlias()
    {
        $table = SyntaxFactory::createTable('users');
        $this->assertEquals('users', $table->getTableNameWithAlias());
    }

    public function testTableWithAlias()
    {
        $table = SyntaxFactory::createTable('users', 'u');
        $this->assertEquals('users AS u', $table->getTableNameWithAlias());
    }

    public function testConvertObjectToString()
    {
        $table = SyntaxFactory::createTable('users');
        $this->assertEquals('users', $table);
    }
}
