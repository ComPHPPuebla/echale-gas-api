<?php
namespace EchaleGas\Doctrine\Query;

use Doctrine\DBAL\Query\QueryBuilder;

class ChainedSpecification implements BaseSpecification
{
    /**
     * @var array
     */
    protected $specifications;

    /**
     * Initialize the specifications array
     */
    public function __construct()
    {
        $this->specifications = [];
    }

    /**
     * @param Specification $specification
     */
    public function addSpecification(Specification $specification)
    {
        $this->specifications[] = $specification;
    }

    /**
     * @param QueryBuilder $qb
     */
    public function match(QueryBuilder $qb)
    {
        foreach ($this->specifications as $specification) {

            $specification->setCriteria($this->criteria);
            $specification->match($qb);
        }
    }
}