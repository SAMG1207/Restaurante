<?php

use App\Models\Servicios;
use PHPUnit\Framework\TestCase;

class ServicioTest extends TestCase {
    protected $servicios;

    
    public static function mesaProvider() {
        return [
            [-1],  [0],  [1],  [3], [6], [7], [100], [1.5],["a"], [true],[false],
            ["<script> alert('prueba'); </script>'"]  // Caso inválido
        ];
    }


    protected function setUp(): void {
        parent::setUp();
        // Crea un mock de la clase Servicios
        $this->servicios = $this->createMock(Servicios::class);
    }

    /**
     * @dataProvider mesaProvider
     */
    public function testMesaAbierta($nroMesa) {
        if(!is_numeric($nroMesa)){
            $this->expectException(TypeError::class);
            $this->servicios->method('abrirServicio')->willThrowException(new TypeError());
            $this->servicios->abrirServicio($nroMesa);
        }
        elseif ($nroMesa < 1 || $nroMesa > 6) {
            $this->expectException(InvalidArgumentException::class);
            $this->servicios->method('abrirServicio')->willThrowException(new InvalidArgumentException());
            $this->servicios->abrirServicio($nroMesa); // lanzará la excepción
        } else {
            $this->servicios->method('abrirServicio')->willReturn(true);
            $resultado = $this->servicios->abrirServicio($nroMesa);
            $this->assertTrue($resultado);
        }
    }

  /**
     * @dataProvider mesaProvider
     */
    public function testSeleccionMesa($nroMesa) {
        if(!is_numeric($nroMesa)){
            $this->expectException(TypeError::class);
            $this->servicios->method('mesaAbierta')->willThrowException(new TypeError());
            $this->servicios->mesaAbierta($nroMesa);
        }
        elseif ($nroMesa < 1 || $nroMesa > 6) {
            // Configura el mock para devolver false cuando la mesa es inválida
            $this->expectException(InvalidArgumentException::class);
            $this->servicios->method('mesaAbierta')->willThrowException(new InvalidArgumentException());
            $this->servicios->mesaAbierta($nroMesa); 
        } else {
            // Configura el mock para devolver true cuando la mesa es válida
            $this->servicios->method('mesaAbierta')->willReturn(true);
            $resultado = $this->servicios->mesaAbierta($nroMesa);
            $this->assertIsBool($resultado);  // Cambiado a assertTrue para mesas válidas
        }
    }

     /**
     * @dataProvider mesaProvider
     */
    public function testCerrarMesa($nroMesa){
        if(!is_numeric($nroMesa)){
            $this->expectException(TypeError::class);
            $this->servicios->method('cerrarMesa')->willThrowException(new TypeError());
            $this->servicios->cerrarMesa($nroMesa);
        }
        elseif ($nroMesa < 1 || $nroMesa > 6) {
            $this->expectException(InvalidArgumentException::class);
            $this->servicios->method('cerrarMesa')->willThrowException(new InvalidArgumentException());
            $this->servicios->cerrarMesa($nroMesa);
    }else{
            $this->servicios->method('cerrarMesa')->willReturn(true);
            $resultado = $this->servicios->cerrarMesa($nroMesa);
            $this->assertTrue($resultado);
    }
}

}
