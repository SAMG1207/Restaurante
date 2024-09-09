<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Cafes;
use Exception;

Class CafeController{

    private Cafes  $cafeController;

    public function __construct(){
    $this->cafeController = new Cafes();
    }

    public function verTodosLosCafes(): void{
        try{
            $infoCafes = $this->cafeController->selectCafe();
            header('Content-Type: application/json');
            if(empty($infoCafes)){
                http_response_code(404); //No encontrado
                echo json_encode(["error"=>"Error, No aparecen los Cafes:"]);
                return;
            }
            http_response_code(200); //No encontrado
            echo json_encode($infoCafes);
        }catch(Exception $e){
            http_response_code(500); //No encontrado
            header('Content-Type: application/json');
            echo json_encode(["error"=>"Error, No aparecen los Cafes:"]);
        }
       
    }

    public function verUnCafe(int $id_cafe):void{
        try{
            $infoCafes = $this->cafeController->selectUnCafe($id_cafe);
            header('Content-Type: application/json');
            if(empty($infoCafes)){
                http_response_code(404); //No encontrado
                echo json_encode(["error"=>"No existe este id: ".$id_cafe]);
                return;
            }
            http_response_code(200); //No encontrado
            echo json_encode($infoCafes);
        }catch(Exception $e){
            http_response_code(500); //No encontrado
            header('Content-Type: application/json');
            echo json_encode(["error"=>"Error, No aparece el cafe: ". $id_cafe]);
        }
          
    }
}