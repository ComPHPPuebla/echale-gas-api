<?php
/**
 * Application's CLI
 *
 * PHP version 5.3
 *
 * This source file is subject to the license that is bundled with this package in the
 * file LICENSE.
 *
 * @author     LMV <luis.montealegre@mandragora-web.systems.com>
 */
require 'vendor/autoload.php';

use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Helper\HelperSet;
use \Symfony\Component\Console\Helper\DialogHelper;
use \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use \Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use \Doctrine\DBAL\DriverManager;
use \ComPHPPuebla\Doctrine\Command\CreateDatabaseCommand;
use \ComPHPPuebla\Doctrine\Command\DropDatabaseCommand;

/**
 * Application's CLI
 *
 * @author     LMV <luis.montealegre@mandragora-web.systems.com>
 */
$cli = new Application('Échale Ganas Command Line Interface');
$cli->setCatchExceptions(true);

$connection = DriverManager::getConnection(require 'config/mysql.config.php');

$helperSet = new HelperSet();
$helperSet->set(new DialogHelper(), 'dialog');
$helperSet->set(new ConnectionHelper($connection), 'db');

$cli->setHelperSet($helperSet);

$cli->addCommands([
    // DBAL Commands
    new RunSqlCommand(),
    new ImportCommand(),
    // EchaleGas DBAL Commands
    new CreateDatabaseCommand(),
    new DropDatabaseCommand(),
]);

$cli->run();