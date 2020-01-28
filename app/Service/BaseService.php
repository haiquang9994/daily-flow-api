<?php

namespace App\Service;

use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Evenement\EventEmitterTrait;
use Illuminate\Database\Eloquent\Model;
use PDO;

abstract class BaseService
{
    use EventEmitterTrait;

    protected $container;
    protected $db;
    protected $model;
    protected $model_object;

    public function __construct(ContainerInterface $container, Manager $db)
    {
        $this->container = $container;
        $this->db = $db;
        $this->boot();
        if (class_exists($this->model)) {
            $model_name = $this->model;
            $this->model_object = new $model_name;
        }
    }

    public function getKeyName(): ?string
    {
        if ($this->model_object instanceof Model) {
            return $this->model_object->getKeyName();
        }
        return null;
    }

    public function __call($method, $params)
    {
        if ($this->model) {
            return call_user_func_array([$this->model, $method], $params);
        }

        return call_user_func_array([$this->db->getDatabaseManager()->connection(), $method], $params);
    }

    public function addScope($callback)
    {
        if (is_callable($callback)) {
            $model = $this->model;
            $model::addGlobalScope($callback);
        }

        return $this;
    }

    public function createNew(array $data = []): Model
    {
        $model = $this->model;
        return new $model($data);
    }

    public function getPdo(): PDO
    {
        return $this->container->get(Manager::class)->getConnection('default')->getPdo();
    }

    public function boot()
    {
    }
}
