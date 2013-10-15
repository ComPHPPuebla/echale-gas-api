<?php
use \ComPHPPuebla\Event\FormatResourceEvent;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\CollectionFormatter;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\ResourceFormatter;
use \ComPHPPuebla\Validator\ValitronValidator;
use \ComPHPPuebla\Model\Model;
use \ComPHPPuebla\Event\QuerySpecificationEvent;
use \EchaleGas\TableGateway\StationTable;
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

$app->container->singleton('stationTable', function() use ($app) {
    $stationTable = new StationTable($app->connection);
    $stationTable->setEventManager($app->stationEvents);

    return $stationTable;
});

$app->container->singleton('stationValidator', function() use ($app) {

    return new ValitronValidator(require 'config/validations/stations.config.php');
});

$app->container->singleton('station', function() use ($app) {

    return new Model($app->stationTable, $app->stationValidator);
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
