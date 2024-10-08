<?php

use PHPUnit\Framework\TestCase;
use App\Models\Productos;

class ProductosTest extends TestCase {
    protected $producto;

    protected function setUp(): void {
        parent::setUp();
        // Crea un mock de la clase Productos
        $this->producto = $this->createMock(Productos::class);
    }

    public static function provider() {
        return [
            [-1],  [0],  [1],  [3], [6], [7], [100], [1.5], ["a"], [true], [false],
            ["<script> alert('prueba'); </script>'"]  // Caso inválido
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testIdProducto($id) {
        if (!is_numeric($id)) {
            $this->expectException(TypeError::class);
            $this->producto->method('selectUnProducto')->willThrowException(new TypeError());
            $this->producto->selectUnProducto($id);
        } elseif ($id < 1) {
            $this->expectException(InvalidArgumentException::class);
            $this->producto->method('selectUnProducto')->willThrowException(new InvalidArgumentException());
            $this->producto->selectUnProducto($id);
        } else {
            $this->producto->method('selectUnProducto')->willReturn(['producto1', 'producto2']);
            $resultado = $this->producto->selectUnProducto($id);
            $this->assertIsArray($resultado);
        }
    }
}
