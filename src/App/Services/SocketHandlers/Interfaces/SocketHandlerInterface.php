<?php

namespace App\Services\SocketHandlers\Interfaces;

use \Exception;

use App\Services\Actions\Interfaces\ActionInterface;

interface SocketHandlerInterface
{
    /**
     * @param string $data
     *
     * @return ActionInterface
     */
    public function parseData(string $data) : ActionInterface;

    /**
     * @param array $data
     *
     * @throws Exception
     */
    public function validateData(array $data);
}