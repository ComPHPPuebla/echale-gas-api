<?php
namespace EchaleGas\Doctrine;

use \Doctrine\DBAL\Connection;
use \Zend\EventManager\EventManagerInterface;

class Repository
{
    /**
     * @var Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([
            __CLASS__,
            get_called_class(),
        ]);
        $this->eventManager = $eventManager;
    }

    /**
     * @return Doctrine\DBAL\Query\QueryBuilder
     */
    protected function createQueryBuilder()
    {
        return $this->connection->createQueryBuilder();
    }

    /**
     * @param string $sql
     * @param array $params
     */
    protected function fetchAll($sql, array $params = [])
    {
        return $this->connection->fetchAll($sql, $params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function fetchAssoc($sql, array $params = [])
    {
        return $this->connection->fetchAssoc($sql, $params);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    protected function fetchColumn($sql, array $params = [])
    {
        return $this->connection->fetchColumn($sql, $params);
    }

    /**
     * @param string $tableName
     * @param array $values
     * @return int
     */
    protected function doInsert($tableName, array $values)
    {
        $this->connection->insert($tableName, $values);

        return $this->connection->lastInsertId();
    }

    /**
     * @param string $tableName
     * @param array $values
     * @param array $identifier
     */
    protected function doUpdate($tableName, array $values, array $identifier)
    {
        $this->connection->update($tableName, $values, $identifier);
    }

    /**
     * @param string $tableName
     * @param array $identifier
     */
    protected function doDelete($tableName, array $identifier)
    {
        $this->connection->delete($tableName, $identifier);
    }
}
