<?php

namespace App\Services\SocketHandlers;

use Exception;

use League\Pipeline\Pipeline;
use App\Exceptions\InvalidActionException;
use App\Services\Actions\Interfaces\ActionInterface;
use App\Services\SocketHandlers\Abstractions\SocketHandler;
use App\Services\SocketHandlers\Traits\HasPipeline;

class SocketMessageRouter extends SocketHandler
{
    use HasPipeline;

    /**
     * @param string $data
     *
     * @throws Exception
     */
    public function __invoke(string $data)
    {
        /** @var ActionInterface */
        $action = $this->parseData($data);

        /** @var Pipeline */
        $pipeline = $this->getPipeline();

        /** @throws Exception */
        $pipeline->process($this);

        return $action->execute();
    }

    /**
     * @param string $data
     * @return ActionInterface
     *
     * @throws InvalidArgumentException|InvalidActionException
     */
    public function parseData(string $data) : ActionInterface
    {
        $this->parsedData = json_decode($data, true);

        // @throws InvalidArgumentException|InvalidActionException
        $this->validateData($this->parsedData);

        return $this->handlerMap[$this->parsedData['action']];
    }
}
