<?php

namespace App\Services\Actions\Traits;

use App\Models\Interfaces\SimpleCrudInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;

/**
 * Action's Trait for CRUD procedures, similar to RESTful Resources endpoints.
 */

trait CRUDActionTrait
{
    /** @var DataDriverInterface */
    protected $dataDriver;

    /** @var SimpleCrudInterface */
    protected $model;
    
    /**
     * @param array $data
     * @param DataDriverInterface $dataDriver
     * @param SimpleCrudInterface $modelClass
     *
     * @throws Exception
     */
    public function __construct(
        array $data,
        DataDriverInterface $dataDriver,
        string $modelClass
    ) {
        $this->validateData($data);

        $this->data = $data;
        $this->dataDriver = $dataDriver;
        $this->model = new $modelClass($this->dataDriver);
    }

    abstract public function validateData(array $data) : void;
}
