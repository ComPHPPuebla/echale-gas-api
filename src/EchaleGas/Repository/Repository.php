<?php
namespace EchaleGas\Repository;

use \EchaleGas\Doctrine\Repository as DoctrineRepository;

abstract class Repository extends DoctrineRepository
{
    /**
     * @param array $criteria
     * @return array
     */
    abstract public function findAll(array $criteria);

    /**
     * @param array $values
     * @return array
     */
    abstract public function insert(array $values);

    /**
     * @param int
     * @return array
     */
    abstract public function find($id);

    /**
     * @param array $values
     * @param int $id
     * @return void
     */
    abstract public function update(array $values, $id);

    /**
     * @param int $id
     * @return void
     */
    abstract public function delete($id);

    /**
     * return int
     */
    abstract public function count();
}