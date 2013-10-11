<?php
use \EchaleGas\Event\FormatResourceEvent;
use \EchaleGas\Hypermedia\Formatter\HAL\CollectionFormatter;
use \EchaleGas\Hypermedia\Formatter\HAL\ResourceFormatter;
use \EchaleGas\Validator\ValitronValidator;
use \EchaleGas\Model\Model;
use \EchaleGas\Event\QuerySpecificationEvent;
use \EchaleGas\Repository\StationRepository;
use \Zend\EventManager\EventManager;

$app->container->singleton('stationFormatter', function() use ($app) {

    return new ResourceFormatter($app->urlHelper, 'station', 'station_id');
});

$app->container->singleton('stationsFormatter', function() use ($app) {

    return new CollectionFormatter(
        $app->urlHelper, 'stations', $app->paginator, $app->stationFormatter
    );
});

$app->container->singleton('stationEvents', function() use ($app) {
    $eventManager = new EventManager();
    $eventManager->attach(
        'configureFetchAll', new QuerySpecificationEvent($app->canPaginateSpecification)
    );

    return $eventManager;
});

$app->container->singleton('stationRepository', function() use ($app) {
    $stationRepository = new StationRepository($app->connection);
    $stationRepository->setEventManager($app->stationEvents);

    return $stationRepository;
});

$app->container->singleton('stationValidator', function() use ($app) {

    return new ValitronValidator(require 'config/validations/stations.config.php');
});

$app->container->singleton('station', function() use ($app) {

    return new Model($app->stationRepository, $app->stationValidator);
});

$app->container->singleton('stationController', function() use ($app) {
    $app->controller->setModel($app->station);
    $app->controllerEvents->attach(
        'postDispatch', new FormatResourceEvent($app->stationFormatter)
    );

    return $app->controller;
});

$app->container->singleton('stationsController', function() use ($app) {
    $app->controller->setModel($app->station);
    $app->controllerEvents->attach(
        'postDispatch', new FormatResourceEvent($app->stationsFormatter)
    );

    return $app->controller;
});
