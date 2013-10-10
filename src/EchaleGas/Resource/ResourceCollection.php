<?php
namespace EchaleGas\Resource;

use \EchaleGas\Paginator\Paginator;

class ResourceCollection extends Resource
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param array $items
     * @param int $itemsCount
     */
    public function setItems(array $items, $itemsCount)
    {
        $this->paginator->setResults($items, $itemsCount);
    }

    /**
     * @param int   $count
     * @param array $collection
     * @param array $params
     * @param string $routeName
     */
    public function formatCollection(array $params, $routeName)
    {
        $halCollection = array('links' => array());

        $halCollection['links'] = $this->createPaginationLinks($routeName, $params);
        $halCollection['links']['self'] = $this->buildUrl($routeName, $params);

        $embedded = array();
        foreach ($this->paginator->getCurrentPageResults() as $resource) {
            $embedded[][$routeName] = $this->formatter->format($resource);
        }

        $halCollection['embedded'] = $embedded;
        $halCollection['data'] = array();

        return $halCollection;
    }

    /**
     * @param string   $routeName
     * @param array $params
     */
    protected function createPaginationLinks($routeName, array $params)
    {
        if (!isset($params['page'])) {

            return [];
        }

        $this->paginator->setCurrentPage($params['page']);

        $links = array();
        if ($this->paginator->haveToPaginate()) {

            $params['page'] = 1;
            $links['first'] = $this->buildUrl($routeName, $params);

            if ($this->paginator->hasNextPage()) {
                $params['page'] = $this->paginator->getNextPage();
                $links['next'] = $this->buildUrl($routeName, $params);
            }

            if ($this->paginator->hasPreviousPage()) {
                $params['page'] = $this->paginator->getPreviousPage();
                $links['prev'] = $this->buildUrl($routeName, $params);
            }

            $params['page'] = $this->paginator->getNbPages();
            $links['last'] = $this->buildUrl($routeName, $params);
        }

        return $links;
    }

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    protected function buildUrl($routeName, array $params)
    {
        $baseUrl = $this->getUrlHelper()->site($this->getUrlHelper()->urlFor($routeName));

        return $baseUrl . '?' . http_build_query($params);
    }
}