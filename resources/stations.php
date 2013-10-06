<?php
use \EchaleGas\Event\QuerySpecificationEvent;
use \EchaleGas\Doctrine\Query\PaginationFilter;
use \EchaleGas\Event\PaginationEvent;
use \EchaleGas\Repository\StationRepository;
use \Evenement\EventEmitter;

$app->container->singleton('stationRepository', function() use ($app) {

    return new StationRepository($app->connection);
});

$app->container->singleton('stationsRepository', function() use ($app) {

    $stationRepository = $app->stationRepository;

    $emitter = new EventEmitter();
    $emitter->on('preFetchAll', new QuerySpecificationEvent(new PaginationFilter()));

    $stationRepository->setEmitter($emitter);

    return $stationRepository;
});