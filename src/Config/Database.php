<?php

namespace App\Config;
use PDO;
use PDOException;
Class Database{
    private $host ="localhost";
    private $dbName ="pizzeria";
    private $username="root";
    private $password = "";
    public $conn = null;

    public function getConnection(): ?PDO{
        $this->conn = null;

        try{
           $this->conn = new PDO("mysql:host=".$this->host. ";dbname=".$this->dbName, $this->username, $this->password);
           $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Modo de error
           $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
           $this->conn->exec("set names utf8");
        }catch(PDOException $e){
            echo "Error de conexión: ".$e->getMessage();
        }
        return $this->conn;
    }

    public function closeConnection(){
         $this->conn=null;
    }
}