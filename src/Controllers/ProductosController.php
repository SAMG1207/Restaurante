<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Productos;
use App\Helpers\Responser;
Class ProductosController{

    public function __construct(private Productos $producto){
    }

    public function verTodosLosProductosPorTipo(string $tipo): void {
        $tiposPermitidos = ['pizza', 'bebida', 'cafe'];
        if(in_array($tipo, $tiposPermitidos)){
            $infoProductos=$this->producto->selectPorTipo($tipo);
            Responser::response(200,  $infoProductos);
        }else{
            Responser::response(404,  "no se han encontrado estos productos");
        }
    }

    public function selectProductos():void{
        $infoProducto = $this->producto->selectProductos();
         if($infoProducto){
            Responser::response(200,  $infoProducto);
         }else if(empty($infoProducto)){
            Responser::response(400,  "no hay productos");
         }
    }

    public function selectUnProducto(int $id_producto):void{
        if(filter_var($id_producto, FILTER_VALIDATE_INT)){
            $infoProducto = $this->producto->selectUnProducto($id_producto);
            if(empty($infoProducto)){
                Responser::response(404,  "producto no encontrado");
                return;
            }
            Responser::response(200,  $infoProducto);
        }else{
            Responser::response(400,  "valor no numérico");
            
        }
    }
  


}