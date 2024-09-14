<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes/routes.php';

// Obtener la URI solicitada
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
var_dump('Request URI: URL QUE ENTRA', $requestUri);
// Eliminar la parte de la base '/restaurante' de la URI
$requestUri = str_replace('/restaurante', '', $requestUri);

// Depurar la URI solicitada
var_dump('Request URI:', $requestUri);

// Verificar si la URL coincide con alguna de las rutas definidas
$routeFound = false;

/**
 * Iiteramos sobre las rutas y sus funciones importadas desde routes.php
 * str_replace escapa las barras para que puedan usarse en una expresion regular
 * preg_replace: sustiye o verifica los parametros de ruta con una expresion que captura caracteres alfanuméricos
 * si hay coincidencia preg_match da true y llena el array matches con los valores capturados de la URL
 * 
 */
foreach ($routes as $route => $callback) {
    // Reemplazar los parámetros {id} por una expresión regular para capturarlos
    $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', str_replace('/', '\/', $route)); 
    //
    var_dump('Request URI after replacement:', $requestUri);
    if (preg_match('/^' . $pattern . '$/', $requestUri, $matches)) {
        // Depurar la ruta coincidente y los parámetros capturados
        var_dump('Matched Route:', $route);
        var_dump('Parameters:', $matches);

        array_shift($matches); // Eliminar el primer elemento que es la ruta completa
        /**
         * Matches devuelve en este caso el id del producto encerrado como elemento [1] del array
         * y llama a la function callback añadiendo este elemento de array que
         * en este caso como proviene de un array empieza con ...
         */
        $callback(...$matches); // Llamar al callback con los parámetros de la URL
        $routeFound = true;
        break;
    }
}

if (!$routeFound) {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}

