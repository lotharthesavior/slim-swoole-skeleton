<?php

namespace App\Services\Actions\Abstractions;

use App\Services\Actions\Abstractions\AbstractAction;

abstract class ExampleAbstractAction extends AbstractAction
{
    /**
     * @param array $data
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function validateData(array $data) : void
    {
        if (!isset($data['content'])) {
            throw new InvalidArgumentException('Todo required \'content\' field to be created!');
        }
    }
}