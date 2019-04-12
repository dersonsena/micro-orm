<?php

namespace Dersonsena\ORM\QueryBuilder\Generic;

use Dersonsena\ORM\QueryBuilder\BuilderInterface;
use Dersonsena\ORM\QueryBuilder\Manipulation\Join;
use Dersonsena\ORM\QueryBuilder\Manipulation\ManipulationFactory;
use Dersonsena\ORM\QueryBuilder\Manipulation\Select;
use Dersonsena\ORM\QueryBuilder\Syntax\Limit;
use Dersonsena\ORM\QueryBuilder\Syntax\Offset;
use Dersonsena\ORM\QueryBuilder\Syntax\Table;
use Dersonsena\ORM\QueryBuilder\Syntax\SyntaxFactory;
use Dersonsena\ORM\QueryBuilder\Syntax\OrderBy;

class GenericBuilder implements BuilderInterface
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var Select
     */
    private $select;

    /**
     * @var Join
     */
    private $join;

    /**
     * @var OrderBy
     */
    private $order;

    /**
     * @var Limit
     */
    private $limit;

    /**
     * @var Offset
     */
    private $offset;
    
    /**
     * @var string
     */
    private $rawSql;

    public function table(string $name, string $alias = '')
    {
        $this->table = SyntaxFactory::createTable($name, $alias);
        return $this;
    }

    public function select(array $columns = [])
    {
        $this->select = ManipulationFactory::createSelect($this->table, $columns);
        return $this;
    }

    public function innerJoin(string $table, string $selfColumn, string $refColumn, array $columns = [])
    {
        $this->join = SyntaxFactory::createJoin($table, $selfColumn, $refColumn, $columns, Join::JOIN_INNER);
        $this->join->setRefTable($this->table);
        $this->join->setSelect($this->select);

        return $this;
    }

    public function where(array $conditions)
    {
        $sql = ' WHERE ';
        $i = 0;

        foreach ($conditions as $field => $value) {
            if ($i > 0) {
                $sql .= ' AND ';
            }

            $newValue = (is_numeric($value) ? $value : "'{$value}'");
            
            $alias = (!empty($this->table->getAlias()) ? $this->table->getAlias() : $this->table->getName());
            $sql .= "{$alias}.{$field} = {$newValue}";
            $i++;
        }

        $this->rawSql .= $sql;
        
        return $this;
    }

    public function orderBy($order)
    {
        $this->order = SyntaxFactory::createOrderBy($order);
        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = SyntaxFactory::createLimit($limit);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->offset = SyntaxFactory::createOffset($offset);
        return $this;
    }

    public function getSql()
    {
        $sql = $this->select->getSql();

        if ($this->join) {
            $sql .=  ' ' . $this->join->getSql();
        }

        if ($this->order) {
            $sql .= ' ' . $this->order->getSql();
        }

        if ($this->limit) {
            $sql .= ' ' . $this->limit->getSql();
        }

        if ($this->offset) {
            $sql .= ' ' . $this->offset->getSql();
        }

        return $sql;
    }
}
