<?php
namespace EchaleGas\Repository;

use EchaleGas\Doctrine\BaseRepository;

class StationRepository extends BaseRepository
{
    public function findAll(array $params = [])
    {
        $qb = $this->createQueryBuilder();

        $qb->select('*')
           ->from('stations', 's');

        $this->emitter->emit('preFetchAll', [$qb, $params]);

        return $this->fetchAll($qb->getSQL());
    }

    public function insert($stationValues)
    {
        return $this->doInsert('stations', $stationValues);
    }

    public function find($stationId)
    {
        $qb = $this->createQueryBuilder();
        $qb->select('*')
           ->from('stations', 's')
           ->where('s.station_id = :stationId');

        $qb->setParameter('stationId', $stationId);

        return $this->fetchAssoc($qb->getSQL(), $qb->getParameters());
    }

    public function update($station, $stationId)
    {
        $this->doUpdate('stations', $station, ['station_id' => $stationId]);
    }

    public function delete($stationId)
    {
        $this->doDelete('stations', ['station_id' => $stationId]);
    }
}