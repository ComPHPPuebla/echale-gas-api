<?php
use \EchaleGas\Repository\StationRepository;

$app->container->singleton('stationRepository', function() use ($app) {

    return new StationRepository($app->connection);
});