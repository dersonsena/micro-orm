<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

use Dersonsena\ORM\QueryBuilder\Manipulation\Join;

final class SyntaxFactory
{
    public static function createTable(string $name, string $alias = ''): Table
    {
        return new Table($name, $alias);
    }

    public static function createOrderBy($order): OrderBy
    {
        return new OrderBy($order);
    }

    public static function createLimit(int $limit)
    {
        return new Limit($limit);
    }

    public static function createOffset(int $offset)
    {
        return new Offset($offset);
    }

    public static function createJoin(
        string $table,
        string $selfColumn,
        string $refColumn,
        array $columns,
        string $joinType
    ): Join {
        $table = static::createTable($table);
        return new Join($table, $selfColumn, $refColumn, $columns, $joinType);
    }
}
