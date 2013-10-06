<?php
use \Slim\Views\TwigExtension;
use \EchaleGas\Hypermedia\HAL\StationFormatter;
use \EchaleGas\Model\Station;
use \EchaleGas\Event\QuerySpecificationEvent;
use \EchaleGas\Doctrine\Query\PaginationFilter;
use \EchaleGas\Event\PaginationEvent;
use \EchaleGas\Repository\StationRepository;
use \Evenement\EventEmitter;

$app->container->singleton('stationRepository', function() use ($app) {
    $stationRepository = new StationRepository($app->connection);
    $stationRepository->setEmitter($app->stationEmitter);

    return $stationRepository;
});

$app->container->singleton('station', function() use ($app) {

    return new Station($app->stationRepository, $app->stationFormatter);
});

$app->container->singleton('stationFormatter', function() {

    return new StationFormatter(new TwigExtension());
});

$app->container->singleton('stationEmitter', function() use ($app) {
    $emitter = new EventEmitter();
    $emitter->on('preFetchAll', new QuerySpecificationEvent(new PaginationFilter()));

    return $emitter;
});
