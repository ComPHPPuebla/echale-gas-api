<?php
namespace EchaleGas\Doctrine;

use Doctrine\DBAL\Connection;

class BaseRepository
{
    /**
     * @var Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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

    public function doUpdate($tableName, array $values, array $identifier)
    {
        $this->connection->update($tableName, $values, $identifier);
    }

    public function doDelete($tableName, array $identifier)
    {
        $this->connection->delete($tableName, $identifier);
    }
}