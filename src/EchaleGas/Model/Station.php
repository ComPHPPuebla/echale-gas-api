<?php
namespace EchaleGas\Model;

use \Pagerfanta\Adapter\FixedAdapter;
use \Pagerfanta\Pagerfanta;
use \EchaleGas\Resource\Resource;
use \EchaleGas\Resource\ResourceCollection;
use \EchaleGas\Repository\StationRepository;
use \EchaleGas\Hypermedia\HAL\StationFormatter;

class Station
{
    /**
     * @var StationRepository
     */
    protected $stationRepository;

    /**
     * @var StationFormatter
     */
    protected $formatter;

    /**
     * @param StationRepository $repository
     */
    public function __construct(StationRepository $repository, StationFormatter $formatter)
    {
        $this->stationRepository = $repository;
        $this->formatter = $formatter;
    }

    /**
     * @param array $params
     * @params array $pageSize
     * @return array
     */
    public function retrieveAll(array $params, $pageSize)
    {
        $stations = new ResourceCollection($this->formatter);

        $adapter = new FixedAdapter(
            $this->stationRepository->count(), $this->stationRepository->findAll($params)
        );
        $paginator = new Pagerfanta($adapter);
        $paginator->setMaxPerPage($pageSize);

        $stations->setPaginator($paginator);

        return $stations->format($params, 'stations');
    }

    /**
     * @param int $stationId
     * @return array
     */
    public function retrieveOne($stationId)
    {
        $station = $this->stationRepository->find($stationId);

        $resource = new Resource($this->formatter);

        return $resource->format($station);
    }

    /**
     * @param array $newStation
     * @return array
     */
    public function newStation(array $newStation)
    {
        $stationId = $this->stationRepository->insert($newStation);

        $newStation['station_id'] = $stationId;

        $resource = new Resource($this->formatter);

        return $resource->format($newStation);
    }

    /**
     * @param array $station
     * @param int $stationId
     * @return array
     */
    public function updateStation(array $station, $stationId)
    {
        $this->stationRepository->update($station, $stationId);

        $station = $this->stationRepository->find($stationId);

        $resource = new Resource($this->formatter);

        return $resource->format($station);
    }

    /**
     * @param int $stationId
     */
    public function deleteStation($stationId)
    {
        $this->stationRepository->delete($id);
    }

    /**
     * @return string
     */
    public function getCollectionOptions()
    {
        return implode(',', ['GET', 'POST']);
    }

    /**
     * @return string
     */
    public function getResourceOptions()
    {
        return implode(',', ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD']);
    }
}
