<?php

namespace Dersonsena\ORM\Drivers;

interface DriverInterface
{
    public function select(array $fields = []); // recurso de alias
    public function table(string $tableName);

    public function join(string $joinTable, string $originField, string $joinColumn, array $columns = []);
    public function leftJoin(string $joinTable, string $originField, string $joinColumn, array $columns = []);
    public function rightJoin(string $joinTable, string $originField, string $joinColumn, array $columns = []);
    public function innerJoin(string $joinTable, string $originField, string $joinColumn, array $columns = []);
    public function crossJoin(string $joinTable, string $originField, string $joinColumn, array $columns = []);

    // inner join table1 on table1.field1 = x.field2

    public function where(string $field, string $operand, $value);
    public function andWhere(string $field, string $operand, $value);
    public function orWhere(string $field, string $operand, $value);

    public function orderBy(string $field, string $direction);
    public function limit(int $limit);

    public function save();
    public function insert();
    public function update(array $conditions = []);
    public function delete(array $conditions = []);

    public function execute(string $sql = null);
    public function findOne(array $conditions = []);
    public function findAll(array $conditions = []);
}
