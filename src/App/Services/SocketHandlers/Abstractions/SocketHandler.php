<?php

namespace App\Services\SocketHandlers\Abstractions;

use Slim\Container;

use App\Services\SocketHandlers\Interfaces\SocketHandlerInterface;
use App\Services\Actions\Interfaces\ActionInterface;

abstract class SocketHandler implements SocketHandlerInterface
{
    /** @var Container */
    protected $container;

    /**
     * @param Container $c
     */
    public function __construct($c)
    {
        $this->container = $c;
    }

    /**
     * @param string $data
     */
    public function __invoke(string $data)
    {
        /** @var ActionInterface */
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
     * @return void
     *
     * @throws InvalidArgumentException
     */
    abstract public function validateData(array $data) : void;
}
