<?php
namespace EchaleGas\TableGateway;

use \Doctrine\DBAL\Query\QueryBuilder;
use \ComPHPPuebla\Doctrine\TableGateway\Table;

class StationTable extends Table
{
    /**
     * @param array $criteria
     * @return array
     */
    public function findAll(array $criteria)
    {
        $qb = $this->createQueryBuilder();

        $qb->select('*')->from('stations', 's');

        return $qb;
    }

    /**
     * @param array $values
     * @return array
     */
    public function insert(array $values)
    {
        return $this->doInsert('stations', $values);
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
        $this->doUpdate('stations', $values, ['station_id' => $id]);

        return $this->find($id);
    }

    /**
     * @param int $stationId
     * @return void
     */
    public function delete($stationId)
    {
        $this->doDelete('stations', ['station_id' => $stationId]);
    }

    /**
     * @param QueryBuilder $qb
     */
    public function count(QueryBuilder $qb)
    {
         $qb->select('COUNT(*)');
    }
}
