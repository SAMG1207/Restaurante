<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once __DIR__.'/src/core/error_handler.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes/routes.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); 
    exit; 
}
use App\Helpers\Responser;
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
    Responser::response(404,  "Route not found");
} catch (HttpMethodNotAllowedException $e) {
    Responser::response(405,  "Method not allowed");
}
