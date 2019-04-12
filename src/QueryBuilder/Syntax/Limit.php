<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

class Limit
{
    private $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    public function getSql()
    {
        return sprintf('LIMIT %s', $this->limit);
    }
}
