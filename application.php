<?php
use \ComPHPPuebla\Slim\Hook\PhpSettingsHook;
use \ComPHPPuebla\Slim\Handler\ErrorHandler;
use \ComPHPPuebla\Slim\Handler\NotFoundHandler;
use \ComPHPPuebla\Slim\Middleware\JsonpMiddleware;
use \ComPHPPuebla\Slim\Middleware\ContentNegotiationMiddleware;
use \ComPHPPuebla\Slim\Middleware\HttpCacheMiddleware;
use \Slim\Slim;
use \Api\Station\StationRoutes;
use \Api\ApplicationContainer;
use \Api\Station\StationContainer;

chdir(__DIR__);

require 'vendor/autoload.php';

$app = new Slim(require 'config/app.config.php');

$app->notFound(new NotFoundHandler($app));
$app->error(new ErrorHandler($app));
$app->hook('slim.before', new PhpSettingsHook(require 'config/phpini.config.php'));

$container = new ApplicationContainer();
$container->register($app);

$app->add(new HttpCacheMiddleware($app->cache));
$app->add(new ContentNegotiationMiddleware());
$app->add(new JsonpMiddleware());

$stationContainer = new StationContainer();
$stationContainer->register($app);
$stationRoutes = new StationRoutes();
$stationRoutes->register($app);
