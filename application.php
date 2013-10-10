<?php
use EchaleGas\Slim\Hook\PhpSettingsHook;

use \EchaleGas\Slim\Handler\ErrorHandler;
use \EchaleGas\Slim\Handler\NotFoundHandler;
use \EchaleGas\Slim\Middleware\JsonpMiddleware;
use \EchaleGas\Slim\Middleware\ContentNegotiationMiddleware;
use \Slim\Slim;

chdir(__DIR__);

require 'vendor/autoload.php';

$app = new Slim(require 'config/app.config.php');

$app->notFound(new NotFoundHandler($app));
$app->error(new ErrorHandler($app));
$app->add(new ContentNegotiationMiddleware());
$app->add(new JsonpMiddleware());
$app->hook('slim.before', new PhpSettingsHook(require 'config/phpini.config.php'));

require 'resources/app.php';
require 'routes/stations.php';
