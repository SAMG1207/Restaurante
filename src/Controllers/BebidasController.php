<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Bebidas;
use Exception;

Class BebidasController{

    private Bebidas  $bebidasController ;

    public function __construct(){
    $this->bebidasController  = new Bebidas();
    }

    public function verTodasLasBebidas(): void{
        try{
            $infoBebidas = $this->bebidasController ->selectBebida();
            header('Content-Type: application/json');
            if(empty($infoBebidas)){
                http_response_code(404); //No encontrado
                echo json_encode(["error"=>"Error, No aparecen los Cafes: 1"]);
                return;
            }
            echo json_encode($infoBebidas);
        }catch(Exception $e){
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(["error"=>"Error, No aparecen los Cafes:"]);
        }
     
    }

    public function verUnaBebida(int $id_bebida): void{
        try{
            $infoBebidas = $this->bebidasController ->selectUnaBebida($id_bebida);
            header('Content-Type: application/json');
            if(empty($infoBebidas)){
                echo json_encode(["error"=>"Error, No aparece la bebida id: ". $id_bebida]);
            }
            echo json_encode($infoBebidas);
        }catch(Exception $e){
            header('Content-Type: application/json');
            echo json_encode(["error"=>"Error, No aparecen las bebidas"]);
        }
     
    }
}