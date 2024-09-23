<?php 

declare(strict_types=1);


use App\Controllers\ProductosController;
use App\Controllers\ServiciosController;
use App\Controllers\PedidoController;
use App\Helpers\Helper;
use App\Models\Pedido;
use App\Models\Productos;
use App\Models\Servicios;
$servicio = new Servicios;
$producto = new Productos;
$pedido = new Pedido($producto, $servicio);
$productoController = new ProductosController($producto);
$serviciosController = new  ServiciosController($servicio);
$pedidoController = new PedidoController($pedido);

$routes = [
    '/productos' => function() use ($productoController):void{
        $productoController->selectProductos();
    },

    '/productos/{id}' => function($id) use ($productoController):void{
        $productoController->selectUnProducto((int) $id);
    },


    '/pizzas' => function() use ($productoController) {
        $productoController->verTodosLosProductosPorTipo('pizza');
    },


    '/bebidas' => function() use ($productoController) {
        $productoController->verTodosLosProductosPorTipo('bebida');
    },

    '/cafes' => function() use ($productoController) {
        $productoController->verTodosLosProductosPorTipo('cafe');
    },

    '/test' => function():void {
        require_once __DIR__ . '/../../public/test.php';

    },

    '/openservice' =>function() use ($serviciosController){
        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            $data = json_decode(file_get_contents("php://input"), true);
            $serviciosController->abrirServicioController($data);  
        }else {
            Helper::response(405, 'error', 'Metodo no permitido');

        }
    },

    '/closeservice'=>function() use($serviciosController){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $serviciosController->cerrarServicioController($data);
            
        }else{
            Helper::response(405, 'error', 'Metodo no permitido');
        }
        
    },

    '/addproduct' => function() use ($pedidoController) {
    // Asegúrate de que el método HTTP es POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            // Decodifica el JSON de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);
            $myDTO = new \App\Helpers\MyDTO(
                (int)$data['mesa'],
                (int)$data['id_producto'],
                (int)$data['cantidad']
            );
            $pedidoController->hacerPedido($myDTO);   
        } else {
            Helper::response(405, 'error', 'Metodo no permitido');
    }
    },

    '/deleteproduct' => function() use($pedidoController){
    if($_SERVER["REQUEST_METHOD"] === "DELETE"){
         $data = json_decode(file_get_contents('php://input'), true);
         $myDTO = new \App\Helpers\MyDTO(
            (int)$data['mesa'],
            (int)$data['id_producto'],
            (int)$data['cantidad']
        );
         $pedidoController->eliminarPedido($myDTO);
    }else {
        Helper::response(405, 'error', 'Metodo no permitido');
    }
    },

    '/verproductos/{mesa}' => function($mesa) use($pedidoController){
        $pedidoController->verProductos((int)$mesa);
    }



];
