<?php

namespace Dersonsena\ORM\QueryBuilder\Syntax;

use Dersonsena\ORM\QueryBuilder\QueryBuilderException;

class OrderBy
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var string|array
     */
    private $order;

    public function __construct($order)
    {
        if (!is_array($order) && !is_string($order)) {
            throw new QueryBuilderException('The "order" param should be a array or a string');
        }

        $this->order = $order;
    }

    public function getSql()
    {
        if (is_string($this->order)) {
            return $this->executeStringLogic();
        }

        return $this->executeArrayLogic();
    }

    private function executeStringLogic()
    {
        return ' ORDER BY ' . $this->order;
    }

    private function executeArrayLogic()
    {
        $sql = ' ORDER BY ';
        $i = 0;

        foreach ($this->order as $field => $direction) {
            if (!in_array($direction, [static::ASC, static::DESC])) {
                throw new QueryBuilderException('The direction "'. $direction .'" is invalid.');
            }

            if ($i > 0) {
                $sql .= ", ";
            }

            $sql .= "{$field} {$direction}";
            $i++;
        }

        return $sql;
    }
}
