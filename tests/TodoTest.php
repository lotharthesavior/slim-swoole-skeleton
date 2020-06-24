<?php

use PHPUnit\Framework\TestCase;
use App\Models\Todo;
use App\Drivers\Data\Interfaces\DataDriverInterface;
use App\Drivers\Data\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;

class TodoTest extends TestCase
{
    /** @var Flysystem */
    protected static $flysystem;

    /** @var DataDriverInterface */
    protected static $dataDriver;

    /** @var string */
    protected static $database = 'data-test';

    /** @var string */
    protected $sampleTodoContent = 'My sample todo item.';

    public static function setUpBeforeClass() : void
    {
        $adapter = new Local(__DIR__.'/');
        self::$flysystem = new Flysystem($adapter);
        self::$dataDriver = new Filesystem(self::$database, self::$flysystem);
    }

    protected function setUp() : void
    {
        self::$flysystem->createDir(self::$database);
    }

    protected function tearDown() : void
    {
        self::$flysystem->deleteDir(self::$database);
    }

    public function testCreateTodoItem()
    {
        $todo = $this->createDummyTodoItem();

        $existentTodoItems = $todo->get();

        $this->assertCount(1, $existentTodoItems);
    }

    public function testUpdateTodoItem()
    {
        $newContent = 'My custom content';

        $todo = $this->createDummyTodoItem();
        
        $todo->update(1, [
            'content' => $newContent
        ]);

        $content = $todo->get(1);

        $this->assertEquals($newContent, $content['content']);
    }

    public function testGetTodoItem()
    {
        $todo = $this->createDummyTodoItem();

        $content = $todo->get(1);

        $this->assertEquals($this->sampleTodoContent, $content['content']);
    }

    public function testDeleteTodoItem()
    {
        $todo = $this->createDummyTodoItem();

        $existentTodoItems = $todo->get();
        $this->assertCount(1, $existentTodoItems);

        $todo->delete(1);

        $existentTodoItems = $todo->get();
        $this->assertCount(0, $existentTodoItems);
    }

    private function createDummyTodoItem() : Todo
    {
        $todo = new Todo(self::$dataDriver);

        $todo->create(['content' => $this->sampleTodoContent]);

        return $todo;
    }
}