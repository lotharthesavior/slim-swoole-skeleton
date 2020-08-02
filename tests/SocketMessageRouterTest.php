<?php

namespace Tests;

use Exception;
use League\Pipeline\Pipeline;
use Tests\Assets\SampleAction;
use Tests\SocketHandlerTestCase;
use Tests\Assets\SampleMiddleware;
use App\Services\SocketHandlers\SocketMessageRouter;

class SocketMessageRouterTest extends SocketHandlerTestCase
{
    /**
     * @return void
     */
    public function setUp() : void
    {
        $this->mockAppContainer();
    }

    public function testCanAddHandlerForAction()
    {
        [$socketRouter, $sampleAction] = $this->prepareSocketMessageRouter();
        
        $this->assertInstanceOf(SocketMessageRouter::class, $socketRouter);
        $this->assertInstanceOf(SampleAction::class, $sampleAction);
    }

    public function testCanExecuteAction()
    {
        [$socketRouter, $sampleAction] = $this->prepareSocketMessageRouter();

        $data = json_encode([
            'action' => $sampleAction->getName(),
        ]);
        $result = ($socketRouter)($data);

        $this->assertTrue($result);
    }

    public function testCanAddMiddlewareToPipelineOfHandlerAndExecute()
    {
        [$socketRouter, $sampleAction] = $this->prepareSocketMessageRouter();

        $socketRouter->pipe($sampleAction->getName(), new SampleMiddleware);

        $data = json_encode([
            'action' => $sampleAction->getName(),
            'token'  => 'valid-token',
        ]);
        $result = ($socketRouter)($data);
        $this->assertTrue($result);
    }

    public function testCanAddMiddlewareToPipelineOfHandlerAndFail()
    {
        $this->expectException(Exception::class);

        [$socketRouter, $sampleAction] = $this->prepareSocketMessageRouter();

        $socketRouter->pipe($sampleAction->getName(), new SampleMiddleware);

        $data = json_encode([
            'action' => $sampleAction->getName(),
            'token'  => 'invalid-token',
        ]);
        $result = ($socketRouter)($data);
    }

    /**
     * @return array
     */
    private function prepareSocketMessageRouter()
    {
        $sampleAction = $this->getSampleAction();
        $socketRouter = new SocketMessageRouter($this->container);
        $resultOfAddMethod = $socketRouter->add($sampleAction);

        $this->assertInstanceOf(get_class($resultOfAddMethod), $socketRouter);

        return [$socketRouter, $sampleAction];
    }
}