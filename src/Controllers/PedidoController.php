<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use CachingIterator;
use Exception;

class PedidoController{
    private Pedido $pedidoController;

    public function __construct(){
        $this->pedidoController = new Pedido();
    }

    public function hacerPedido(int $mesa, $id_producto, $cantidad){
        try{
            $pedido = $this->pedidoController->insertPedido($mesa, $id_producto, $cantidad);
            if($pedido){
                http_response_code(201);
                echo json_encode([
                    'status'=>'exitoso',
                    'message' => 'Productos insertados correctamente'
                    ]);
                   
            }else{
                http_response_code(400);
                echo json_encode([
                    'error'=>'ha habido un error'
                ]);
                
            }
        }catch(Exception $e){
            error_log("Error en borrarPedido: " . $e->getMessage());

            // Enviar código de error 500 y una respuesta JSON de error genérico
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno en el servidor'
            ]);
        }
     
    }

    public function eliminarPedido (int $mesa, $id_producto, $cantidad){
        try{
            $pedido = $this->pedidoController->borrarPedido($mesa, $id_producto, $cantidad);
            if($pedido){
                http_response_code(201);
                echo json_encode([
                    'status'=>'exitoso',
                    'message' => 'Productos Eliminados correctamente'
                    ]);
                    
            }else{
                http_response_code(400);
                echo json_encode([
                    'error'=>'ha habido un error'
                ]);
               
            }
        }catch(Exception $e){
            error_log("Error en borrarPedido: " . $e->getMessage());

            // Enviar código de error 500 y una respuesta JSON de error genérico
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno en el servidor'
            ]);
        }
       
    }

    public function verProductos ($mesa){
        $productos = $this->pedidoController->pedidosExistentes($mesa);
        if($productos){
            http_response_code(201);
            echo json_encode([
               "status"=>"exitoso",
               "productos"=>$productos
            ]);
        }else{
            http_response_code(400);
            echo json_encode([
                'error'=>'ha habido un error'
            ]);
        }
    }
}