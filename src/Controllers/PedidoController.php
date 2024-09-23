<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use App\Helpers\Helper;
use App\Helpers\MyDTO;
class PedidoController{
 
    public function __construct(
        private Pedido $pedido
    ) {
    }

   public  function hacerPedido(myDTO $data){
    $this->pedido->insertPedido(
        $data->mesa,
        $data->id_producto,
        $data->cantidad
    )?
    Helper::response(201, 'exitoso', 'Pedido hecho correctamente'):
    Helper::response(400, "error", "error en los argumentos");
   }
    public function eliminarPedido(myDTO $data){
        $this->pedido->borrarPedido(
            $data->mesa,
            $data->id_producto,
            $data->cantidad
        )?
        Helper::response(200, 'exitoso', 'Pedido hecho correctamente'):
        Helper::response(400, "error", "error en los argumentos");
     }   

        

        public function verProductos(int $mesa) {
            $productos = $this->pedido->pedidosExistentes($mesa);
            if(!$productos){
                Helper::response(404, "Error", "No se encontraron productos para la mesa especificada.");
            }
                Helper::response(200, "Exitoso", $productos);
        }
        
    }
        