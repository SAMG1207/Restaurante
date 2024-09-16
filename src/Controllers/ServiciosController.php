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

    public function abrirServicioController($mesa){
// ASIGNAMOS A PHP
              $idServicio = $this->serviciosController->abrirServicio($mesa);
            if($idServicio){
                echo json_encode([
                'status'=>'exitoso',
                'message' => 'Mesa abierta correctamente',
                'id_servicio' => $idServicio
                ]);
                http_response_code(201); //Recurso creado
                
            }else{
                echo json_encode([
                    'error'=>'mesa ya estaba abierta'
                ]);
                http_response_code(400);
            }
      
        }
    public function cerrarServicioController($mesa){
            $mesaCerrada = $this->serviciosController->cerrarMesa($mesa);
            if($mesaCerrada){
                echo json_encode([
                    'status'=>'exitoso',
                    'message'=>'mesa cerrada correctamente',
                    'cerrada'=>$mesaCerrada
                ]);
                http_response_code(201);
            }else{
                echo json_encode([
                    'error'=>'mesa no se ha podido cerrar'
                ]);
                http_response_code(400);
            }
        }
     
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
