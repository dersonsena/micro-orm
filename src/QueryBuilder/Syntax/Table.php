<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getAliasOrName(): string
    {
        if (!empty($this->alias)) {
            return $this->alias;
        }

        return $this->name;
    }

    public function getTableNameWithAlias(): string
    {
        $alias = (!empty($this->alias) && !is_null($this->alias) ? " AS {$this->alias}" : '');
        return $this->name . $alias;
    }
}
