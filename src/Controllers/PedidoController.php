<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use Exception;

class PedidoController{
    private Pedido $pedidoController;

    public function __construct(){
        $this->pedidoController = new Pedido();
    }

    public function hacerPedido(int $mesa, $id_producto, $cantidad){
        $pedido = $this->pedidoController->insertPedido($mesa, $id_producto, $cantidad);
        if($pedido){
            echo json_encode([
                'status'=>'exitoso',
                'message' => 'Mesa abierta correctamente',
                'id_servicio' => $pedido
                ]);
                http_response_code(201);
        }else{
            echo json_encode([
                'error'=>'ha habido un error'
            ]);
            http_response_code(400);
        }
    }
}