<?php
namespace EchaleGas\Doctrine\Query;

abstract class BaseSpecification implements Specification
{
    /**
     * @var array
     */
    protected $criteria;

    /**
     * @param array $criteria
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
    }
}