<?php

namespace App\Services\SocketHandlers\Traits;

use Exception;
use InvalidArgumentException;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use App\Exceptions\InvalidActionException;
use App\Services\Actions\Interfaces\ActionInterface;
use App\Services\SocketHandlers\Abstractions\SocketHandler;

trait HasPipeline
{
    /** @var array */
    protected $pipelineMap = [];

    /** @var array */
    protected $handlerMap = [];

    /** @var array */
    protected $parsedData;

    /**
     * @return array
     */
    public function getParsedData() : array
    {
        return $this->parsedData;
    }

    /**
     * Prepare pipeline based on the current prepared handlers.
     *
     * @return Pipeline
     */
    public function getPipeline() : Pipeline
    {
        $pipelineBuilder = new PipelineBuilder;
        foreach ($this->pipelineMap as $actionName => $middleware) {
            $pipelineBuilder->add($middleware);
        }
        return $pipelineBuilder->build();
    }

    /**
     * Add an action to be handled. It returns a pipeline for
     * eventual middlewares to be added for each.
     *
     * @param ActionInterface $actionHandler
     *
     * @return SocketHandler
     */
    public function add(ActionInterface $actionHandler) : SocketHandler
    {
        $actionName = $actionHandler->getName();
        $this->handlerMap[$actionName] = $actionHandler;
        
        return $this;
    }

    /**
     * Add a step for the current's action middleware.
     *
     * @param string $action
     * @param Callable $middleware
     *
     * @return void
     */
    public function pipe(string $action, callable $middleware) : void
    {
        $this->pipelineMap[$action] = $middleware;
    }

    /**
     * @param array $data
     *
     * @return void
     *
     * @throws InvalidArgumentException|InvalidActionException
     */
    final public function validateData(array $data) : void
    {
        if (!isset($data['action'])) {
            throw new InvalidArgumentException('Missing action key in data!');
        }

        if (!isset($this->handlerMap[$data['action']])) {
            throw new InvalidActionException('Invalid Action! This action (' . $data['action'] . ') is not set.');
        }
    }
}
