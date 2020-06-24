<?php

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Slim\Container;

return function (Container $container) {
    $container['logger'] = function($c) {
        $logger = new Logger('my_logger');
        $file_handler = new StreamHandler(__DIR__ . '/../logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    };
};
