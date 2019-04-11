<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

final class SyntaxFactory
{
    public static function createTable(string $name, string $alias = ''): Table
    {
        return new Table($name, $alias);
    }
}
