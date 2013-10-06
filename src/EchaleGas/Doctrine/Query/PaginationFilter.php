<?php
namespace EchaleGas\Doctrine\Query;

use \Doctrine\DBAL\Query\QueryBuilder;

class PaginationFilter extends BaseSpecification
{
    protected $page;

    protected $pageSize;

    public function calculateOffset()
    {
        return $this->pageSize * ($this->page - 1);
    }

    public function match(QueryBuilder $qb)
    {
        if (isset($this->criteria['page'])) {

            $this->page = $this->criteria['page'];
            $this->pageSize =  isset($this->criteria['page_size'])
                            ? $this->criteria['page_size']
                            : 100;

            $qb->setFirstResult($this->calculateOffset())->setMaxResults($this->pageSize);
        }
    }
}