# Slim 3 - Swoole - Skeleton

![PHP Composer](https://github.com/lotharthesavior/slim-swoole-skeleton/workflows/PHP%20Composer/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lotharthesavior/slim-swoole-skeleton/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lotharthesavior/slim-swoole-skeleton/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/lotharthesavior/slim-swoole-skeleton/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

This application is a skeleton for Slim3/Swoole application using HTTP and Socket servers. There are a few TODO's at the end of this document set as goals for this to serve as a complete example.

The frontend is built using AlpineJS and uses JS Events to update components based on messages received by the socket server.

## Dependencies

- Slim Framework (https://www.slimframework.com/)
- Swoole (PHP Extension) (https://www.swoole.co.uk)
- PHPUnit (https://phpunit.de)
- AlpineJS for UI (https://github.com/alpinejs/alpine)

## Details

The data is being kept in the filesystem, the only driver available right now. It is in the roadmap to enhance this part.

To be able to use the filesystem data persistence, create the directory at the root of this project: `/data/todos`.

### Installation

The current version uses filesystem to persist data. For that to work right out of the box with the existent example model you just need to create the directory at the root of the project: `data/todos`.

### Http

Routes are specified at the file `src/routes.php`. The specific resources routes are intended to be kept at `/src/App/Http/todo_resource_routes.php`.

#### Validation

The request validations are done via **Middlewares**. These Middlewares can be found at `src/App/Http/Middlewares`.

#### To start HTTP Server

**(using swoole)**

This is how your `index.php` file should look like:

```php
(require __DIR__ . '/src/http_server.php')($app); // <-- swoole http server
// $app->run(); // <-- cgi http servers
```

```shell
php index.php
```

**(using CGI server)**
- first we have to comment out the swoole server and uncomment the normal application start, it would look like this after this:
```php
// (require __DIR__ . '/src/http_server.php')($app); // <-- swoole http server
$app->run(); // <-- cgi http servers
```
- once that is done, we could use any web server of our choice or even run the usual php built in server for development purposes:
```shell
php -S localhost:8080
```
### Socket

#### To start Socket Server

```shell
php index.php --websocket
```

## Todo

- Prepare HTTP Api for data routines
- Authorization Cycle
- Enhance the example's UI
