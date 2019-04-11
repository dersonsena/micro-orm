<?php

namespace Dersonsena\ORM\Drivers\Generic;

use Dersonsena\ORM\Drivers\BuilderInterface;

class GenericBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $tableAlias;

    /**
     * @var string
     */
    private $rawSql;

    public function table(string $name, string $alias = '')
    {
        $this->table = $name;
        $this->tableAlias = $alias;
        return $this;
    }

    public function select(array $columns = [])
    {
        $stringColumns = '*';

        if (!empty($columns)) {
            $stringColumns = '';

            foreach ($columns as $alias => $column) {
                $stringColumns .= (!is_numeric($alias) ? "{$column} AS {$alias}" : $column) . ', ';
            }

            $stringColumns = substr_replace($stringColumns, '', -2);
        }
        
        $this->rawSql = sprintf('SELECT %s FROM %s', $stringColumns, $this->getTableName());

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
            
            $alias = (!empty($this->tableAlias) ? $this->tableAlias : $this->table);
            $sql .= "{$alias}.{$field} = {$newValue}";
            $i++;
        }

        $this->rawSql .= $sql;
        
        return $this;
    }

    public function orderBy(array $order)
    {
        $sql = ' ORDER BY ';
        $i = 0;

        foreach ($order as $field => $direction) {
            if ($i > 0) {
                $sql .= ", ";
            }

            $sql .= "{$field} {$direction}";
            $i++;
        }

        $this->rawSql .= $sql;

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

    protected function getTableName()
    {
        $alias = (!empty($this->tableAlias) && !is_null($this->tableAlias) ? " AS {$this->tableAlias}" : '');
        return $this->table . $alias;
    }
}