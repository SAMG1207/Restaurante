<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once __DIR__.'/src/core/error_handler.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes/routes.php';

use App\Helpers\Helper;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace('/restaurante','', $requestUri);

$dispatcher = new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $requestUri);
    echo $response;
} catch (HttpRouteNotFoundException $e) {
    Helper::response(404, "error", "Route not found");
} catch (HttpMethodNotAllowedException $e) {
    Helper::response(405, "error", "Method not allowed");
}
