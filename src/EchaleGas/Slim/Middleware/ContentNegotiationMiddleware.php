<?php
namespace EchaleGas\Slim\Middleware;

use \Slim\Middleware;
use \Negotiation\Negotiator;

class ContentNegotiationMiddleware extends Middleware
{
    /**
     * @var array
     */
    protected $validContentTypes;

    /**
     * Initialize valid content types
     */
    public function __construct()
    {
        $this->validContentTypes = ['application/json', 'application/xml'];
    }

    /**
     * Ensure the provided content type is valid and set the proper response content type
     *
     * @see \Slim\Middleware::call()
     */
    public function call()
    {
        $negotiator = new Negotiator();

        $format = $negotiator->getBest($this->app->request()->headers('Accept'));
        $type = $format->getValue();

        if (in_array($type, $this->validContentTypes)) {

            $this->app->contentType($type);
            $typeParts = explode('/', $type);
            $this->app->viewExtension = array_pop($typeParts);
            $this->next->call();

            return;
        }

        $this->app->halt(406); //Not acceptable
    }
}