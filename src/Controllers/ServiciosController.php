<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Servicios;
use Exception;

Class ServiciosController{
    private Servicios $serviciosController ;

    public function __construct(){
          $this->serviciosController = new Servicios();
    }

    public function abrirServicioController($data){
        try{
            header('Content-Type: application/json');
            if(isset($data['mesa']) && filter_var($data['mesa'], FILTER_VALIDATE_INT)){
                $mesa = $data['mesa'];
                $idServicio = $this->serviciosController->abrirServicio($mesa);
                if($idServicio){
                    http_response_code(201);
                    echo json_encode([
                        'status'=>'exitoso',
                        'message' => 'Mesa abierta correctamente',
                        'id_servicio' => $idServicio
                        ]);
                }else{
                    http_response_code(400);
                    echo json_encode([
                        'error'=>'mesa ya estaba abierta'
                    ]);
                }
            }
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode([
        'status' => 'error',
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
        }
    }

      
    public function cerrarServicioController($data){
        try{
            header('Content-Type: application/json');
            if(isset($data['mesa']) && filter_var($data['mesa'], FILTER_VALIDATE_INT)){
                $mesa = $data['mesa'];
                $servicio = $this->serviciosController->cerrarMesa($mesa);
                if($servicio){
                    http_response_code(201);
                    echo json_encode([
                        'status'=>'exitoso',
                        'message' => 'Mesa abierta correctamente'
                        ]);
                }else{
                    http_response_code(400);
                    echo json_encode([
                        'error'=>'mesa no abierta'
                    ]);
                }
            }
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode([
        'status' => 'error',
        'message' => 'Error en el servidor: ' . $e->getMessage()]);
        }
    }
            
     

        public function verServicio ( int $mesa): void{
            $mesaAbierta = $this->serviciosController->seleccionaUnaMesaAbierta($this->serviciosController->mesaAbierta($mesa));   
            if($mesaAbierta){
                http_response_code(201);
                echo json_encode([
                    'status' => 'exitoso',
                    'elementos'=>[
                        'id_servicio'=>$mesaAbierta['id_servicio'],
                        'hora_entrada'=>$mesaAbierta['hora_abierta'],
                        'total_gastado'=>$mesaAbierta['total_gastado']
                    ]
                    ]);
            }else{
                http_response_code(400);
                echo json_encode([
                    'error'=>'mesa no se ha podido cerrar'
                ]);
            }
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
