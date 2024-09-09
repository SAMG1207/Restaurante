<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Pizza;
use Exception;

class PizzaController{
    private Pizza $pizzaModel;

    public function __construct(){
        $this->pizzaModel = new Pizza();
    }

    public function verTodasLasPizzas(){
        try {
            $infoPizza = $this->pizzaModel->selectPizza();
            header('Content-Type: application/json');
            if (empty($infoPizza)) {
                http_response_code(404); // No encontrado
                echo json_encode(['error' => 'Pizza no encontrada']);
                return;
            }
            http_response_code(200); // Éxito
            echo json_encode($infoPizza);
        } catch (Exception $e) {
            http_response_code(500); // Error del servidor
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function verPizza(int $id_pizza): void {
        try {
            $infoPizza = $this->pizzaModel->selectUnaPizza($id_pizza);
            header('Content-Type: application/json');
            if (empty($infoPizza)) {
                http_response_code(404); // No encontrado
                echo json_encode(['error' => 'Pizza no encontrada']);
                return;
            }
            http_response_code(200); // Éxito
            echo json_encode($infoPizza);
        } catch (Exception $e) {
            http_response_code(500); // Error del servidor
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}

