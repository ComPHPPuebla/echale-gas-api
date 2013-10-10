<?php
namespace EchaleGas\Validator;

interface Validator
{
    /**
     * @param array $values
     * @return boolean
     */
    public function isValid(array $values);

    /**
     * @return array
     */
    public function errors();
}