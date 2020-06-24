<?php

namespace App\Services\Actions;

use App\Services\Actions\Interfaces\TodoActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Models\Todo;
use \Exception;

class TodoCreateAction implements TodoActionInterface
{
    /** @var array */
    protected $data;

    /** @var DataDriverInterface */
    protected $dataDriver;

    public function __construct(array $params, DataDriverInterface $dataDriver)
    {
        if (!isset($params['content'])) {
            throw new Exception('Todo required \'content\' field to be created!');
        }

        $this->data = $params;
        $this->dataDriver = $dataDriver;
    }

    public function execute()
    {
        $todo = new Todo($this->dataDriver);
        if ($id = $todo->create($this->data)) {
            return $todo->get($id);
        }

        throw new Exception('Couldn\'t create record!');
    }
}