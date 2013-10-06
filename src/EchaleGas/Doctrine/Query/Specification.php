<?php
namespace EchaleGas\Doctrine\Query;

use \Doctrine\DBAL\Query\QueryBuilder;

interface Specification
{
    /**
     * Add/Modify conditions in the query builder
     *
     * @param QueryBuilder $qb
     */
    public function match(QueryBuilder $qb);
}