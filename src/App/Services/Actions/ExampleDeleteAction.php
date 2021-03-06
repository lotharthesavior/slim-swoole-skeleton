<?php

namespace App\Services\Actions;

use Exception;
use InvalidArgumentException;

use App\Drivers\Data\Interfaces\DataDriverInterface;
use Conveyor\Actions\Abstractions\AbstractAction;
use App\Services\Actions\Traits\CRUDActionTrait;
use App\Models\ModelExample;

class ExampleDeleteAction extends AbstractAction
{
    use CRUDActionTrait;

    /** @var string */
    protected $name = 'example-delete-action';
    
    /**
     * @param array $data
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function execute(array $data)
    {
        /** @throws InvalidArgumentException */
        $this->validateData($data['params']);

        $this->data = $data['params'];
        
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
