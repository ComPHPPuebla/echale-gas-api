<?php
namespace EchaleGas\Event;

use EchaleGas\Doctrine\Query\BaseSpecification;
use Doctrine\DBAL\Query\QueryBuilder;

class QuerySpecificationEvent
{
    /**
     * @var BaseSpecification
     */
    protected $specification;

    /**
     * @var array
     */
    protected $criteria;

    /**
     * @param BaseSpecification $specification
     * @param array $criteria
     */
    public function __construct(BaseSpecification $specification, array $criteria = [])
    {
        $this->specification = $specification;
        $this->criteria = $criteria;
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