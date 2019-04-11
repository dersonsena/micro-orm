<?php

namespace Dersonsena\ORM\QueryBuilder\Generic;

use Dersonsena\ORM\QueryBuilder\BuilderInterface;
use Dersonsena\ORM\QueryBuilder\Manipulation\ManipulationFactory;
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
     * @var OrderBy
     */
    private $order;
    
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
        $this->rawSql = $this->select->getSql();

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
            
            $alias = (!empty($this->table->tableAlias) ? $this->table->tableAlias : $this->table->getName());
            $sql .= "{$alias}.{$field} = {$newValue}";
            $i++;
        }

        $this->rawSql .= $sql;
        
        return $this;
    }

    public function orderBy($order)
    {
        $this->order = SyntaxFactory::createOrderBy($order);
        $this->rawSql .= $this->order->getSql();

        return $this;
    }

    public function limit(int $limit)
    {
        $this->rawSql .= sprintf(" LIMIT %s", $limit);
        return $this;
    }

    public function offset(int $offset)
    {
        $this->rawSql .= sprintf(" OFFSET %s", $offset);
        return $this;
    }

    public function getSql()
    {
        return $this->rawSql;
    }
}
