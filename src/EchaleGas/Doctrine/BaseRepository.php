<?php
namespace EchaleGas\Doctrine;

use \Doctrine\DBAL\Connection;
use \Evenement\EventEmitter;

class BaseRepository
{
    /**
     * @var Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @var \Evenement\EventEmitter
     */
    protected $emitter;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param EventEmitter $emitter
     */
    public function setEmitter(EventEmitter $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @return Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->connection->createQueryBuilder();
    }

    /**
     * @param string $sql
     * @param array $params
     */
    public function fetchAll($sql, array $params = [])
    {
        return $this->connection->fetchAll($sql, $params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAssoc($sql, array $params)
    {
        return $this->connection->fetchAssoc($sql, $params);
    }

    /**
     * @param string $tableName
     * @param array $values
     * @return int
     */
    public function doInsert($tableName, array $values)
    {
        $this->connection->insert($tableName, $values);

        return $this->connection->lastInsertId();
    }

    /**
     * @param string $tableName
     * @param array $values
     * @param array $identifier
     */
    public function doUpdate($tableName, array $values, array $identifier)
    {
        $this->connection->update($tableName, $values, $identifier);
    }

    /**
     * @param string $tableName
     * @param array $identifier
     */
    public function doDelete($tableName, array $identifier)
    {
        $this->connection->delete($tableName, $identifier);
    }
}
