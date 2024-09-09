<?php 

declare(strict_types=1);

use App\Controllers\BebidasController;
use App\Controllers\CafeController;
use App\Controllers\PizzaController;

$pizzaController = new PizzaController();
$bebidasController = new BebidasController();
$cafeController = new CafeController();
$routes =[
    '/pizzas'=>function() use($pizzaController){
        $pizzaController->verTodasLasPizzas();
    },

    '/pizzas/{id}'=> function ($id) use($pizzaController){
        $pizzaController->verPizza((int)$id); //el int va dentro del parentesis para asegurar que se pasa a numero
    },

    '/bebidas' => function() use($bebidasController){
        $bebidasController->verTodasLasBebidas();
    },

    '/bebidas/{id}'=> function($id) use($bebidasController){
        $bebidasController->verUnaBebida((int)$id);
    },

    '/cafes' =>function() use($cafeController){
        $cafeController->verTodosLosCafes();
    },

    '/cafes/{id}' => function($id) use($cafeController){
        $cafeController->verUnCafe((int)$id);
    }
];
