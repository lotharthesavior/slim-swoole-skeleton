<?php

namespace Tests;

use Mockery;
use stdClass;
use InvalidArgumentException;
use Tests\Assets\SampleAction;
use PHPUnit\Framework\TestCase;
use App\Drivers\Data\Filesystem;
use App\Services\Actions\Abstractions\AbstractAction;

class SocketHandlerTestCase extends TestCase
{
    /** @var Container */
    protected $container;

    /**
     * @return void
     */
    protected function mockAppContainer() : void
    {
        $this->container = new stdClass;
    }

    /**
     * @return AbstractAction
     */
    protected function getSampleAction() : AbstractAction
    {
        return new SampleAction();
    }
}