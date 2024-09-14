<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use Exception;

//require_once __DIR__. '/../config/database.php';

Class Productos extends BaseModel{


public function __construct(){
  parent::__construct();
}

public function selectProductos(): array{
    $query = "SELECT * FROM productos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
}

public function selectUnProducto(int $id_producto): mixed{
    try{
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_producto, );
        $stmt->execute();
        $result =  $stmt->fetch(PDO::FETCH_ASSOC);
        return $result? :false;
    }catch(Exception $e){
        return (["Error"=>$e->getMessage()]);
    }
     
}

public function selectPorTipo (string $tipo){
    $query = "SELECT * FROM productos WHERE tipo = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $tipo);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

}