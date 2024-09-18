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
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: false;
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
    

    public function cerrarMesa(int $mesa): bool {
        try {
            $idServicio = $this->mesaAbierta($mesa);
            if ($idServicio) {
                $this->conn->beginTransaction();

                // Actualizar la hora de salida
                $sql = "UPDATE servicios SET hora_salida = NOW() WHERE id_servicio = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(1, $idServicio, PDO::PARAM_INT);
                $stmt->execute();
                $this->conn->commit();
                return true;
            }
            return false;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            error_log("Error al cerrar mesa: " . $e->getMessage());
            return false;
        }
    }
    /**
     * FALTA HACER LA FUNCION PARA QUE CADA VEZ QUE SE HAGA UN PEDIDO EL PRECIO DE ESTE SE SUME A LA CUENTA
     * SE PUEDE HACER COMO PROCEDIMIENTO SQL
     * DELIMITER //
        CREATE TRIGGER after_insert_pedido
         AFTER INSERT ON pedidos
       FOR EACH ROW
         BEGIN
    -- Declara una variable para almacenar el total actual
    DECLARE totalAcumulado DECIMAL(10,2);

    -- Obtén el total acumulado de la mesa
    SELECT SUM(totalPrecio) INTO totalAcumulado
    FROM pedidos
    WHERE id_servicio = NEW.id_servicio;

    -- Actualiza la columna total_gastado en la tabla servicios
    UPDATE servicios
    SET total_gastado = totalAcumulado
    WHERE id_servicio = NEW.id_servicio;
END;
//
DELIMITER ;
     * 
     * 
     * 
     * TAMBIEN PARA CUANDO SE ELIMINAN PEDIDOS 
     * BEGIN
    UPDATE servicios
    SET total_gastado = total_gastado - OLD.totalPrecio
    WHERE id_servicio = OLD.id_servicio;
END
     */
}