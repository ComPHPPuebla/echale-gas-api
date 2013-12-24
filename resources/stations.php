<?php
use \ComPHPPuebla\Slim\Controller\EventListener\FormatResourceListener;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\HasTimestampListener;
use \ComPHPPuebla\Doctrine\TableGateway\Specification\ChainedSpecification;
use ComPHPPuebla\Doctrine\TableGateway\Specification\PaginationSpecification;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\QuerySpecificationListener;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\CacheListener;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\CollectionFormatter;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\ResourceFormatter;
use \ComPHPPuebla\Doctrine\TableGateway\TableProxyFactory;
use \ComPHPPuebla\Validator\ValitronValidator;
use \ComPHPPuebla\Model\Model;
use \Zend\EventManager\EventManager;
use \EchaleGas\TableGateway\StationTable;
use \EchaleGas\TableGateway\Specification\FilterByGeolocation;

$app->container->singleton('stationFormatter', function() use ($app) {

    return new ResourceFormatter($app->urlHelper, 'station', 'station_id');
});

$app->container->singleton('stationsFormatter', function() use ($app) {

    return new CollectionFormatter($app->urlHelper, 'stations', $app->stationFormatter);
});

$app->container->singleton('stationEvents', function() use ($app) {
    $eventManager = new EventManager();

    $specification = new ChainedSpecification();
    $specification->addSpecification(new PaginationSpecification($app->config('defaultPageSize')));
    $specification->addSpecification(new FilterByGeolocation());
    $eventManager->attach('postFindAll', new QuerySpecificationListener($specification));

    $eventManager->attachAggregate(new HasTimestampListener());
    $eventManager->attachAggregate(new CacheListener($app->cache, $app->request()->getPathInfo()));

    return $eventManager;
});

$app->container->singleton('stationTable', function() use ($app) {
    $stationTable = new StationTable('stations', $app->connection);

    $factory = new TableProxyFactory($app->proxiesConfiguration, $app->stationEvents);

    $stationTable = $factory->createProxy($stationTable);
    $factory->addEventManagement($stationTable);

    return $stationTable;
});

$app->container->singleton('stationValidator', function() use ($app) {

    return new ValitronValidator(require 'config/validations/stations.config.php');
});

$app->container->singleton('station', function() use ($app) {

    return new Model($app->stationTable, $app->stationValidator, $app->paginatorFactory);
});

$app->container->singleton('stationController', function() use ($app) {
    $app->controller->setModel($app->station);
    $app->controllerEvents->attach(
        'postDispatch', new FormatResourceListener($app->stationFormatter)
    );

    return $app->controller;
});

$app->container->singleton('stationsController', function() use ($app) {
    $app->controller->setModel($app->station);
    $app->controllerEvents->attach(
        'postDispatch', new FormatResourceListener($app->stationsFormatter)
    );

    return $app->controller;
});
