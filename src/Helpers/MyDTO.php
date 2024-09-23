<?php
declare(strict_types=1);
namespace App\Helpers;

Class MyDTO{
    public function __construct(
        public readonly int $mesa,
        public readonly int $id_producto,
        public readonly int $cantidad
    ) {  
    }

}