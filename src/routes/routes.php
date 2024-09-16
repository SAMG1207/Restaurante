<?php 

declare(strict_types=1);


use App\Controllers\ProductosController;
use App\Controllers\ServiciosController;
use App\Controllers\PedidoController;

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
    },

    '/closeservice'=>function() use($serviciosController){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['mesa']) && is_int($data['mesa'])){
                $serviciosController->cerrarServicioController((int)$data['mesa']);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
                http_response_code(400);
            } 
        }else{
            http_response_code(405); // Código 405: Método no permitido
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        }
        
    },

'/addproduct' => function() use ($pedidoController) {
    // Asegúrate de que el método HTTP es POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Decodifica el JSON de la solicitud
            $data = json_decode(file_get_contents('php://input'), true);

            // Verifica si los datos requeridos están presentes y son del tipo correcto
            if (isset($data['mesa'], $data['id_producto'], $data['cantidad']) &&
                is_int($data['mesa']) && is_int($data['id_producto']) && is_int($data['cantidad'])) {

                // Llama al controlador para procesar el pedido
                $pedidoController->hacerPedido((int)$data['mesa'], (int)$data['id_producto'], (int)$data['cantidad']);
            } else {
                // Respuesta de error si los datos no son válidos
                echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
                http_response_code(400); // Código 400: Solicitud incorrecta
            }
        } catch (Exception $e) {
            // Manejo de excepciones
            echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
            http_response_code(500); // Código 500: Error interno del servidor
        }
    } else {
        // Responde con un error 405 si el método HTTP no es POST
        http_response_code(405); // Código 405: Método no permitido
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    }
}



];
