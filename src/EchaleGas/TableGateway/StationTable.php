<?php
namespace EchaleGas\TableGateway;

use \Doctrine\DBAL\Query\QueryBuilder;
use \ComPHPPuebla\Doctrine\TableGateway\Table;

class StationTable extends Table
{
    /**
     * @param array $values
     * @return array
     */
    public function insert(array $values)
    {
        return $this->doInsert($values);
    }

    /**
     * @param int
     * @return array
     */
    public function find($stationId)
    {
        $qb = $this->createQueryBuilder();
        $qb->select('*')
           ->from('stations', 's')
           ->where('s.station_id = :stationId');

        $qb->setParameter('stationId', $stationId);

        return $this->fetchAssoc($qb->getSQL(), $qb->getParameters());
    }

    /**
     * @param array $values
     * @param int $id
     * @return array
     */
    public function update(array $values, $id)
    {
        $this->doUpdate($values, ['station_id' => $id]);

        return $this->find($id);
    }

    /**
     * @param int $stationId
     * @return void
     */
    public function delete($stationId)
    {
        $this->doDelete(['station_id' => $stationId]);
    }

    /**
     * @param array $criteria
     * @return QueryBuilder
     */
    protected function getQueryCount(array $criteria)
    {
        $qb = clone $this->getQueryFindAll($criteria);
        $qb->select('COUNT(*)')->resetQueryPart('orderBy');

        return $qb;
    }

    /**
     * @param array $criteria
     * @return QueryBuilder
     */
    protected function getQueryFindAll(array $criteria)
    {
        $qb = $this->createQueryBuilder();

        $qb->select('*')->from('stations', 's');

        return $qb;
    }
}
