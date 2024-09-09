<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use App\Config\Database;

require_once __DIR__. '/../config/database.php';

class Cafes{

        private PDO $conn;
        private Database $database;
    
    public function __construct(){
        $this->database = new Database;
        $this->conn = $this->database->getConnection();
    }

    public function selectCafe():array{
        $query = "SELECT * FROM cafes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }

    public function selectUnCafe(int $id_cafe):array{
        
        $query ="SELECT * FROM cafes WHERE ID_CAFE = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_cafe);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }
}