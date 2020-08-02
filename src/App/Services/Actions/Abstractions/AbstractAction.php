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

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
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
