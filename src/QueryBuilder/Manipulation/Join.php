<?php

namespace Dersonsena\ORM\QueryBuilder\Manipulation;

use Dersonsena\ORM\QueryBuilder\Syntax\Table;

class Join
{
    const JOIN_LEFT = 'LEFT';
    const JOIN_RIGHT = 'RIGHT';
    const JOIN_INNER = 'INNER';
    const JOIN_CROSS = 'CROSS';

    /**
     * @var Table
     */
    private $table;

    /**
     * @var Table
     */
    private $refTable;

    /**
     * @var Select
     */
    private $select;

    /**
     * @var string
     */
    private $selfColumn;

    /**
     * @var string
     */
    private $refColumn;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var string
     */
    private $joinType;

    public function __construct(
        Table $table,
        string $selfColumn,
        string $refColumn,
        array $columns = [],
        string $joinType = self::JOIN_INNER
    ) {
        $this->table = $table;
        $this->selfColumn = $selfColumn;
        $this->refColumn = $refColumn;
        $this->columns = $columns;
        $this->joinType = $joinType;
    }

    public function setRefTable(Table $table)
    {
        $this->refTable = $table;
    }

    public function setSelect(Select $select)
    {
        $this->select = $select;
    }

    public function getSql(): string
    {
        return sprintf(
            '%s JOIN %s ON %s.%s = %s.%s',
            $this->joinType,
            $this->table,
            $this->table,
            $this->selfColumn,
            $this->refTable->getName(),
            $this->refColumn
        );
    }
}
