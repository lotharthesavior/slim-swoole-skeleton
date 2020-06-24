<?php

namespace App\Services;

use \Exception;
use \Slim\Container;
use App\Services\Actions\Interfaces\TodoActionInterface;
use App\Services\Actions\TodoCreateAction;
use App\Services\Actions\TodoUpdateAction;
use App\Services\Actions\TodoDeleteAction;

class TodoSocketHandler
{
    /** @var string */
    const CREATE_ACTION = 'createTodo';

    /** @var string */
    const UPDATE_ACTION = 'updateTodo';

    /** @var string */
    const DELETE_ACTION = 'deleteTodo';

    /** @var Container */
    protected $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    /**
     * @param string $data
     */
    public function __invoke(string $data)
    {
        $action = $this->parseData($data);
        return $action->execute();
    }

    private function parseData(string $data) : TodoActionInterface
    {
        $parsedData = json_decode($data, true);

        switch($parsedData['action']) {

            case self::CREATE_ACTION:
                return new TodoCreateAction($parsedData['params'], $this->container->dataDriver);
                break;

            case self::UPDATE_ACTION:
                return new TodoUpdateAction($parsedData['params'], $this->container->dataDriver);
                break;

            case self::DELETE_ACTION:
                return new TodoDeleteAction($parsedData['params'], $this->container->dataDriver);
                break;

            default:
                throw new Exception('Invalid Action!');
                break;

        }
    }

}