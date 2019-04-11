<?php

namespace Dersonsena\ORM\QueryBuilder\Manipulation;

use Dersonsena\ORM\QueryBuilder\Syntax\Table;

final class ManipulationFactory
{
    public static function createSelect(Table $table, array $columns = []): Select
    {
        return new Select($table, $columns);
    }
}
