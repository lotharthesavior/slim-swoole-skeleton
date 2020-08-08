<?php

namespace App\Services\Actions;

use Exception;
use InvalidArgumentException;
use App\Models\ModelExample;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use Conveyor\Actions\Abstractions\AbstractAction;
use App\Services\Actions\Traits\CRUDActionTrait;

class ExampleCreateAction extends AbstractAction
{
    use CRUDActionTrait;

    /** @var string */
    protected $name = 'example-create-action';

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
