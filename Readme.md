# Slim 3 - Swoole - Skeleton

This application is a skeleton for Slim3/Swoole application using HTTP and Socket servers. There are a few TODO's at the end of this document set as goals for this to serve as a complete example.

The frontend is built using AlpineJS and uses JS Events to update components based on messages received by the socket server.

## Dependencies

- Slim Framework (https://www.slimframework.com/)
- Swoole (PHP Extension) (https://www.swoole.co.uk)
- PHPUnit (https://phpunit.de)
- PHP League Flysystem (https://flysystem.thephpleague.com)
- AlpineJS for UI (https://github.com/alpinejs/alpine)

## Details

The data is being kept in the filesystem, the only driver available right now. It is in the roadmap to enhance this part.

To be able to use the filesystem data persistence, create the directory at the root of this project: `/data/todos`.

## To start HTTP Server

(using swoole)

This is how your index.php file should look like:

```php
```php
(require __DIR__ . '/src/http_server.php')($app); // <-- swoole http server
// $app->run(); // <-- cgi http servers
```
```

```shell
php index.php
```

(using CGI server)
- first we have to comment out the swoole server and uncomment the normal application start, it would look like this after this:
```php
// (require __DIR__ . '/src/http_server.php')($app); // <-- swoole http server
$app->run(); // <-- cgi http servers
```
- once that is done, we could use any web server of our choice or even run the usual php built in server for development purposes:
```shell
php -S localhost:8080
```

## To start Socket Server

```shell
php index.php --websocket
```

## Todo

- Prepare HTTP Api for data routines
- Finalize the data cycle example (the remaining CRUD operations)
- Enhance the UI for a better presentaiton