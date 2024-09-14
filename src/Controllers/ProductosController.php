<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Productos;
use Exception;

Class ProductosController{
    private Productos $productosController;

    public function __construct(){
        $this->productosController = new Productos();
    }

    public function verTodosLosProductosPorTipo(string $tipo): void {
        try {
            $infoProductos = $this->productosController->selectPorTipo($tipo);
            header('Content-Type: application/json');
            if (empty($infoProductos)) {
                http_response_code(404); // No encontrado
                echo json_encode(['error' => "No se encontraron productos de tipo $tipo."]);
                return;
            }
            http_response_code(200); // Éxito
            echo json_encode($infoProductos);
        } catch (Exception $e) {
            http_response_code(500); // Error del servidor
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function selectProductos(){
        try{
            $infoProducto = $this->productosController->selectProductos();
            header('Content-Type: application/json');
            if(empty($infoProducto)){
                http_response_code(404); // No encontrado
                echo json_encode(['error' => 'Productos no encontrados']);
                return;
            }
            http_response_code(200); // Éxito
            echo json_encode($infoProducto);
        }catch(Exception $e){
            http_response_code(500); // Error del servidor
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function selectUnProducto(int $id_producto){
        try{
            $infoProducto = $this->productosController->selectUnProducto($id_producto);
            header('Content-Type: application/json');
            if(empty($infoProducto)){
                http_response_code(404); // No encontrado
                echo json_encode(['error' => 'Producto no encontrado']);
                return;
            }
            http_response_code(200); // Éxito
            echo json_encode($infoProducto);
        }catch(Exception $e){
            http_response_code(500); // Error del servidor
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

 
}