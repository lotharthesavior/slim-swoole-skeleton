<?php

namespace App\Services\Actions;

use App\Services\Actions\Interfaces\TodoActionInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;

class TodoUpdateAction implements TodoActionInterface
{
    public function __construct(array $params, DataDriverInterface $dataDriver)
    {

    }

    public function execute()
    {
        
    }
}