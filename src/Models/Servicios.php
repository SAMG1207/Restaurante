<?php
declare(strict_types=1);
namespace App\Models;

use Exception;
use PDO;
use PDOException;

Class Servicios extends BaseModel{
    

    public function __construct(){
       parent::__construct();
    }
    
    public function seleccionaUnaMesaAbierta($id_servicio){
        try{
            $sql = "SELECT * FROM servicios WHERE id_servicio = ? and hora_salida IS NULL";
            $stmt= $this->conn->prepare($sql);
            $stmt->bindParam(1, $id_servicio, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result !== false;
        }catch(PDOException $e){
            echo ($e->getMessage());
            return false;
        }
        
    }

    public function abrirServicio(int $mesa) {
        try {
            // Verifica si la mesa ya está abierta
            if (!$this->mesaAbierta($mesa)) {
                // Inicia una transacción
                $this->conn->beginTransaction();
    
                // Insertar el nuevo servicio
                $sql = "INSERT INTO servicios (mesa, hora_entrada, hora_salida, total_gastado) VALUES (?, NOW(), NULL, NULL)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $mesa, PDO::PARAM_INT);
                $stmt->execute();
                $this->conn->commit();
                //return $this->conn->lastInsertId(); 
                return $this->mesaAbierta($mesa);
               }else{
  // Si la mesa ya está abierta, devolver falso o algún indicativo
                  return false;
            }

        } catch (Exception $e) {
            // En caso de un error, revertir la transacción y devolver el mensaje de error
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw new Exception("Error al abrir servicio: " . $e->getMessage());
        }
    }
    

    public function mesaAbierta(int $mesa): mixed {
        $sql = "SELECT id_servicio FROM servicios WHERE mesa = ? AND hora_salida IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $mesa, PDO::PARAM_INT);
        $stmt->execute();
        // Devuelve true si se encuentra al menos una fila, de lo contrario false
        return $stmt->fetchColumn();// !== false;
    }
    
    private function obtenIdMesaAbierta(int $mesa):bool{
        if ($this->mesaAbierta($mesa)) {
            // Obtén el id_servicio de la mesa abierta
            $sql = "SELECT id_servicio FROM servicios WHERE mesa = ? AND hora_salida IS NULL";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $mesa, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            error_log("Mesa $mesa estado: " . ($result ? "Abierta" : "Cerrada"));
            return $result !== false;
        }
        return 0;
    }
    public function cerrarMesa(int $mesa): bool {
         try{
            $idServicio = $this->obtenIdMesaAbierta($mesa);
            if ($idServicio) {
                $this->conn->beginTransaction();
                // Actualiza la hora de salida en la tabla servicios
                $updateSql = "UPDATE servicios SET hora_salida = NOW() WHERE id_servicio = ?";
                $updateStmt = $this->conn->prepare($updateSql);
                $updateStmt->bindParam(1, $idServicio, PDO::PARAM_INT);
                $updateStmt->execute();
                $this->conn->commit();
                return true;
            }   
                
                return false;
         }catch(Exception $e){
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
            }
           
                return false;
         }
        
    }
    /**
     * FALTA HACER LA FUNCION PARA QUE CADA VEZ QUE SE HAGA UN PEDIDO EL PRECIO DE ESTE SE SUME A LA CUENTA
     * SE PUEDE HACER COMO PROCEDIMIENTO SQL
     */
}