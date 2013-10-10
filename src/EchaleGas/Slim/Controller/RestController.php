<?php
namespace EchaleGas\Slim\Controller;

use \ReflectionMethod;
use \Evenement\EventEmitter;
use \EchaleGas\Model\Model;
use \EchaleGas\Resource\Resource;
use \EchaleGas\Validator\Validator;
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
        $resource = $this->model->retrieveOne($id, $resource);

        if (!$resource) {
            $this->response->status(404); //Not found
        }

        return $resource;
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
    public function post(Resource $resource, Validator $validator)
    {
        parse_str($this->request->getBody(), $values);

        if (!$validator->isValid($values)) {
            $this->response->setStatus(400); //Bad request

            return $validator->errors();
        }

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
     * @param string $methodName
     * @param array $params
     * @return void
     */
    public function dispatch($methodName, array $params)
    {
        $method = new ReflectionMethod(__CLASS__, $methodName);
        $resource = $method->invokeArgs($this, $params);

        $this->emitter->emit('postDispatch', [
            'resource' => $resource, 'request' => $this->request, 'response' => $this->response
        ]);
    }
}
