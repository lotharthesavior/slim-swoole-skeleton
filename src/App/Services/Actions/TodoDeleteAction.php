<?php

namespace App\Services\Actions;

use App\Services\Actions\Interfaces\TodoActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;

class TodoDeleteAction implements TodoActionInterface
{
    public function __construct(array $params, DataDriverInterface $dataDriver)
    {

    }

    public function execute()
    {
        
    }
}