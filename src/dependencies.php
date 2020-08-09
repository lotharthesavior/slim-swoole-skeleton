<?php

use Slim\Container;
use Monolog\Logger;
use App\Models\ModelExample;
use Monolog\Handler\StreamHandler;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;
use App\Drivers\Data\Filesystem;
use Conveyor\SocketHandlers\SocketMessageRouter;
use App\Services\Actions\ExampleCreateAction;
use App\Services\Actions\ExampleDeleteAction;
use App\Services\Actions\ExampleGetAction;
use App\Services\Actions\ExampleUpdateAction;

return function (Container $container) {
    $container['logger'] = function ($c) {
        $logger = new Logger('my_logger');
        $file_handler = new StreamHandler(__DIR__ . '/../logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    };

    $container['filesystem'] = function ($c) {
        $adapter = new Local(__DIR__ . '/../');
        return new Flysystem($adapter);
    };

    $container['dataDriver'] = function ($c) {
        return new Filesystem('data', $c->filesystem);
    };

    $container['socketHandler'] = function ($c) {
        $socketRouter = SocketMessageRouter::getInstance();
        $model = ModelExample::class;

        $socketRouter->add(new ExampleCreateAction(
            $c->dataDriver,
            $model
        ));
        $socketRouter->add(new ExampleDeleteAction(
            $c->dataDriver,
            $model
        ));
        $socketRouter->add(new ExampleGetAction(
            $c->dataDriver,
            $model
        ));
        $socketRouter->add(new ExampleUpdateAction(
            $c->dataDriver,
            $model
        ));

        return $socketRouter;
    };
};
