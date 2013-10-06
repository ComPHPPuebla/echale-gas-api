<?php
namespace EchaleGas\Doctrine\Query;

use \Doctrine\DBAL\Query\QueryBuilder;

class PaginationFilter extends BaseSpecification
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;

    /**
     * @return int
     */
    public function calculateOffset()
    {
        return $this->pageSize * ($this->page - 1);
    }

    /**
     * @see \EchaleGas\Doctrine\Query\Specification::match()
     */
    public function match(QueryBuilder $qb)
    {
        if (isset($this->criteria['page'])) {

            $this->page = $this->criteria['page'];
            $this->pageSize = 2; //Default size

            if (isset($this->criteria['page_size'])) {

                $this->pageSize = $this->criteria['page_size'];
            }

            $qb->setFirstResult($this->calculateOffset())->setMaxResults($this->pageSize);
        }
    }
}