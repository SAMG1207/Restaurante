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

    public function pedidosExistentes($mesa){
      $id_servicio = $this->servicio->mesaAbierta($mesa);
        if(is_int($id_servicio) ){
            $sql = "SELECT pr.nombre as product, SUM(pe.totalPrecio) as total_producto 
            FROM pedidos pe INNER JOIN productos pr ON pe.id_producto = pr.id_producto
            WHERE pe.id_servicio = ?
            GROUP BY pr.nombre ";
            $stmt= $this->conn->prepare($sql);
            $stmt->bindParam(1, $id_servicio);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC)?:false;

        }else{
            return false;
        }
    }
  
    public function insertPedido(int $mesa, int $id_producto, int $cantidad = 1){
    try{
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
            $precioProducto = number_format(floatval($productoExiste["precio"]),2,".","");
            for($i = 0; $i < $cantidad; $i++){
                $this->conn->beginTransaction();
                $sql="INSERT INTO pedidos (id_servicio, id_producto, totalPrecio) VALUES (?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1,$id_servicio, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
                $stmt->bindParam(3, $precioProducto, PDO::PARAM_STR);
                $stmt->execute();
                $this->conn->commit();
            }
       
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

    public function borrarPedido (int $mesa, int $id_producto , int $cantidad){
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
           $sql = "SELECT id_pedido FROM pedidos WHERE id_servicio = ? AND id_producto = ? LIMIT ".intval($cantidad);
           $stmt = $this->conn->prepare($sql);
           $stmt->bindParam(1, $id_servicio, PDO::PARAM_INT);
           $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
           $stmt->execute();
           $idsAEliminar = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
           if($idsAEliminar){
            $idsAEliminarList = implode(',',array_map('intval', $idsAEliminar));
            try{
                $this->conn->beginTransaction();
                $query = "DELETE FROM pedidos WHERE id_pedido IN ($idsAEliminarList)";
                $stmtN = $this->conn->prepare($query);
                $stmtN->execute();
                $this->conn->commit();
                return true;
            }catch(Exception){
                if($this->conn->inTransaction()){
                    $this->conn->rollBack();
                    return false;
                }
            }
            
            
           }
           return false;
        }
        return false;
    }
}

