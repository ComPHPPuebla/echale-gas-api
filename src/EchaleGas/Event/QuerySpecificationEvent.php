<?php
namespace EchaleGas\Event;

use \EchaleGas\Doctrine\Specification\Criteria;
use \EchaleGas\Doctrine\Specification\QueryBuilderSpecification;
use \Doctrine\DBAL\Query\QueryBuilder;

class QuerySpecificationEvent
{
    /**
     * @var QueryBuilderSpecification
     */
    protected $specification;

    /**
     * @param BaseSpecification $specification
     * @param array $criteria
     */
    public function __construct(QueryBuilderSpecification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $criteria
     */
    public function __invoke(QueryBuilder $qb, array $criteria)
    {
        $this->specification->setCriteria($criteria);
        $this->specification->match($qb);
    }
}