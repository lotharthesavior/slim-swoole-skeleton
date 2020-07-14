<?php

namespace App\Services\SocketHandlers\Abstractions;

use Slim\Container;

use App\Services\SocketHandlers\Interfaces\SocketHandlerInterface;
use App\Services\Actions\Interfaces\ActionInterface;

abstract class SocketHandler implements SocketHandlerInterface
{
    /** @var string */
    const READ_ACTION = 'get';

    /** @var string */
    const CREATE_ACTION = 'create';

    /** @var string */
    const UPDATE_ACTION = 'update';

    /** @var string */
    const DELETE_ACTION = 'delete';

    /** @var Container */
    protected $container;

    public function __construct($c)
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

    /**
     * This method identifies the action to be executed
     *
     * @param string $data
     *
     * @return ActionInterface
     *
     * @throws InvalidArgumentException
     */
    abstract public function parseData(string $data) : ActionInterface;

    /**
     * @param array $data
     *
     * @throws InvalidArgumentException
     */
    abstract public function validateData(array $data);
}