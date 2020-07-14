<?php

namespace App\Services\Actions;

use Exception;
use InvalidArgumentException;

use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Services\Actions\Abstractions\AbstractAction;
use App\Models\ModelExample;

class ExampleGetAction extends AbstractAction
{
    /**
     * @return array
     *
     * @throws Exception
     */
    public function execute()
    {
        $id = isset($this->data['id']) ? $this->data['id'] : null;
        
        if ($data = $this->model->get($id)) {
            return $data;
        }

        throw new Exception('Couldn\'t read record!');
    }

    /**
     * @param array $data
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function validateData(array $data) : void
    {
        // no field required
    }
}