<?php
use \EchaleGas\Twig\HalRendererExtension;
use \EchaleGas\Doctrine\Query\CanPaginate;
use \Doctrine\DBAL\DriverManager;
use \Doctrine\DBAL\Configuration;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Psr\Log\LogLevel;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

$app->container->singleton('connection', function() {
    $dbOptions = require '../config/mysql.config.php';
    $config = new Configuration();

    return DriverManager::getConnection($dbOptions, $config);
});

$app->container->singleton('log', function () {
    $logger = new Logger('echale-gas');
    $logger->pushHandler(new StreamHandler('../logs/app.log', LogLevel::DEBUG));

    return $logger;
});

$app->container->singleton('canPaginateSpecification', function() use ($app) {

    return new CanPaginate($app->config('defaultPageSize'));
});

$app->urlHelper = new TwigExtension();

$app->container->singleton('twig', function () use ($app) {
    $twig = new Twig();
    $twig->parserOptions = [
        'charset' => 'utf-8',
        'cache' => realpath('../views/cache'),
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

$app->view($app->twig);