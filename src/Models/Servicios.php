<?php
declare(strict_types=1);
namespace App\Models;

use PDO;

Class Servicios extends BaseModel{
    

    public function __construct(){
       parent::__construct();
    }
    
    public function seleccionaUnaMesaAbierta($id_servicio){
        
            $sql = "SELECT * FROM servicios WHERE id_servicio = ? and hora_salida IS NULL";
            $stmt= $this->conn->prepare($sql);
            $stmt->bindParam(1, $id_servicio, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: false;
        } 
    

    public function abrirServicio(int $mesa) {
        
            // Verifica si la mesa ya está abierta
            if (!$this->mesaAbierta($mesa)) {
                 $sql = "INSERT INTO servicios (mesa, hora_entrada, hora_salida, total_gastado) VALUES (?, NOW(), NULL, NULL)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $mesa, PDO::PARAM_INT);
                $stmt->execute();
                //return $this->conn->lastInsertId(); 
                return $this->mesaAbierta($mesa);
               }else{

                  return false;
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
    
    public function checkMesa(int $mesa): bool {
        $sql = "SELECT COUNT(*)FROM servicios WHERE mesa = ? AND hora_salida IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $mesa, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function cerrarMesa(int $mesa): bool {
        
            $idServicio = $this->mesaAbierta($mesa);
            if ($idServicio) {
                $sql = "UPDATE servicios SET hora_salida = NOW() WHERE id_servicio = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $idServicio, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }
            return false;
        
    }

}