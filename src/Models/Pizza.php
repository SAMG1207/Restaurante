<?php
declare(strict_types=1);
namespace App\Models;
use PDO;
use App\Config\Database;
require_once __DIR__. '/../config/database.php';

class Pizza{

        private PDO $conn;
        private Database $database;
    
    public function __construct(){
        $this->database = new Database;
        $this->conn = $this->database->getConnection();
    }

    public function selectPizza():array{
        $query = "SELECT * FROM pizzas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }

    public function selectUnaPizza(int $id_pizza):array{
        
        $query ="SELECT * FROM pizzas WHERE ID_PIZZA = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_pizza);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->closeConnection();
        return $result;
    }
}