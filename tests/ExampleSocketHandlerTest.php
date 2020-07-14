<?php

use PHPUnit\Framework\TestCase;
use Slim\Container;

use App\Services\SocketHandlers\Abstractions\SocketHandler;
use App\Services\SocketHandlers\ExampleSocketHandler;
use App\Services\Actions\ExampleCreateAction;
use App\Services\Actions\ExampleUpdateAction;
use App\Services\Actions\ExampleDeleteAction;
use App\Drivers\Data\Filesystem;

class ExampleSocketHandlerTest extends TestCase
{
    /** @var Container */
    protected $container;

    /** @var string */
    const DEFAULT_CONTENT = 'Some content';

    /**
     * @return void
     */
    public function setUp() : void
    {
        $this->mockAppContainer();
    }

    /**
     * @return array
     */
    public function actionsDataProvider() : array
    {
        return [
            [SocketHandler::READ_ACTION],
            [SocketHandler::CREATE_ACTION],
            [SocketHandler::UPDATE_ACTION],
            [SocketHandler::DELETE_ACTION],
        ];
    }

    /**
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
            [SocketHandler::CREATE_ACTION, ExampleCreateAction::class],
            [SocketHandler::UPDATE_ACTION, ExampleUpdateAction::class],
            [SocketHandler::DELETE_ACTION, ExampleDeleteAction::class],
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
        $data = $this->prepareData(SocketHandler::READ_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testGetActionReadsAllRecordAndReturnsResource()
    {
        $data = $this->prepareData(SocketHandler::READ_ACTION . '-all');
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testCreateActionCreatesRecordAndReturnsResource()
    {
        $data = $this->prepareData(SocketHandler::CREATE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testUpdateActionUpdatesRecordAndReturnsResource()
    {
        $data = $this->prepareData(SocketHandler::UPDATE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertArrayHasKey('content', $result);
        $this->assertEquals(self::DEFAULT_CONTENT, $result['content']);
    }

    public function testDeleteActionDeletesRecordAndReturnsBoolean()
    {
        $data = $this->prepareData(SocketHandler::DELETE_ACTION);
        $socketHandler = $this->getSocketHandler();

        $action = $socketHandler->parseData($data);
        $result = $action->execute();

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    private function mockAppContainer() : void
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('create')->andReturn(1);
        $filesystem->shouldReceive('update')->andReturn(true);
        $filesystem->shouldReceive('delete')->andReturn(true);
        $filesystem->shouldReceive('get')->andReturn([
            'content' => self::DEFAULT_CONTENT,
        ]);

        $this->container = new stdClass;
        $this->container->dataDriver = $filesystem;
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
            case SocketHandler::READ_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                    ],
                ]);
                break;

            case SocketHandler::READ_ACTION . '-all':
                return json_encode([
                    'action' => SocketHandler::READ_ACTION,
                    'params' => [],
                ]);
                break;

            case SocketHandler::CREATE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'content' => 'Some Sample Content',
                    ],
                ]);
                break;

            case SocketHandler::UPDATE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                        'content' => 'Some Sample Content',
                    ],
                ]);
                break;

            case SocketHandler::DELETE_ACTION:
                return json_encode([
                    'action' => $action,
                    'params' => [
                        'id' => 1,
                    ],
                ]);
                break;
        }
    }
}