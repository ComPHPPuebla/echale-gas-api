<?php
namespace EchaleGas\Resource;

use \EchaleGas\Hypermedia\Formatter;

class BaseResource
{
    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @param Formatter $formatter
     */
    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }
}