<?php
/**
 * Application's CLI
 *
 * PHP version 5.4
 *
 * This source file is subject to the license that is bundled with this package in the
 * file LICENSE.
 *
 * @author     LMV <montealegreluis@gmail.com>
 */
require 'vendor/autoload.php';

use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Helper\HelperSet;
use \Symfony\Component\Console\Helper\DialogHelper;
use \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use \Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use \Doctrine\DBAL\DriverManager;
use \ComPHPPuebla\Doctrine\Command\CreateDatabaseCommand;
use \ComPHPPuebla\Doctrine\Command\DropDatabaseCommand;
use \ComPHPPuebla\Doctrine\Console\Command\LoadFixtureCommand;

/**
 * Application's CLI
 *
 * @author     LMV <montealegreluis@gmail.com>
 */
$cli = new Application('Échale Ganas Command Line Interface');
$cli->setCatchExceptions(true);

$connection = DriverManager::getConnection(require 'config/connection.config.php');

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
    // Migrations Commands
    new ExecuteCommand(),
    new GenerateCommand(),
    new MigrateCommand(),
    new StatusCommand(),
    new VersionCommand(),
    // Fixtures Commands
    new LoadFixtureCommand(),
]);

$cli->run();