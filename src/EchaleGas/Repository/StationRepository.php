<?php
namespace EchaleGas\Repository;

use \EchaleGas\Doctrine\BaseRepository;

class StationRepository extends BaseRepository
{
    /**
     * @param array $params
     * @return array
     */
    public function findAll(array $params = [])
    {
        $qb = $this->createQueryBuilder();

        $qb->select('*')
           ->from('stations', 's');

        $this->emitter->emit('preFetchAll', [$qb, $params]);

        return $this->fetchAll($qb->getSQL());
    }

    /**
     * @return array
     */
    public function insert($stationValues)
    {
        return $this->doInsert('stations', $stationValues);
    }

    /**
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
     * @return void
     */
    public function update($station, $stationId)
    {
        $this->doUpdate('stations', $station, ['station_id' => $stationId]);
    }

    /**
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