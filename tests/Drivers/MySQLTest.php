<?php

class MySQLTest extends PHPUnit\Framework\TestCase
{
    public function testTestingSelectMethod()
    {
        $mysql = new Dersonsena\ORM\Drivers\MySQL;
        $this->assertEquals(null, $mysql->select());
    }
}