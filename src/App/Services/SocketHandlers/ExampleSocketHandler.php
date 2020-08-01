<?php

namespace App\Services\SocketHandlers;

use \Exception;
use \InvalidArgumentException;

use App\Services\Actions\Interfaces\ActionInterface;
use App\Services\Actions\ExampleGetAction;
use App\Services\Actions\ExampleCreateAction;
use App\Services\Actions\ExampleUpdateAction;
use App\Services\Actions\ExampleDeleteAction;
use App\Services\SocketHandlers\Abstractions\SocketHandler;
use App\Models\ModelExample;
use App\Exceptions\InvalidActionException;

class ExampleSocketHandler extends SocketHandler
{
    /**
     * @param string $data
     * @return ActionInterface
     *
     * @throws InvalidArgumentException
     */
    public function parseData(string $data) : ActionInterface
    {
        $parsedData = json_decode($data, true);

        // @throws InvalidArgumentException
        $this->validateData($parsedData);

        $model = ModelExample::class;

        switch ($parsedData['action']) {

            case self::READ_ACTION:
                return new ExampleGetAction(
                    $parsedData['params'],
                    $this->container->dataDriver,
                    $model
                );
                break;

            case self::CREATE_ACTION:
                return new ExampleCreateAction(
                    $parsedData['params'],
                    $this->container->dataDriver,
                    $model
                );
                break;

            case self::UPDATE_ACTION:
                return new ExampleUpdateAction(
                    $parsedData['params'],
                    $this->container->dataDriver,
                    $model
                );
                break;

            case self::DELETE_ACTION:
                return new ExampleDeleteAction(
                    $parsedData['params'],
                    $this->container->dataDriver,
                    $model
                );
                break;

            default:
                throw new InvalidActionException('Invalid Action!');
                break;

        }
    }

    /**
     * @param array $data
     *
     * @throws InvalidArgumentException
     */
    public function validateData(array $data)
    {
        if (!isset($data['params'])) {
            throw new InvalidArgumentException('Missing params key in data!');
        }
    }

}