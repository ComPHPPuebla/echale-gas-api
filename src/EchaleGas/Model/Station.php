<?php
namespace EchaleGas\Model;

use \Slim\Views\TwigExtension;
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
     * @param StationRepository $repository
     */
    public function __construct(StationRepository $repository)
    {
        $this->stationRepository = $repository;
    }

    public function retrieveAll(array $params)
    {
        $stations = new ResourceCollection();
        $resource = new Resource();
        $resource->setFormatter(new StationFormatter(new TwigExtension()));

        $stations->setResource($resource);

        $adapter = new FixedAdapter(
            $this->stationRepository->count(), $this->stationRepository->findAll($params)
        );
        $paginator = new Pagerfanta($adapter);

        $stations->setPaginator($paginator);

        return $stations->format($params, 'stations');
    }

}