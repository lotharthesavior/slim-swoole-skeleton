<?php

namespace App\Services\Actions;

use Exception;
use InvalidArgumentException;

use App\Drivers\Data\Interfaces\DataDriverInterface;
use Conveyor\Actions\Abstractions\AbstractAction;
use App\Services\Actions\Traits\CRUDActionTrait;
use App\Models\ModelExample;

class ExampleGetAction extends AbstractAction
{
    use CRUDActionTrait;

    /** @var string */
    protected $name = 'example-get-action';
    
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
