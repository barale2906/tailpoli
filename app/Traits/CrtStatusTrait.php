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

    public $tipoContrato=[
        'Indefinido',
        'inferior a un año',
        'Prestación de servicios',
        'obra labor'
    ];

    public $soportesFuncionario=[
        'Contrato',
        'Otrosí',
        'Carta finaliza',
        'Carta Dotación',
        'Exámenes Médicos',
        'Documento identidad'
    ];

    public $familiares=[
        'Mamá',
        'Papá',
        'Hermano(a)',
        'Hijo(a)',
        'Conyuge'
    ];

    public $estados=[
        'Inactivo',
        'Activo'
    ];

    public $documentosFuncionarios=[
        'Hoja de Vida',
        'Documento',
        'Contrato',
        'Otrosí',
        'Comprobante de pago',
        'Planilla Afiliación',
        'Cartas (Vacaciones, Memorandos, Llamados de atención)',
        'Otro'
    ];
}
