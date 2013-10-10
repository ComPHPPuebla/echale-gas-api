<?php
namespace EchaleGas\Repository;

use \EchaleGas\Repository\Repository;

class StationRepository extends Repository
{
    /**
     * @param array $criteria
     * @return array
     */
    public function findAll(array $criteria)
    {
        $qb = $this->createQueryBuilder();

        $qb->select('*')->from('stations', 's');

        $this->emitter->emit('configureFetchAll', [$qb, $criteria]);

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
     * @return void
     */
    public function update(array $station, $stationId)
    {
        $this->doUpdate('stations', $station, ['station_id' => $stationId]);
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
    public function count()
    {
        $qb = $this->createQueryBuilder();

        $qb->select('COUNT(*)')
           ->from('stations', 's');

        return $this->fetchColumn($qb->getSQL());
    }
}
