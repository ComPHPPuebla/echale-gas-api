<?php
use \EchaleGas\Event\RenderViewEvent;
use \Zend\EventManager\EventManager;
use \EchaleGas\Slim\Controller\RestController;
use \EchaleGas\Paginator\PagerFantaPaginator;
use \EchaleGas\Twig\HalRendererExtension;
use \EchaleGas\Doctrine\Specification\CanPaginateSpecification;
use \Doctrine\DBAL\DriverManager;
use \Doctrine\DBAL\Configuration;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Psr\Log\LogLevel;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

$app->container->singleton('connection', function() {
    $dbOptions = require 'config/mysql.config.php';
    $config = new Configuration();

    return DriverManager::getConnection($dbOptions, $config);
});

$app->container->singleton('log', function () {
    $logger = new Logger('echale-gas');
    $logger->pushHandler(new StreamHandler('logs/app.log', LogLevel::DEBUG));

    return $logger;
});

$app->container->singleton('paginator', function() use ($app) {
    $paginator = new PagerFantaPaginator();
    $paginator->setMaxPerPage($app->config('defaultPageSize'));

    return $paginator;
});

$app->container->singleton('canPaginateSpecification', function() use ($app) {

    return new CanPaginateSpecification($app->config('defaultPageSize'));
});

$app->urlHelper = new TwigExtension();

$app->container->singleton('twig', function () use ($app) {
    $twig = new Twig();
    $twig->parserOptions = [
        'charset' => 'utf-8',
        'cache' => realpath('views/cache'),
        'auto_reload' => true,
        'strict_variables' => false,
        'autoescape' => true
    ];
    $twig->parserExtensions = [
        $app->urlHelper,
        new HalRendererExtension(),
    ];

    return $twig;
});

$app->container->singleton('controllerEvents', function() use ($app) {
    $eventManager = new EventManager();
    $eventManager->attach('postDispatch', new RenderViewEvent($app->twig), -100);

    return $eventManager;
});

$app->container->singleton('controller', function() use ($app) {
    $controller = new RestController($app->request(), $app->response());
    $controller->setEventManager($app->controllerEvents);

    return $controller;
});

$app->view($app->twig);
