<?php
namespace EchaleGas\Hypermedia;

use \Slim\Views\TwigExtension;

abstract class Formatter
{
    /**
     * @var TwigExtension
     */
    protected $urlHelper;

    /**
     * @param TwigExtension $urlHelper
     */
    public function __construct(TwigExtension $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    /**
     * @return \Slim\Views\TwigExtension
     */
    public function getUrlHelper()
    {
        return $this->urlHelper;
    }

    /**
     * @param array $values
     */
    abstract public function format(array $values);
}