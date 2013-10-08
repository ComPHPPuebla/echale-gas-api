<?php
/*
 * Drop a database
 *
 * PHP version 5.3
 *
 * This source file is subject to the license that is bundled with this package in the
 * file LICENSE.
 *
 * @author     LMV <luis.montealegre@mandragora-web-systems.com>
 */
namespace EchaleGas\Doctrine\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Doctrine\DBAL\DriverManager;
use \InvalidArgumentException;

/**
 * Drop a database
 *
 * @author     LMV <luis.montealegre@mandragora-web-systems.com>
 */
class DropDatabaseCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('dbal:database:drop')
             ->setDescription('Drops the configured database')
             ->addOption('force', null, InputOption::VALUE_NONE, 'Set this parameter to execute this action')
            ->setHelp(<<<EOT
The <info>dbal:database:drop</info> command drops the connection database.

The --force parameter has to be used to actually drop the database.

<error>Be careful: All data in a given database will be lost when executing
this command.</error>
EOT
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getHelper('db')->getConnection();

        $params = $connection->getParams();

        $name = isset($params['path']) ? $params['path'] : (isset($params['dbname']) ? $params['dbname'] : false);

        if (!$name) {
            throw new InvalidArgumentException("Connection does not contain a 'path' or 'dbname' parameter and cannot be dropped.");
        }

        if ($input->getOption('force')) {
            // Only quote if we don't have a path
            if (!isset($params['path'])) {
                $name = $connection->getDatabasePlatform()->quoteSingleIdentifier($name);
            }

            try {
                $connection->getSchemaManager()->dropDatabase($name);
                $output->writeln(sprintf('<info>Dropped database named <comment>%s</comment></info>', $name));
            } catch (\Exception $e) {
                $output->writeln(sprintf('<error>Could not drop database named <comment>%s</comment></error>', $name));
                $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            }
        } else {
            $output->writeln('<error>ATTENTION:</error> This operation should not be executed in a production environment.');
            $output->writeln('');
            $output->writeln(sprintf('<info>Would drop the database named <comment>%s</comment>.</info>', $name));
            $output->writeln('Please run the operation with --force to execute');
            $output->writeln('<error>All data will be lost!</error>');
        }
    }
}