<?php 

namespace App\Models;
use PDO;
use App\Config\Database;

abstract class BaseModel{
    protected PDO $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
}