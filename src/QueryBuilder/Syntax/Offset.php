<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

class Offset
{
    private $offset;

    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    public function getSql()
    {
        return sprintf('OFFSET %s', $this->offset);
    }
}