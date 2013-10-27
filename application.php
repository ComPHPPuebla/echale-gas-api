<?php
use \ComPHPPuebla\Slim\Hook\PhpSettingsHook;
use \ComPHPPuebla\Slim\Handler\ErrorHandler;
use \ComPHPPuebla\Slim\Handler\NotFoundHandler;
use \ComPHPPuebla\Slim\Middleware\JsonpMiddleware;
use \ComPHPPuebla\Slim\Middleware\ContentNegotiationMiddleware;
use \Slim\Slim;
use ComPHPPuebla\Slim\Middleware\HttpCacheMiddleware;

chdir(__DIR__);

require 'vendor/autoload.php';

$app = new Slim(require 'config/app.config.php');

$app->notFound(new NotFoundHandler($app));
$app->error(new ErrorHandler($app));
$app->hook('slim.before', new PhpSettingsHook(require 'config/phpini.config.php'));

require 'resources/app.php';

$app->add(new HttpCacheMiddleware($app->cache));
$app->add(new ContentNegotiationMiddleware());
$app->add(new JsonpMiddleware());

require 'routes/stations.php';
