<?php

namespace Tests;

use Mockery;
use Exception;
use InvalidArgumentException;
use Slim\Container;
use App\Drivers\Data\Filesystem;
use App\Services\SocketHandlers\Abstractions\SocketHandler;
use App\Services\SocketHandlers\ExampleSocketHandler;
use App\Services\Actions\ExampleCreateAction;
use App\Services\Actions\ExampleUpdateAction;
use App\Services\Actions\ExampleDeleteAction;

class ExampleSocketHandlerTest extends SocketHandlerTestCase
{
    /** @var string */
    const DEFAULT_CONTENT = 'Some content';

    /**
     * @return void
     */
    public function setUp() : void
    {
        $this->mockAppContainerFilesystem();
    }

    /**
     * @return array
     */
    public function actionsDataProvider() : array
    {
        return [
            [ExampleSocketHandler::READ_ACTION],
            [ExampleSocketHandler::CREATE_ACTION],
            [ExampleSocketHandler::UPDATE_ACTION],
            [ExampleSocketHandler::DELETE_ACTION],
        ];
    }

    /**
     * @param string $action
     *
     * @dataProvider actionsDataProvider
     */
    public function testThrowExceptionWhenDataWithoutContentAtAction(
        string $action
    ) {
        $this->expectException(InvalidArgumentException::class);

        $data = json_encode([
            'action' => $action,
        ]);
        $socketHandler = $this->getSocketHandler();

        $socketHandler->parseData($data);
    }

    /**
     * @return array
     */
    public function actionsParserDataProvider() : array
    {
        return [
            [ExampleSocketHandler::CREATE_ACTION, ExampleCreateAction::class],
            [ExampleSocketHandler::UPDATE_ACTION, ExampleUpdateAction::class],
            [ExampleSocketHandler::DELETE_ACTION, ExampleDeleteAction::class],
        ];
    }

    /**
     * @param string $actionName
     * @param string $className
     *
     * @dataProvider actionsParserDataProvider
     */
    public function testActionsServedByDataParsed(
        string $actionName,
        string $className
    ) {
        $data = $this->prepareData($actionName);
        $socketHandler = $this->getSocketHandler();

        $this->assertInstanceOf($className, $socketHandler->parseData($data));
    }

    public function testGetActionReadsRecordAndReturnsResource()
    {
        $data = $this->prepareData(ExampleSocketHandler::READ_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testGetActionReadsAllRecordAndReturnsResource()
    {
        $data = $this->prepareData(ExampleSocketHandler::READ_ACTION . '-all');
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testCreateActionCreatesRecordAndReturnsResource()
    {
        $data = $this->prepareData(ExampleSocketHandler::CREATE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testUpdateActionUpdatesRecordAndReturnsResource()
    {
        $data = $this->prepareData(ExampleSocketHandler::UPDATE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testDeleteActionDeletesRecordAndReturnsBoolean()
    {
        $data = $this->prepareData(ExampleSocketHandler::DELETE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertTrue($result);
    }

    /**
     * @return ExampleSocketHandler
     */
    private function getSocketHandler(): ExampleSocketHandler
    {
        return new ExampleSocketHandler($this->container);
    }

    /**
     * @param string $action
     * @return string
     */
    private function prepareData(string $action): string
    {
        switch ($action) {
            case ExampleSocketHandler::READ_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                    ],
                ]);
                break;

            case ExampleSocketHandler::READ_ACTION . '-all':
                return json_encode([
                    'action' => ExampleSocketHandler::READ_ACTION,
                    'params' => [],
                ]);
                break;

            case ExampleSocketHandler::CREATE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'content' => 'Some Sample Content',
                    ],
                ]);
                break;

            case ExampleSocketHandler::UPDATE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                        'content' => 'Some Sample Content',
                    ],
                ]);
                break;

            case ExampleSocketHandler::DELETE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                    ],
                ]);
                break;
        }
    }

    /**
     * This requires Container to be mocked
     *
     * @return void
     */
    private function mockAppContainerFilesystem()
    {
        $this->mockAppContainer();

        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('create')->andReturn(1);
        $filesystem->shouldReceive('update')->andReturn(true);
        $filesystem->shouldReceive('delete')->andReturn(true);
        $filesystem->shouldReceive('get')->andReturn([
            'content' => self::DEFAULT_CONTENT,
        ]);

        $this->container->dataDriver = $filesystem;
    }
}