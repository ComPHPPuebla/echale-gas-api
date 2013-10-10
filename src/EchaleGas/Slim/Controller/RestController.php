<?php
namespace EchaleGas\Slim\Controller;

use \Evenement\EventEmitter;
use \EchaleGas\Model\Model;
use \EchaleGas\Resource\Resource;
use \EchaleGas\Resource\ResourceCollection;

class RestController extends SlimController
{
    /**
     * @var EventEmitter
     */
    protected $emitter;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param EventEmitter $emitter
     */
    public function setEmitter(EventEmitter $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @param Resource $resource
     */
    public function get($id, Resource $resource)
    {
        return $this->model->retrieveOne($id, $resource);
    }

    /**
     * @param ResourceCollection $collection
     * @return array
     */
    public function getList(ResourceCollection $collection)
    {
        return $this->model->retrieveAll($this->request->params(), $collection);
    }

    /**
     * @param Resource $resource
     * @return array
     */
    public function post(Resource $resource)
    {
        parse_str($this->request->getBody(), $values);
        $resource = $this->model->create($values, $resource);
        $this->response->setStatus(201); //Created

        return $resource;
    }

    /**
     * @param int $id
     * @param Resource $resource
     * @return array
     */
    public function put($id, Resource $resource)
    {
        parse_str($this->request->getBody(), $station);

        return $this->model->update($station, $id, $resource);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->model->delete($id);
        $this->response->status(204); //No Content
    }

    /**
     * @return void
     */
    public function optionsList()
    {
        $this->response->headers->set('Allow', implode(',', $this->optionsList));
    }

    /**
     * @return void
     */
    public function options()
    {
        $this->response->headers->set('Allow', implode(',', $this->options));
    }

    /**
     * @return mixed
     */
    public function dispatch()
    {
        $params = func_get_args();
        $method = array_shift($params);

        $resource = call_user_func_array([$this, $method], $params);
        //How to know when to render wether list or show templates?
        $this->emitter->emit('postDispatch', [
            'resource' => $resource, 'request' => $this->request, 'response' => $this->response
        ]);
    }
}
