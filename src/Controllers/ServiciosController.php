<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Servicios;
use Exception;
use InvalidArgumentException;
use App\Helpers\Helper;
Class ServiciosController{


    public function __construct( private Servicios $servicio){
          
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
        $mesa =$this->validarMesa($data); 
        $idServicio = $this->servicio->abrirServicio($mesa);
        if($idServicio){
            Helper::response(201, "id_servicio", "$idServicio");
            return;
        }else{
            Helper::response(400, "error", "no se ha podido abrir la mesa");
        } 
    }

    
       public function cerrarServicioController( $data){
        $mesa = $this->validarMesa($data);
            $servicio = $this->servicio->cerrarMesa($mesa);
                if($servicio){
                    Helper::response(201, 'exitoso', 'mesa cerrada');
                }else{
                    Helper::response(400, 'error', 'No se ha podido cerrar la mesa');
                } 
         }
       
            

        public function verServicio ( int $mesa): void{
            
            $mesaAbierta = $this->servicio->seleccionaUnaMesaAbierta($this->servicio->mesaAbierta($mesa));   
            if($mesaAbierta){
                http_response_code(200);
                echo json_encode([
                    'status' => 'exitoso',
                    'elementos'=>[
                        'id_servicio'=>$mesaAbierta['id_servicio'],
                        'hora_entrada'=>$mesaAbierta['hora_entrada'],
                        'total_gastado'=>$mesaAbierta['total_gastado']
                    ]
                    ]);
            }else{
               Helper::response(400, "error", "No se ha completado la operacion");
            }
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
