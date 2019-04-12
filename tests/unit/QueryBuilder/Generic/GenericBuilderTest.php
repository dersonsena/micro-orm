<?php

use Dersonsena\ORM\QueryBuilder\Generic\GenericBuilder;
use Dersonsena\ORM\QueryBuilder\QueryBuilderException;

class GenericBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testSimplesSelectStatement()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->getSql();

        $this->assertEquals('SELECT users.* FROM users', $sql);
    }

    public function testSelectWithTableAliasStatement()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users', 'u')
            ->select()
            ->getSql();

        $this->assertEquals('SELECT u.* FROM users AS u', $sql);
    }

    public function testSelectWithColumnsListStatement()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->getSql();

        $this->assertEquals('SELECT users.name, users.email, users.password FROM users', $sql);
    }

    public function testSelectWithColumnsAndAliasesStatement()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['n' => 'name', 'e' => 'email', 'p' => 'password'])
            ->getSql();

        $this->assertEquals('SELECT users.name AS n, users.email AS e, users.password AS p FROM users', $sql);
    }

    /*public function testSelectWithASingleWhereClause()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->where(['name' => 'John'])
            ->getSql();

        $this->assertEquals("SELECT name, email, password FROM users WHERE users.name = 'John'", $sql);
    }

    public function testSelectWithAManyWhereClause()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->where([
                'name' => 'John',
                'email' => 'john@email.com.br'
            ])
            ->getSql();

        $this->assertEquals(
            "SELECT name, email, password FROM users WHERE users.name = 'John' AND users.email = 'john@email.com.br'",
            $sql
        );
    }

    public function testSelectWithAIntegerWhereClause()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['id'])
            ->where(['id' => 20])
            ->getSql();

        $this->assertEquals("SELECT id FROM users WHERE users.id = 20", $sql);
    }*/

    public function testSelectWithAStringOrderBy()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->orderBy('name ASC, email ASC')
            ->getSql();

        $this->assertEquals("SELECT users.* FROM users ORDER BY name ASC, email ASC", $sql);
    }

    public function testSelectWithASingleOrderBy()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->orderBy(['name' => 'ASC'])
            ->getSql();

        $this->assertEquals("SELECT users.name, users.email, users.password FROM users ORDER BY name ASC", $sql);
    }

    public function testSelectWithAManyOrdersBy()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->orderBy(['name' => 'ASC', 'email' => 'DESC', 'id' => 'ASC'])
            ->getSql();

        $this->assertEquals("SELECT users.name, users.email, users.password FROM users ORDER BY name ASC, email DESC, id ASC", $sql);
    }

    public function testSelectWithAInvalidDirection()
    {
        $genericBuilder = new GenericBuilder;

        $this->expectException(QueryBuilderException::class);
        $this->expectExceptionMessage('The direction "ASCCCCC" is invalid.');

        $sql = $genericBuilder->table('users')
            ->select(['name', 'email', 'password'])
            ->orderBy(['name' => 'ASCCCCC'])
            ->getSql();
    }

    public function testSelectWithALimit()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->limit(3)
            ->getSql();

        $this->assertEquals("SELECT users.* FROM users LIMIT 3", $sql);
    }

    public function testSelectWithAOffset()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->offset(10)
            ->getSql();

        $this->assertEquals("SELECT users.* FROM users OFFSET 10", $sql);
    }

    public function testSelectWithASingleInnerJoin()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->innerJoin('groups', 'id', 'group_id')
            ->getSql();

        $this->assertEquals('SELECT users.* FROM users INNER JOIN groups ON groups.id = users.group_id', $sql);
    }

    public function testSelectWithAInnerJoinWithColumns()
    {
        $genericBuilder = new GenericBuilder;

        $sql = $genericBuilder->table('users')
            ->select()
            ->innerJoin('groups', 'id', 'group_id', ['system_group', 'status'])
            ->getSql();

        $this->assertEquals('SELECT users.* FROM users INNER JOIN groups ON groups.id = users.group_id', $sql);
    }
}
