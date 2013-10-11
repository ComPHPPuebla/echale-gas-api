<?php
namespace EchaleGas\Event;

use \Zend\EventManager\Event;
use \EchaleGas\Doctrine\Specification\QueryBuilderSpecification;

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
    public function __invoke(Event $event)
    {
        $this->specification->setCriteria($event->getParam('criteria'));
        $this->specification->match($event->getParam('qb'));
    }
}