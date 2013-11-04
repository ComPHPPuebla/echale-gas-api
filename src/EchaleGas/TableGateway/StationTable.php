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

        $this->eventManager->trigger(
            'onFetchAll', $this, ['qb' => $qb, 'criteria' => $criteria]
        );

        return $qb;
    }

    /**
     * @param array $stationValues
     * @return array
     */
    public function insert(array $stationValues)
    {
        $this->eventManager->trigger('preInsert', $this, ['values' => &$stationValues]);

        return $this->doInsert('stations', $stationValues);
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
     * @param array $station
     * @param int $stationId
     * @return array
     */
    public function update(array $station, $stationId)
    {
        $this->eventManager->trigger('preUpdate', $this, ['values' => &$station]);

        $this->doUpdate('stations', $station, ['station_id' => $stationId]);

        return $this->find($stationId);
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
