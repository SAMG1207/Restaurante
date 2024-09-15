<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Servicios;
use Exception;

Class ServiciosController{
    private Servicios $serviciosContronller ;

    public function __construct(){
          $this->serviciosContronller = new Servicios();
    }

    public function abrirServicioController($mesa){
// ASIGNAMOS A PHP
              $idServicio = $this->serviciosContronller->abrirServicio($mesa);
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    }
