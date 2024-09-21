<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Productos;
use Exception;
use App\Helpers\Helper;
Class ProductosController{
    private Productos $productosController;

    public function __construct(){
        $this->productosController = new Productos();
    }

    public function verTodosLosProductosPorTipo(string $tipo): void {
        $tiposPermitidos = ['pizza', 'bebidas', 'cafe'];
        if(in_array($tipo, $tiposPermitidos)){
            $infoProductos=$this->productosController->selectPorTipo($tipo);
            Helper::response(200, "exito", $infoProductos);
        }else{
            Helper::response(404, "error", "no se han encontrado estos productos");
        }
    }

    public function selectProductos(){
        $infoProducto = $this->productosController->selectProductos();
         if($infoProducto){
            Helper::response(200, "exito", $infoProducto);
         }else if(empty($infoProducto)){
            Helper::response(400, "error", "no hay productos");
         }
    }

    public function selectUnProducto(int $id_producto){
        if(filter_var($id_producto, FILTER_VALIDATE_INT)){
            $infoProducto = $this->productosController->selectUnProducto($id_producto);
            if(empty($infoProducto)){
                Helper::response(404, "error", "producto no encontrado");
                return;
            }
            Helper::response(200, "exito", $infoProducto);
        }else{
            Helper::response(400, "error", "valor no numérico");
            
        }
    }
  


}