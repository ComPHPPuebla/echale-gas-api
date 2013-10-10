<?php
use EchaleGas\Validator\ValitronValidator;

use \EchaleGas\Model\Model;
use \EchaleGas\Hypermedia\HAL\StationFormatter;
use \EchaleGas\Event\QuerySpecificationEvent;
use \EchaleGas\Repository\StationRepository;
use \Evenement\EventEmitter;

$app->container->singleton('stationFormatter', function() use ($app) {

    return new StationFormatter($app->urlHelper);
});

$app->container->singleton('stationEmitter', function() use ($app) {
    $emitter = new EventEmitter();
    $emitter->on('configureFetchAll', new QuerySpecificationEvent($app->canPaginateSpecification));

    return $emitter;
});

$app->container->singleton('stationRepository', function() use ($app) {
    $stationRepository = new StationRepository($app->connection);
    $stationRepository->setEmitter($app->stationEmitter);

    return $stationRepository;
});

$app->container->singleton('stationValidator', function() use ($app) {

    return new ValitronValidator(require 'config/validations/stations.config.php');
});

$app->container->singleton('station', function() use ($app) {

    return new Model($app->stationRepository, $app->stationFormatter, 'stations');
});

$app->container->singleton('stationController', function() use ($app) {
    $app->controller->setModel($app->station);

    return $app->controller;
});
