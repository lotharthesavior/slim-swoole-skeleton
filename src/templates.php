<?php

use \Slim\Container;
use \Slim\Views\PhpRenderer;

return function(Container $container) {
    $container['view'] = new PhpRenderer(__DIR__ . '/../templates/');
    $container['view']->setLayout("layout.php");
};