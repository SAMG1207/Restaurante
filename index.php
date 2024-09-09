<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/src/routes/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if(array_key_exists($requestUri, $routes)){
    $routes[$requestUri]();
}else{
    http_response_code(404);
    echo json_encode(['error'=>'Ruta No encontrada']);
    
}