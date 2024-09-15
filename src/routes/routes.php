<?php 

declare(strict_types=1);


use App\Controllers\ProductosController;
use App\Controllers\ServiciosController;

$productoController = new ProductosController();
$serviciosController = new  ServiciosController();


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
            if(isset($data["mesa"]) && is_int($data['mesa'])){
                $serviciosController->abrirServicioController((int)$data['mesa']);
            }else {
                // Responde con un error si los datos son inválidos
                echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
                http_response_code(400); // Código 400: Solicitud incorrecta
            }
        }else {
            // Si no es POST, responde con un error 405: Método no permitido
            http_response_code(405); // Código 405: Método no permitido
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        }
    }


];
