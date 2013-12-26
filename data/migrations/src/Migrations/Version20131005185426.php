<?php
namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Generate initial tables
 */
class Version20131005185426 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $stations = $schema->createTable('stations');
        $stations->addColumn('station_id', 'integer', ['autoincrement' => true]);
        $stations->addColumn('name', 'string', ['length' => 100]);
        $stations->addColumn('social_reason', 'string', ['length' => 100]);
        $stations->addColumn('address_line_1', 'string', ['length' => 150]);
        $stations->addColumn('address_line_2', 'string', ['length' => 80]);
        $stations->addColumn('location', 'string', ['length' => 100]);
        $stations->addColumn('latitude', 'float');
        $stations->addColumn('longitude', 'float');
        $stations->addColumn('created_at', 'datetime');
        $stations->addColumn('last_updated_at', 'datetime');
        $stations->setPrimaryKey(['station_id']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('stations');
    }
}
