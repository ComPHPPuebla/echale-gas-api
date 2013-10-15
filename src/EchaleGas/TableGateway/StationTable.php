<?php
namespace EchaleGas\TableGateway;

use ComPHPPuebla\Doctrine\TableGateway\Table;

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
            'configureFetchAll', $this, ['qb' => $qb, 'criteria' => $criteria]
        );

        return $this->fetchAll($qb->getSQL());
    }

    /**
     * @param array $stationValues
     * @return array
     */
    public function insert(array $stationValues)
    {
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
     * return int
     */
    public function count(array $params = [])
    {
        $qb = $this->createQueryBuilder();

        $qb->select('COUNT(*)')
           ->from('stations', 's');

        return $this->fetchColumn($qb->getSQL());
    }
}
