<?php

return[

    'nombre_empresa'        =>env('NOMBRE_EMPRESA'),
    'direccion'             =>env('DIRECCION'),
    'nit'                   =>env('NIT'),
    'telefono'              =>env('TELEFONO'),
    'resolucion_fact'       =>env('RESOLUCION_FACT'),
    'representante_legal'   =>env('REPRESENTANTE_LEGAL'),
    'documento_rl'          =>env('DOCUMENTO_RL'),
    'telefono_rol'          =>env('TELEFONO_RL'),
    'directora'             =>env('DIRECTORA', 'STEPHANY IZQUIERDO OCAMPO'),
    'desertado_fin'         =>env('DESERTADO_FIN_SEMANA'),
    'desertado_entresemana' =>env('DESERTADO_ENTRESEMANA'),
    'max_registros'         =>env('MAX_REGISTROS'),
    'dias_cobranza'         =>env('DIAS_COBRANZA',30),
    'dias_reporte'          =>env('DIAS_REPORTE',35),
    'copia_carnet'          =>env('COPIA_CARNET','publiandino@gmail.com'),
];
