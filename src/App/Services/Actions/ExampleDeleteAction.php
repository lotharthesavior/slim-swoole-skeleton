<?php

namespace App\Services\Actions;

use Exception;
use InvalidArgumentException;

use App\Services\Actions\Interfaces\ActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Services\Actions\Abstractions\AbstractAction;
use App\Models\ModelExample;

class ExampleDeleteAction extends AbstractAction
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = (int) $this->data['id'];

        return $this->model->delete($id);
    }

    /**
     * @param array $data
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function validateData(array $data) : void
    {
        if (!isset($data['id'])) {
            throw new InvalidArgumentException('Todo required \'id\' field to be created!');
        }
    }
}