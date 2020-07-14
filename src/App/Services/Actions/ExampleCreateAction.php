<?php

namespace App\Services\Actions;

use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Services\Actions\Abstractions\AbstractAction;
use App\Models\ModelExample;

class ExampleCreateAction extends AbstractAction
{
    /**
     * @return array
     *
     * @throws Exception
     */
    public function execute()
    {
        if ($id = $this->model->create($this->data)) {
            return $this->model->get($id);
        }

        throw new Exception('Couldn\'t create record!');
    }

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