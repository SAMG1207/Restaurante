<?php
use App\Models\Productos;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ .'/../src/Models/Productos.php';
 
$producto = new Productos();

print_r( count($producto->selectUnProducto(1)));