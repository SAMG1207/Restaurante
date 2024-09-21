<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Servicios;
use Exception;
use InvalidArgumentException;

Class ServiciosController{
    private Servicios $serviciosController ;

    public function __construct(){
          $this->serviciosController = new Servicios();
    }
   

    private function validarMesa($data) {
        if (!isset($data['mesa']) || !filter_var($data['mesa'], FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException("Mesa no es un número.");
        }
        $mesa = $data['mesa'];
        if ($mesa < 1 || $mesa > 6) {
            throw new InvalidArgumentException("La mesa debe ir entre 1 y 6.");
        }
        return $mesa;
    }
    public function abrirServicioController($data){
        try{
            header('Content-Type: application/json');
                $mesa =$this->validarMesa($data); 
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
            }catch(InvalidArgumentException $e){
            error_log("Invalid Argument Exception: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                 'status' => 'error',
                'message' => $e->getMessage() ]);
            } catch(Exception $e){
                error_log("Invalid Argument Exception: " . $e->getMessage());
                http_response_code(500);
              echo json_encode([
             'status' => 'error',
              'message' => 'Error en el servidor: ' . $e->getMessage()]);
            } 
    }

       

       public function cerrarServicioController( $data){
          try{
            header('Content-Type: application/json');
            $mesa = $this->validarMesa($data);
            $servicio = $this->serviciosController->cerrarMesa($mesa);
                if($servicio){
                    http_response_code(201);
                    echo json_encode([
                        'status'=>'exitoso',
                        'message' => 'Mesa Cerrada correctamente'
                        ]);
                }else{
                    http_response_code(400);
                    echo json_encode([
                        'error'=>'mesa no abierta'
                    ]);
                }
          }catch(InvalidArgumentException $e){
            http_response_code(400);
            echo json_encode([
                 'status' => 'error',
                'message' => $e->getMessage() ]);
            } catch(Exception $e){
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

    
    
    
    
    
    
    
    
    
    
    
    
    
    
