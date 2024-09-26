<?php
declare(strict_types=1);

use Phroute\Phroute\RouteCollector;
use App\Controllers\ProductosController;
use App\Controllers\ServiciosController;
use App\Controllers\PedidoController;

use App\Models\Pedido;
use App\Models\Productos;
use App\Models\Servicios;

$servicio = new Servicios;
$producto = new Productos;
$pedido = new Pedido($producto, $servicio);
$productoController = new ProductosController($producto);
$serviciosController = new ServiciosController($servicio);
$pedidoController = new PedidoController($pedido);

$router = new RouteCollector();

// Ruta para obtener todos los productos
$router->get('/productos', function() use ($productoController) {
    return $productoController->selectProductos();
});

// Ruta para obtener un producto por su ID
$router->get('/productos/{id:\d+}', function($id) use ($productoController) {
    return $productoController->selectUnProducto((int)$id);
});

$router->get('/pizzas', function() use ($productoController){
    return $productoController->verTodosLosProductosPorTipo('pizza');
});

$router->get('/bebidas', function() use ($productoController){
    return $productoController->verTodosLosProductosPorTipo('bebida');
});

$router->get('/cafes', function() use ($productoController){
    return $productoController->verTodosLosProductosPorTipo('cafe');
});

$router->post('/openservice' , function() use($serviciosController){
    $data = json_decode(file_get_contents("php://input"), true);
    return $serviciosController->abrirServicioController($data);
});

$router->post('/closeservice', function() use($serviciosController){
    $data = json_decode(file_get_contents('php://input'), true);
    return $serviciosController->cerrarServicioController($data);
});
$router->get('/seeservice/{mesa:\d+}', function($mesa) use($serviciosController){
return $serviciosController->verServicio((int)$mesa);
});
$router->post('/addproduct', function() use($pedidoController){
    $data = json_decode(file_get_contents('php://input'), true);
    $myDTO = new \App\Helpers\MyDTO(
        (int)$data['mesa'],
        (int)$data['id_producto'],
        (int)$data['cantidad']
    );
    return $pedidoController->hacerPedido($myDTO);
});

$router->delete('/deleteproduct', function() use($pedidoController){
    $data = json_decode(file_get_contents('php://input'), true);
    $myDTO = new \App\Helpers\MyDTO(
        (int)$data['mesa'],
        (int)$data['id_producto'],
        (int)$data['cantidad']
    );
    return $pedidoController->eliminarPedido($myDTO); 
});

$router->get('/verproductos/{mesa:\d+}', function($mesa) use($pedidoController){
    return $pedidoController->verProductos((int)$mesa);
});



