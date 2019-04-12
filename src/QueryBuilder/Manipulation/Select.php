<?php

namespace Dersonsena\ORM\QueryBuilder\Manipulation;

use Dersonsena\ORM\QueryBuilder\Syntax\Table;

class Select
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var array
     */
    private $columns;

    public function __construct(Table $table, array $columns = [])
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function addColumn($column, $alias = null)
    {
        if (is_null($alias)) {
            $this->columns[] = $column;
            return;
        }

        $this->columns[$alias] = $column;
    }

    public function getSql(): string
    {
        $stringColumns = $this->table->getAliasOrName() . '.*';

        if (!empty($this->columns)) {
            $stringColumns = '';

            foreach ($this->columns as $alias => $column) {
                $stringColumns .= (!is_numeric($alias)
                    ? "{$this->table->getAliasOrName()}.{$column} AS {$alias}"
                    : $this->table->getAliasOrName() . '.' . $column
                ) . ', ';
            }

            $stringColumns = substr_replace($stringColumns, '', -2);
        }
        
        return sprintf('SELECT %s FROM %s', $stringColumns, $this->table->getTableNameWithAlias());
    }
}
