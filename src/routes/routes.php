<?php 

declare(strict_types=1);


use App\Controllers\ProductosController;
use App\Controllers\ServiciosController;
use App\Controllers\PedidoController;
use App\Helpers\Helper;
$productoController = new ProductosController();
$serviciosController = new  ServiciosController();
$pedidoController = new PedidoController();

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
            $pedidoController->hacerPedido($data);   
        } else {
            Helper::response(405, 'error', 'Metodo no permitido');
    }
    },

    '/deleteproduct' => function() use($pedidoController){
    if($_SERVER["REQUEST_METHOD"] === "DELETE"){
         $data = json_decode(file_get_contents('php://input'), true);
         $pedidoController->elminarPedido($data);
    }else {
        Helper::response(405, 'error', 'Metodo no permitido');
    }
    },

    '/verproductos/{mesa}' => function($mesa) use($pedidoController){
        $pedidoController->verProductos((int)$mesa);
    }



];
