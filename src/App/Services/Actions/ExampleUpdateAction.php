<?php

namespace App\Services\Actions;

use \Exception;

use App\Services\Actions\Interfaces\ActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Services\Actions\Abstractions\AbstractAction;
use App\Models\ModelExample;

class ExampleUpdateAction extends AbstractAction
{
    /**
     * @return void
     */
    public function execute()
    {
        $data = [];
        $data['content'] = $this->data['content'];
        $id = (int) $this->data['id'];

        if ($id = $this->model->update($id, $data)) {
            return $this->model->get($id);
        }

        throw new Exception('Couldn\'t update record!');
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

        if (!isset($data['content'])) {
            throw new InvalidArgumentException('Todo required \'content\' field to be created!');
        }
    }
}