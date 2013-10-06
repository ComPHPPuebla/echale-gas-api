<?php
namespace EchaleGas\Resource;

use \Pagerfanta\Pagerfanta;

class ResourceCollection
{
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var Pagerfanta
     */
    protected $paginator;

    /**
     * @param Resource $resource
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param Pagerfanta $paginator
     */
    public function setPaginator(Pagerfanta $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param int   $count
     * @param array $collection
     * @param array $params
     * @param string $resourceName
     */
    public function format(array $params, $resourceName)
    {
        $halCollection = array('links' => array());

        $halCollection['links'] = $this->createPaginationLinks($resourceName, $params);
        $halCollection['links']['self'] = $this->buildUrl($resourceName, $params);

        $embedded = array();
        foreach ($this->paginator->getCurrentPageResults() as $resource) {
            $embedded[][$resourceName] = $this->resource->format($resource);
        }

        $halCollection['embedded'] = $embedded;
        $halCollection['data'] = array();

        return $halCollection;
    }

    /**
     * @param string   $resourceName
     * @param array $params
     */
    protected function createPaginationLinks($resourceName, array $params)
    {
        $this->paginator->setMaxPerPage(2);
        $this->paginator->setCurrentPage($params['page']);

        $links = array();
        if ($this->paginator->haveToPaginate()) {

            $params['page'] = 1;
            $links['first'] = $this->buildUrl($resourceName, $params);

            if ($this->paginator->hasNextPage()) {
                $params['page'] = $this->paginator->getNextPage();
                $links['next'] = $this->buildUrl($resourceName, $params);
            }

            if ($this->paginator->hasPreviousPage()) {
                $params['page'] = $this->paginator->getPreviousPage();
                $links['prev'] = $this->buildUrl($resourceName, $params);
            }

            $params['page'] = $this->paginator->getNbPages();
            $links['last'] = $this->buildUrl($resourceName, $params);
        }

        return $links;
    }

    public function buildUrl($routeName, array $params)
    {
        $baseUrl = $this->resource->getUrlHelper()->urlFor($routeName);

        return $baseUrl . '?' . http_build_query($params);
    }
}