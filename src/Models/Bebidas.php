<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use App\Config\Database;
require_once __DIR__. '/../config/database.php';

class Bebidas{

        private PDO $conn;
        private Database $database;
    
    public function __construct(){
        $this->database = new Database;
        $this->conn = $this->database->getConnection();
    }

    public function selectBebida():array{
        $query = "SELECT * FROM bebidas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }

    public function selectUnaBebida(int $id_bebida):array{
        
        $query ="SELECT * FROM bebidas WHERE ID_BEBIDA = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_bebida);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }
}