<?php
namespace EchaleGas\Model;

use \EchaleGas\Hypermedia\Formatter;
use \EchaleGas\Doctrine\Repository;
use \EchaleGas\Resource\Resource;
use \EchaleGas\Resource\ResourceCollection;

class Model
{
    /**
     * @var array
     */
    protected $optionsList;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var repository
     */
    protected $repository;

    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @param StationRepository $repository
     */
    public function __construct(Repository $repository, Formatter $formatter, $routeName)
    {
        $this->repository = $repository;
        $this->formatter = $formatter;
        $this->routeName = $routeName;
        $this->optionsList = ['GET', 'POST', 'OPTIONS'];
        $this->options = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD'];
    }

    public function retrieveAll(array $criteria, ResourceCollection $stations)
    {
        $stations->setFormatter($this->formatter);
        $stations->setItems(
            $this->repository->findAll($criteria), $this->repository->count()
        );

        return $stations->formatCollection($criteria, $this->routeName);
    }

    /**
     * @param int $stationId
     * @param Resource $resource
     * @return array
     */
    public function retrieveOne($stationId, Resource $resource)
    {
        $station = $this->repository->find($stationId);
        $resource->setFormatter($this->formatter);

        return $resource->format($station);
    }

    /**
     * @param array $newStation
     * @param Resource $resource
     * @return array
     */
    public function create(array $newStation, Resource $resource)
    {
        $stationId = $this->repository->insert($newStation);
        $newStation = $this->repository->find($stationId);
        $resource->setFormatter($this->formatter);

        return $resource->format($newStation);
    }

    /**
     * @param array $station
     * @param int $stationId
     * @param Resource $resource
     * @return array
     */
    public function update(array $station, $stationId, Resource $resource)
    {
        $this->repository->update($station, $stationId);
        $station = $this->repository->find($stationId);
        $resource->setFormatter($this->formatter);

        return $resource->format($station);
    }

    /**
     * @param int $stationId
     */
    public function delete($stationId)
    {
        $this->repository->delete($stationId);
    }
}