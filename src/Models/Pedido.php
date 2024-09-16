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
  
    public function insertPedido(int $mesa, int $id_producto, int $cantidad = 1){
    try{
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
             $precioProducto = $productoExiste["precio"] * $cantidad;
            $this->conn->beginTransaction();
            $sql="INSERT INTO pedidos (id_servicio, id_producto, cantidad, totalPrecio) VALUES (?,?,?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1,$id_servicio, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
            $stmt->bindParam(3, $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(4, $precioProducto, PDO::PARAM_INT);
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

    public function borrarPedido (int $mesa, int $id_producto){
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
            $sql ="SELECT cantidad FROM pedidos WHERE id_producto = $id_producto AND id_servicio = $id_servicio";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result > 1){
                $sql = "UPDATE pedidos SET cantidad = ? WHERE id_servicio = $id_servicio AND id_producto = $id_producto";
                //CONTINUAR
            }
        }
    }
}

