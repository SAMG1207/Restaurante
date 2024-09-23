<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use Exception;
use App\Models\Productos;
use App\Models\Servicios;


Class Pedido extends BaseModel{
    public function __construct(private Productos $productos, private Servicios $servicio){
        parent::__construct();
    }

    public function pedidosExistentes($mesa){
      $id_servicio = $this->servicio->mesaAbierta($mesa);
        if(!$id_servicio){
            return false;
        }
        $sql = "SELECT pr.nombre as product, SUM(pe.totalPrecio) as total_producto 
        FROM pedidos pe INNER JOIN productos pr ON pe.id_producto = pr.id_producto
        WHERE pe.id_servicio = ?
        GROUP BY pr.nombre ";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(1, $id_servicio);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC)?:false;
        
    }
  
    public function insertPedido(int $mesa, int $id_producto, int $cantidad = 1){
    
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
            $precioProducto = number_format(floatval($productoExiste["precio"]),2,".","");
            $this->conn->beginTransaction();
            for($i = 0; $i < $cantidad; $i++){
                if(!$this->insertInPedidos($id_servicio, $id_producto, $precioProducto)){
                    $this->conn->rollBack();
                    return false;
                }

             if(!$this->sumPrecio($id_servicio)){
                $this->conn->rollBack();
                    return false;
             }
                
            }
            $this->conn->commit();
            return true;
        }else{
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
                return false;
            } 
            return false;
        }   
    }
     
    private function selectTotalGastado(int $id_servicio){
        $sql = "SELECT SUM(totalPrecio) as totalGastado FROM pedidos WHERE id_servicio = ?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(1, $id_servicio);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['totalGastado']!==null? floatval($result['totalGastado']):0.0;
    }
    private function insertInPedidos($id_servicio, $id_producto, $precio){
        $sql="INSERT INTO pedidos (id_servicio, id_producto, totalPrecio) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$id_servicio, PDO::PARAM_INT);
        $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(3, $precio, PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function borrarPedido (int $mesa, int $id_producto , int $cantidad){
        $productoExiste = $this->productos->selectUnProducto($id_producto);
        $id_servicio = $this->servicio->mesaAbierta($mesa);
        if($productoExiste && $id_servicio){
           $idsAEliminar = $this->selectIdsProductos($id_servicio, $id_producto, $cantidad);
           if($idsAEliminar){
            $this->conn->beginTransaction();
            $idsAEliminarList = implode(',',array_map('intval', $idsAEliminar));
            if(!$this->deleteProduct($idsAEliminarList)){
                $this->conn->rollBack();
                return false;
            }
            if(!$this->sumPrecio( $id_servicio)){
                $this->conn->rollBack();
                return false;
            };
            $this->conn->commit();
            return true;
        }else{
             return false;
            }
        }
        return false;
    }
           
      

    private function selectIdsProductos(int $id_servicio, int $id_producto,int $cantidad){
        $sql = "SELECT id_pedido FROM pedidos WHERE id_servicio = ? AND id_producto = ? LIMIT ".intval($cantidad);
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id_servicio, PDO::PARAM_INT);
        $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        $idsAEliminar = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $idsAEliminar;
    }

    private function sumPrecio( int $id_servicio ){
        $total = $this->selectTotalGastado($id_servicio);
        $sql = "UPDATE servicios SET total_gastado = ? WHERE id_servicio = ?";
        $stmtSql = $this->conn->prepare($sql);
        $stmtSql->bindParam(1, $total);
        $stmtSql->bindParam(2, $id_servicio);
        return $stmtSql->execute();
        
    }

    private function deleteProduct($list){
        $query = "DELETE FROM pedidos WHERE id_pedido IN ($list)";
        $stmtN = $this->conn->prepare($query);
        return $stmtN->execute();
    }
}

