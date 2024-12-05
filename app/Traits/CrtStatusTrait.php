<?php

namespace App\Traits;

trait CrtStatusTrait
{
    public $statusInventipo=[
        'Sálida',
        'Entrada',
        'Pendiente',
        'Traslado',
        'Baja por: Daño por almacenamiento',
        'Baja por: Elaboración defectuosa',
        'Baja por: Devolución al proveedor',
        'Baja por: Autorización de Gerencia',
        'Baja por: Producto no solicitado'
    ];
}
