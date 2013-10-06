<?php
namespace EchaleGas\Resource;

use \EchaleGas\Hypermedia\Formatter;

class Resource
{
    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @param Formatter $formatter
     */
    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return \Slim\Views\TwigExtension
     */
    public function getUrlHelper()
    {
        return $this->formatter->getUrlHelper();
    }

    /**
     * @param array $values
     * @return array
     */
    public function format(array $values)
    {
        return $this->formatter->format($values);
    }
}
