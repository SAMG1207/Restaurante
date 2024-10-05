<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use App\Helpers\Responser;
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
    Responser::response(201,  'added'):
    Responser::response(400,  "error");
   }
    public function eliminarPedido(myDTO $data){
        $this->pedido->borrarPedido(
            $data->mesa,
            $data->id_producto,
            $data->cantidad
        )?
        Responser::response(200,  'deleted'):
        Responser::response(400,  "error");
     }   

        

        public function verProductos(int $mesa) {
            $productos = $this->pedido->totalMesa($mesa);
            if(!$productos){
                Responser::response(404,  "No se encontraron productos para la mesa especificada.");
            }
                Responser::response(200,  $productos);
        }
        
    }
        