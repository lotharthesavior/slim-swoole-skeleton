<?php

use Slim\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as Flysystem;

use App\Drivers\Data\Filesystem;
use App\Services\SocketHandlers\ExampleSocketHandler;

return function (Container $container) {
    $container['logger'] = function($c) {
        $logger = new Logger('my_logger');
        $file_handler = new StreamHandler(__DIR__ . '/../logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    };

    $container['filesystem'] = function($c) {
        $adapter = new Local(__DIR__ . '/../');
        return new Flysystem($adapter);
    };

    $container['dataDriver'] = function($c) {
        return new Filesystem('data', $c->filesystem);
    };

    $container['socketHandler'] = function($c) {
        return new ExampleSocketHandler($c);
    };
};
