<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Slim\Slim;

require '../vendor/autoload.php';

$app = new Slim();
$app->container->singleton('connection', function() {
    $dbOptions = require '../config/mysql.config.php';
    $config = new Configuration();

    return DriverManager::getConnection($dbOptions, $config);
});

require '../routes/stations.php';

$app->run();