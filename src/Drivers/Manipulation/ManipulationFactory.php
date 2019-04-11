<?php

namespace Dersonsena\ORM\Drivers\Manipulation;

final class ManipulationFactory
{
    public static function createTable(string $name, string $alias = '')
    {
        return new Table($name, $alias);
    }

    public static function createSelect(Table $table, array $columns = []): Select
    {
        return new Select($table, $columns);
    }
}
