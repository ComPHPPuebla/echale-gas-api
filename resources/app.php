<?php
use \EchaleGas\Hypermedia\HAL\StationFormatter;
use \EchaleGas\Twig\HalRendererExtension;
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

$app->view(new Twig());
$app->view()->parserOptions = [
    'charset' => 'utf-8',
    'cache' => realpath('../views/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
];
$app->view()->parserExtensions = [
    new TwigExtension(),
    new HalRendererExtension(),
];