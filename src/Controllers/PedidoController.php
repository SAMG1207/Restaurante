<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use App\Helpers\Helper;

class PedidoController{
    private Pedido $pedidoController;

    public function __construct(){
        $this->pedidoController = new Pedido();
    }
    
 
 
    public function hacerPedido($data){
        if (
        filter_var($data['mesa'], FILTER_VALIDATE_INT) === false ||
        filter_var($data['id_producto'], FILTER_VALIDATE_INT) === false ||
        filter_var($data['cantidad'], FILTER_VALIDATE_INT) === false
    ){
        Helper::response(400, 'error', 'error en los argumentos');
    }else{
        $mesa = (int)$data['mesa'];
        $id_producto = (int)$data['id_producto'];
        $cantidad = (int)$data['cantidad'];
         $this->pedidoController->insertPedido($mesa, $id_producto, $cantidad);
         Helper::response(201, 'exitoso', 'Pedido hecho correctamente');
    }
}
     


    public function elminarPedido($data){
        if (
        filter_var($data['mesa'], FILTER_VALIDATE_INT) === false ||
        filter_var($data['id_producto'], FILTER_VALIDATE_INT) === false ||
        filter_var($data['cantidad'], FILTER_VALIDATE_INT) === false
    ){
        Helper::response(400, 'error', 'error en los argumentos');
    }else{
        $mesa = (int)$data['mesa'];
        $id_producto = (int)$data['id_producto'];
        $cantidad = (int)$data['cantidad'];
         
         if($this->pedidoController->borrarPedido($mesa, $id_producto, $cantidad)){
            Helper::response(200, 'exitoso', 'Pedido eliminado correctamente');
         }else{
            Helper::response(404,'Error', 'No se han encontrado los prodcutos a eiminar');
         }
         
    }
}

        

        public function verProductos(int $mesa) {
            
        
            if (filter_var($mesa, FILTER_VALIDATE_INT) !== false) {
                $productos = $this->pedidoController->pedidosExistentes($mesa);
                if ($productos) {
                    Helper::response(200, "Exitoso", $productos); // Changed status code to 200
                } else {
                    Helper::response(404, "Error", "No se encontraron productos para la mesa especificada.");
                }
            } else {
                Helper::response(400, "Error", "El valor de la mesa no es válido.");
            }
        }
    }
        