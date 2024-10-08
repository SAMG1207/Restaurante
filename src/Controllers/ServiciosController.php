<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Servicios;
use InvalidArgumentException;
use App\Helpers\Responser;
Class ServiciosController{


    public function __construct( private Servicios $servicio){}
   

    private function validarMesa($data):int {
        if (!isset($data['mesa']) || !filter_var($data['mesa'], FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException("Mesa no es un número.");
        }
        $mesa = $data['mesa'];
        if ($mesa < 1 || $mesa > 6) {
            throw new InvalidArgumentException("La mesa debe ir entre 1 y 6.");
        }
        return $mesa;
    }
    public function abrirServicioController($data):void{
        $mesa =$this->validarMesa($data); 
        $idServicio = $this->servicio->abrirServicio($mesa);
        if($idServicio){
         $this->verServicio($mesa);
        }else{
            Responser::response(400,  "Esta mesa ya está abierta");
        } 
    }

    
       public function cerrarServicioController( $data):void{
        $mesa = $this->validarMesa($data);
            $servicio = $this->servicio->cerrarMesa($mesa);
                if($servicio){
                    $this->verServicio($mesa);
                }else{
                    Responser::response(400,  'No se ha podido cerrar la mesa');
                } 
         }
       
            

        public function verServicio (int $mesa): void{
            
            $mesaAbierta = $this->servicio->seleccionaUnaMesaAbierta($this->servicio->mesaAbierta($mesa));  
            if($mesa >0 && $mesa  < 7) {
                if($mesaAbierta){
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'open',
                        'mesa'=>$mesa,
                        'elementos'=>[
                            'id_servicio'=>$mesaAbierta['id_servicio'],
                            'hora_entrada'=>$mesaAbierta['hora_entrada'],
                            'total_gastado'=>$mesaAbierta['total_gastado']
                        ]
                        ]);
                }else{
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'closed',
                         'mesa'=>$mesa,
                        ]);
                }
            }
            else{
               Responser::response(400, "No se ha completado la operacion");
            }
        }

     
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
