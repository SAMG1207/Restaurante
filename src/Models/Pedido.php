<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use Exception;
use App\Models\Productos;
use App\Models\Servicios;


Class Pedido extends BaseModel{
    private Productos $productos;
    private Servicios $servicio;

    public function __construct(){
        parent::__construct();
        $this->productos = new Productos();
        $this->servicio = new Servicios();
    }

    private function pedidosExistentes($id_servicio){
      
        if(is_int($id_servicio) && $this->servicio->seleccionaUnaMesaAbierta($id_servicio) ){
            $sql = "SELECT * FROM servicios WHERE id_servicio = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bindParam(1, $id_servicio);
            $stmt->execute();
            return $stmt->fetch()?:false;

        }else{
            return false;
        }
    }
  
    public function insertPedido(int $id_servicio, int $id_producto, int $cantidad){
    try{
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $servicioExiste = $this->servicio->seleccionaUnaMesaAbierta($id_servicio);
        if($productoExiste && $servicioExiste){
            $this->conn->beginTransaction();
            $sql="INSERT INTO pedidos (id_servicio, id_producto, cantidad) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$id_servicio, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(3, $cantidad, PDO::PARAM_INT);
            $stmt->execute();
            $this->conn->commit();
            return true;
        }else{
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
                return false;
            }
           
        }
       
    }catch(Exception $e){
        if($this->conn->inTransaction()){
            $this->conn->rollBack();
        }
        throw new Exception("Error al insertar pedido: " . $e->getMessage());
       
    }   
    }

    public function borrarPedido ($id_pedido){
        
    }
}

