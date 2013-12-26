<?php
namespace Api;

use \Slim\Slim;
use \ComPHPPuebla\Slim\Controller\EventListener\RenderResourceListener;
use \ComPHPPuebla\Slim\Controller\EventListener\RenderErrorsListener;
use \ComPHPPuebla\Slim\Controller\RestController;
use \ComPHPPuebla\Slim\Controller\RestControllerProxyFactory;
use \ComPHPPuebla\Paginator\PagerfantaPaginator;
use \ComPHPPuebla\Paginator\PaginatorFactory;
use \ComPHPPuebla\Twig\HalRendererExtension;
use \Zend\EventManager\EventManager;
use \Doctrine\DBAL\DriverManager;
use \Doctrine\DBAL\Configuration;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Psr\Log\LogLevel;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;
use \ProxyManager\Configuration as ProxyConfiguration;
use \Doctrine\Common\Cache\FilesystemCache;

class ApplicationContainer
{
	public function register(Slim $app)
	{
	    $app->container->singleton('cache', function() {

	        return new FilesystemCache('tmp/cache/db');
	    });

        $app->container->singleton('connection', function() {
            $dbOptions = require 'config/connection.config.php';
            $config = new Configuration();

            return DriverManager::getConnection($dbOptions, $config);
        });

        $app->container->singleton('log', function () {
            $logger = new Logger('echale-gas');
            $logger->pushHandler(new StreamHandler('tmp/logs/app.log', LogLevel::DEBUG));

            return $logger;
        });

        $app->container->singleton('paginator', function() use ($app) {

            return new PagerfantaPaginator($app->config('defaultPageSize'));
        });

        $app->container->singleton('paginatorFactory', function() use ($app) {

            return new PaginatorFactory($app->paginator);
        });

        $app->container->singleton('proxiesConfiguration', function() use ($app) {
            $config = new ProxyConfiguration();
            $config->setProxiesTargetDir('tmp/cache/proxies');
            spl_autoload_register($config->getProxyAutoloader());

            return $config;
        });

        $app->urlHelper = new TwigExtension();

        $app->container->singleton('twig', function () use ($app) {
            $twig = new Twig();
            $twig->parserOptions = [
                'charset' => 'utf-8',
                'cache' => realpath('tmp/cache/twig'),
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

            // Ensure rendering is performed at the end by assigning a very low priority
            $eventManager->attach('postDispatch', new RenderResourceListener($app->twig), -100);
            $eventManager->attach('renderErrors', new RenderErrorsListener($app->twig), -100);

            return $eventManager;
        });

        $app->container->singleton('controller', function() use ($app) {
            $controller = new RestController($app->request(), $app->response());
            $factory = new RestControllerProxyFactory($app->proxiesConfiguration, $app->controllerEvents);
            $controller = $factory->createProxy($controller);
            $factory->addEventManagement($controller);

            return $controller;
        });

        $app->view($app->twig);
	}
}
