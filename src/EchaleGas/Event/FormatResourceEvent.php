<?php
namespace EchaleGas\Event;

use \Zend\EventManager\Event;
use \EchaleGas\Hypermedia\Formatter\HAL\Formatter;

class FormatResourceEvent
{
    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @param View $view
     */
    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param array|null $resource
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Event $event)
    {
        $resource = $event->getParam('resource');
        if (empty($resource)) {

            return;
        }

        $event->setParam(
            'resource', $this->formatter->format($resource, $event->getParam('request')->params())
        );
    }
}
