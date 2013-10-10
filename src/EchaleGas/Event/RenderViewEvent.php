<?php
namespace EchaleGas\Event;

use \Slim\Http\Response;
use \Slim\Http\Request;
use \Slim\View;

class RenderViewEvent
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param array $resource
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(array $resource, Request $request, Response $response)
    {
        if (!$request->isHead() && !$request->isOptions()) {

            $body = $this->renderView($resource, $response);
            $response->setBody($body);
        }
    }

    /**
     * @param array $resource
     * @return string
     */
    public function renderView(array $resource, Response $response)
    {
        $typeParts = explode('/', $response->headers->get('Content-Type'));
        $viewExtension = array_pop($typeParts);
        $this->view->setData(['resource' => $resource]);

        return $this->view->display("resource/list.$viewExtension.twig");
    }
}