<?php

namespace App\Services\Actions\Abstractions;

use \Exception;

use App\Services\Actions\Interfaces\ActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Models\ModelExample;
use App\Models\Interfaces\SimpleCrudInterface;

abstract class AbstractAction implements ActionInterface
{
    /** @var array */
    protected $data;

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

    /**
     * @param array $data
     * @return void
     *
     * @throws Exception
     */
    abstract public function validateData(array $data) : void;

    /**
     * 
     */
    abstract public function execute();
}