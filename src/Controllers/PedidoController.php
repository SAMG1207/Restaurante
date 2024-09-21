<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pedido;
use CachingIterator;
use Exception;
use InvalidArgumentException;


class PedidoController{
    private Pedido $pedidoController;

    public function __construct(){
        $this->pedidoController = new Pedido();
    }
    
 
    public function hacerPedido($data){
        try{
            header('Content-Type: application/json');
            if (isset($data['mesa'], $data['id_producto'], $data['cantidad']) &&
                filter_var($data['mesa'], FILTER_VALIDATE_INT) !== false &&
                filter_var($data['id_producto'], FILTER_VALIDATE_INT) !== false &&
                filter_var($data['cantidad'], FILTER_VALIDATE_INT) !== false
            ){
                $mesa = (int)$data['mesa'];
                $id_producto = (int)$data['id_producto'];
                $cantidad = (int)$data['cantidad'];
                $pedido = $this->pedidoController->insertPedido($mesa, $id_producto, $cantidad);
                if($pedido){
                    http_response_code(201); //ES POST
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
            }else{
                throw new InvalidArgumentException("Argumentos equivocados");
            }
            
        }catch(Exception $e){
            error_log("Error en borrarPedido: " . $e->getMessage());

            // Enviar código de error 500 y una respuesta JSON de error genérico
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno en el servidor'
            ]);
        }catch(InvalidArgumentException $e){
            http_response_code(400);
            echo json_encode([
                'error'=>'ha habido un error en los argumentos'
            ]);
        }
     
    }
    public function elminarPedido($data){
        
            try{
                header('Content-Type: application/json');
                if (isset($data['mesa'], $data['id_producto'], $data['cantidad']) &&
                filter_var($data['mesa'], FILTER_VALIDATE_INT) !== false &&
                filter_var($data['id_producto'], FILTER_VALIDATE_INT) !== false &&
                filter_var($data['cantidad'], FILTER_VALIDATE_INT) !== false
                ){
                    $mesa = (int)$data['mesa'];
                    $id_producto = (int)$data['id_producto'];
                    $cantidad = (int)$data['cantidad']; 

                    $pedido  = $this->pedidoController->borrarPedido($mesa, $id_producto, $cantidad);
                    if($pedido){
                        http_response_code(200);
                        echo json_encode([
                            'status' => 'exitoso',
                            'message' => 'Pedido eliminado correctamente'
                        ]);
                    }else{
                        http_response_code(400);
                        echo json_encode([
                            'error'=>'ha habido un error'
                        ]);}
                }else{
                    throw new InvalidArgumentException("Argumentos equivocados");
                }

            }catch(Exception $e){
                http_response_code(500);
                echo json_encode([
            'status' => 'error',
            'message' => 'Error en el servidor: ' . $e->getMessage() ]);
            }catch(InvalidArgumentException $e){
                http_response_code(400);
                echo json_encode([
                    'error'=>'ha habido un error en los argumentos'
                ]);
            }
        }
        

    public function verProductos (int $mesa){
        header('Content-Type: application/json');
        if(filter_var($mesa, FILTER_VALIDATE_INT)){
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
        }else{
            http_response_code(400);
            echo json_encode([
                'error'=>'ha habido un error'
            ]);
        }
       
    }
}