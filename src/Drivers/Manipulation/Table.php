<?php

namespace Dersonsena\ORM\Drivers\Manipulation;

class Table
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $alias;

    public function __construct(string $name, string $alias = '')
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getTableNameWithAlias()
    {
        $alias = (!empty($this->tableAlias) && !is_null($this->tableAlias) ? " AS {$this->tableAlias}" : '');
        return $this->table . $alias;
    }
}
