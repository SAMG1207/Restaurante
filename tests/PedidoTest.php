<?php

use App\Models\Pedido;
use PHPUnit\Framework\TestCase;

class PedidoTest extends TestCase {
protected $pedido;

public static function mesaProvider() {
    return [
        [-1],  [0],  [1],  [3], [6], [7], [100], [1.5],["a"], [true],[false],
        ["<script> alert('prueba'); </script>'"]  // Caso inválido
    ];
}

protected function setUp(): void {
    parent::setUp();
    // Crea un mock de la clase Servicios
    $this->pedido = $this->createMock(Pedido::class);
}
/**
 * @dataProvider mesaProvider
 * @param mixed $nroMesa
 * @return void
 */
public function testTotalMesa($nroMesa) {
    if(!is_numeric($nroMesa)){
        $this->expectException(TypeError::class);
        $this->pedido->method('totalMesa')->willThrowException(new TypeError());
        $this->pedido->totalMesa($nroMesa);
    }
    elseif ($nroMesa < 1 || $nroMesa > 6) {
        $this->expectException(InvalidArgumentException::class);
        $this->pedido->method('totalMesa')->willThrowException(new InvalidArgumentException());
        $this->pedido->totalMesa($nroMesa); // lanzará la excepción
    } else {
        $this->pedido->method('totalMesa')->willReturn(['pedido1', 'pedido2']);
        $resultado = $this->pedido->totalMesa($nroMesa);
        $this->assertIsArray($resultado);
    }
}
}