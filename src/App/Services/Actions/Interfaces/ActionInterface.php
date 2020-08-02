<?php

namespace App\Services\Actions\Interfaces;

interface ActionInterface
{
    public function execute();
    public function getName() : string;
}
