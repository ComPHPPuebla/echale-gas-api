<?php
use \EchaleGas\Model\Station;
use \EchaleGas\Event\QuerySpecificationEvent;
use \EchaleGas\Doctrine\Query\PaginationFilter;
use \EchaleGas\Event\PaginationEvent;
use \EchaleGas\Repository\StationRepository;
use \Evenement\EventEmitter;

$app->container->singleton('stationRepository', function() use ($app) {

    return new StationRepository($app->connection);
});

$app->container->singleton('station', function() use ($app) {

    return new Station($app->stationsRepository);
});

$app->container->singleton('stationEmitter', function() use ($app) {
    $emitter = new EventEmitter();
    $emitter->on('preFetchAll', new QuerySpecificationEvent(new PaginationFilter()));

    return $emitter;
});

$app->container->singleton('stationsRepository', function() use ($app) {
    $stationRepository = $app->stationRepository;
    $stationRepository->setEmitter($app->stationEmitter);

    return $stationRepository;
});