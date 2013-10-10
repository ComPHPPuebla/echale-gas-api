<?php
namespace EchaleGas\Model;

use EchaleGas\Validator\Validator;

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

    /**
     * @param array $criteria
     * @param ResourceCollection $resources
     */
    public function retrieveAll(array $criteria, ResourceCollection $resources)
    {
        $resources->setFormatter($this->formatter);
        $resources->setItems(
            $this->repository->findAll($criteria), $this->repository->count()
        );

        return $resources->formatCollection($criteria, $this->routeName);
    }

    /**
     * @param int $id
     * @param Resource $resource
     * @return array
     */
    public function retrieveOne($id, Resource $resource)
    {
        $resourceValues = $this->repository->find($id);

        if (!$resourceValues) {

            return;
        }
        $resource->setFormatter($this->formatter);

        return $resource->format($resourceValues);
    }

    /**
     * @param array $newResource
     * @param Resource $resource
     * @return array
     */
    public function create(array $newResource, Resource $resource)
    {
        $id = $this->repository->insert($newResource);
        $newResource = $this->repository->find($id);
        $resource->setFormatter($this->formatter);

        return $resource->format($newResource);
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
