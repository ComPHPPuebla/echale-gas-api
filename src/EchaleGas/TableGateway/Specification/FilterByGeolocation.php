<?php
namespace EchaleGas\TableGateway\Specification;

use \ComPHPPuebla\Doctrine\TableGateway\Specification\QueryBuilderSpecification;
use \Doctrine\DBAL\Query\QueryBuilder;

class FilterByGeolocation extends QueryBuilderSpecification
{
	/**
	 * @see \ComPHPPuebla\Doctrine\TableGateway\Specification\QueryBuilderSpecification::match()
	 */
	public function match(QueryBuilder $qb)
	{
		if ($this->has('latitude') && $this->has('longitude')) {

		    $qb->addSelect(<<<SELECT
    (6371
    * (2 * ATAN(SQRT(SIN(((:latitude - s.latitude) * (PI()/180))/2) * SIN(((:latitude - s.latitude) * (PI()/180))/2)
    + COS(:latitude * (PI()/180)) * COS(s.latitude * (PI()/180))
    * SIN(((:longitude - s.longitude) * (PI()/180))/2) * SIN(((:longitude - s.longitude) * (PI()/180))/2)),
            SQRT(1-(sin(((:latitude - s.latitude) * (PI()/180))/2) * SIN(((:latitude - s.latitude) * (PI()/180))/2)
    + COS(:latitude * (PI()/180) * COS(s.latitude * (PI()/180)
    * SIN(((:longitude - s.longitude) * (PI()/180))/2) * SIN(((:longitude - s.longitude) * (PI()/180))/2))))))))
    AS distance
SELECT
            );
		    $qb->orderBy('distance');
		    $qb->setParameter('latitude', $this->get('latitude'));
		    $qb->setParameter('longitude', $this->get('longitude'));
	   }
	}
}
