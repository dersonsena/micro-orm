<?php
use Dersonsena\ORM\QueryBuilder\Syntax\SyntaxFactory;
use Dersonsena\ORM\QueryBuilder\QueryBuilderException;

class OrderByTest extends \PHPUnit\Framework\TestCase
{
    public function testOrderWithInvalidParam()
    {
        $this->expectException(QueryBuilderException::class);
        $this->expectExceptionMessage('The "order" param should be a array or a string');

        $orderBy = SyntaxFactory::createOrderBy(23);
    }
}
