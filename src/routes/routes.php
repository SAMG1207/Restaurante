<?php 

declare(strict_types=1);


use App\Controllers\ProductosController;

$productoController = new ProductosController();



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

    }


];
