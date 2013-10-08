<?php
namespace EchaleGas\Resource;

class Resource extends BaseResource
{
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
