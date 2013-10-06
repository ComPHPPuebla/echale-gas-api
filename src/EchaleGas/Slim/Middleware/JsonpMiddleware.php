<?php
namespace EchaleGas\Slim\Middleware;

use \Slim\Middleware;

class JsonpMiddleware extends Middleware
{
    /**
     * Adjust the content type accordingly and add the given callback name to the response for
     * JSONP requests
     *
     * @see \Slim\Middleware::call()
     */
    public function call()
    {
        $callback = $this->app->request()->get('callback');

        $this->next->call();

        if (empty($callback)) {

            return;
        }

        $this->app->contentType('application/javascript');
        $jsonp = htmlspecialchars($callback) . "(" .$this->app->response()->body() . ")";

        $this->app->response()->body($jsonp);
    }
}