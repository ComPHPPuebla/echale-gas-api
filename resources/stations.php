<?php
use \ComPHPPuebla\Slim\Controller\EventHandler\FormatResourceHandler;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\PaginationListener;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\HasTimestampListener;
use \ComPHPPuebla\Doctrine\TableGateway\EventListener\QuerySpecificationListener;
use \ComPHPPuebla\Doctrine\TableGateway\PaginatorFactory;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\CollectionFormatter;
use \ComPHPPuebla\Hypermedia\Formatter\HAL\ResourceFormatter;
use \ComPHPPuebla\Doctrine\TableGateway\TableProxyFactory;
use \ComPHPPuebla\Validator\ValitronValidator;
use \ComPHPPuebla\Model\Model;
use \ComPHPPuebla\Event\QuerySpecificationEvent;
use \EchaleGas\TableGateway\StationTable;
use \Zend\EventManager\EventManager;
use \EchaleGas\TableGateway\Specification\FilterByGeolocation;

$app->container->singleton('stationFormatter', function() use ($app) {

    return new ResourceFormatter($app->urlHelper, 'station', 'station_id');
});

$app->container->singleton('stationsFormatter', function() use ($app) {

    return new CollectionFormatter($app->urlHelper, 'stations', $app->stationFormatter);
});

$app->container->singleton('stationEvents', function() use ($app) {
    $eventManager = new EventManager();
    $eventManager->attach('postFindAll', new QuerySpecificationListener(new FilterByGeolocation()));
    $eventManager->attachAggregate(new HasTimestampListener());

    return $eventManager;
});

$app->container->singleton('stationTable', function() use ($app) {
    $stationTable = new StationTable($app->connection);

    $factory = new TableProxyFactory($app->proxiesConfiguration);

    $stationTable = $factory->createProxy($stationTable);
    $factory->addEventManagement($stationTable, $app->stationEvents);
    $factory->addCaching($stationTable, $app->cache, $app->request()->getPathInfo());
    $factory->addPagination($stationTable, new PaginatorFactory($app->paginator));

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
        'postDispatch', new FormatResourceHandler($app->stationFormatter)
    );

    return $app->controller;
});

$app->container->singleton('stationsController', function() use ($app) {
    $app->controller->setModel($app->station);
    $app->controllerEvents->attach(
        'postDispatch', new FormatResourceHandler($app->stationsFormatter)
    );

    return $app->controller;
});
