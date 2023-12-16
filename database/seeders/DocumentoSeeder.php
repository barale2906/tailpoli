<?php

namespace Database\Seeders;

use App\Models\Configuracion\Documento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contrato=Documento::create([
                                'fecha'     =>now(),
                                'tipo'      =>"contrato",
                                'titulo'    =>"Contrato",
                                'status'    =>3,
                                'creador_id'=>1,
                            ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'Entre los suscritos, nombreInsti identificado
                                                        con NIT. nitInsti, representado legalmente por el señor rlInsti, y
                                                        nombreEstu, persona mayor de edad e identificada con tipodocuEstu No. documentoEstu,
                                                        domiciliada en esta ciudad, obrando en nombre propio y en calidad de ESTUDIANTE, PADRE,
                                                        ACUDIENTE DEL ESTUDIANTE, nombreEstu, por medio del presente
                                                        documento hemos decidido celebrar el presente Contrato de Prestación de Servicios Educativos, el cual se
                                                        regirá por las siguientes clausulas y/o normas',
                                    'orden'         => 1,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => ' CLAUSULA PRIMERA- OBJETO DEL CONTRATO: Prestación del Servicio Educativo de
                                                        Capacitación y Formación en el Programa TéCNICO EN SOLDADURA a cargo del INSTITUTO DE
                                                        CAPACITACIÓN POLIANDINO CENTRAL S.A.S., y de acuerdo a los parámetros establecidos en la
                                                        oferta educativa, según fechas, horarios, duración, con profesionales y/o instructores aptos para asegurar la
                                                        calidad del programa de preparación y demás deberes establecidos en el reglamento estudiantil del Instituto,
                                                        formando al estudiante con las metodologías necesarias para recibir de forma idónea el conocimiento teóricopráctico en el curso TéCNICO EN SOLDADURA.',
                                    'orden'         => 2,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA SEGUNDA: OBLIGACIONES DEL ESTUDIANTE, PADRE DE FAMILIA Y/O
                                                        ACUDIENTE: a). El estudiante, padre de Familia y/o acudiente, se comprometen a cumplir con las normas
                                                        establecidas en el reglamento estudiantil del Instituto actualizado a la fecha de matrícula, oficializado y
                                                        publicado en la página web del INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S, e
                                                        informar oportunamente y por escrito, sugerencias, observaciones, inquietudes o molestias que se presenten
                                                        sobre la calidad de la capacitación. b). Pagar estricta y cumplidamente el valor total del curso equivalente a la
                                                        suma de DOS MILLONES OCHOCIENTOS CINCUENTA MIL PESOS 00/100 M.N. ($. 2.850.000,00)
                                                        de acuerdo a la modalidad de pago y términos estipulados en la Cláusula Quinta de este contrato. El no pago
                                                        mensual causará intereses moratorios a la tasa máxima autorizada por la ley. c). Cumplir con las obligaciones
                                                        contraídas en el presente contrato. d). Cumplir estrictamente las citas y los llamados que realice el
                                                        INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. e). Asumir el costo de los daños
                                                        ocasionados a bienes muebles, equipos y enseres o a la planta física del INSTITUTO DE CAPACITACIÓN
                                                        POLIANDINO CENTRAL S.A.S., que sean causados por negligencia del estudiante. f). Conocer y respetar
                                                        la filosofía institucional acatando las normas contenidas en el Reglamento estudiantil vigente, así como en los
                                                        procesos, procedimientos y reglamentos internos del INSTITUTO DE CAPACITACIÓN POLIANDINO
                                                        CENTRAL S.A.S. g). El estudiante, padre de Familia y/o acudiente declaran tener solvencia económica
                                                        necesaria para cumplir oportunamente con los compromisos económicos adquiridos en este contrato.',
                                    'orden'         => 3,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA TERCERA: OBLIGACIONES ESPECIALES: 1. Si el estudiante, padre de Familia y
                                                        acudiente cancela la totalidad del curso al que se matricula, independientemente de la modalidad de pago escogida y establecida en la Cláusula Quinta de este contrato, y decide abandonar o retirarse del programa una
                                                        vez este haya iniciado, el INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S., no
                                                        estará obligado a efectuar devolución de ninguna suma de dinero. 2. Si el estudiante, padre de Familia y/o
                                                        acudiente solicitó crédito estudiantil con la institución para poder dar inicio al proceso de formación, cuyos
                                                        términos serán los estipulados en la Cláusula Quinta de este contrato, y decide retirarse del programa
                                                        académico, se deberá cancelar el 50% del valor total adeudado a la fecha del retiro. 3. Si las clases no se han
                                                        iniciado y el estudiante no puede tomar el curso en la fecha para la cual se matriculó, el estudiante podrá
                                                        aplazarlo hasta por el término de doce (12) meses y/o cederlo a un tercero o familiar, lo cual deberá ser
                                                        informado por escrito a la INSTITUCIÓN a más tardar un (1) día antes de la iniciación de las clases del
                                                        programa, eventos en los cuales, no se exonerará de la cancelación total del valor del contrato según los
                                                        términos y condiciones establecidas por las partes en la cláusula quinta de este contrato. 4. Si el estudiante
                                                        realiza el pago del programa con retiro de cesantías, y el estudiante no inicia o abandona el curso, la
                                                        INSTITUCIÓN no realizará devolución de ninguna suma de dinero. 5. Si el estudiante requiere un traslado
                                                        de curso, cambio de horario, deberá informar por escrito oportunamente a la Coordinación Académica con
                                                        TRES (03) días de anterioridad, en caso de que el estudiante sea menor de edad, se deberá contar con carta de
                                                        autorización del padre de familia y/o acudiente. 6. Los programas iniciarán con un cupo mínimo de
                                                        estudiantes establecido por la INSTITUCIÓN, por lo tanto, en caso de no llenarse ese cupo mínimo, ésta se
                                                        reserva el derecho y la facultad de postergar la fecha de inicio de las clases e informará esta situación a los
                                                        estudiantes. 7. Si la INSTITUCIÓN considera que no es viable la iniciación del programa podrá cancelarlo,
                                                        informando a los estudiantes los motivos que conllevaron a tal decisión, y la nueva programación para el
                                                        desarrollo del mismo, sin que ello dé lugar a sanción alguna por mora o cancelación del servicio. 8. Una vez
                                                        haya iniciado el programa y si durante el transcurso del mismo, por causas ajenas al Instituto, se presenta una
                                                        deserción de los estudiantes matriculados y el programa no cuenta el mínimo requerido para su continuidad,
                                                        el INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S., se reserva la facultad de
                                                        suspender el programa, generando las siguientes alternativas para los estudiantes activos: 1. Ofrecer otros
                                                        horarios en las jornadas que actualmente se ofrezcan los cursos y que cuenten con cupos disponibles. 2.
                                                        Ofrecer en el mismo horario, dejando un tiempo para nuevas matrículas, este tiempo no será mayor a 90 días.
                                                        En todo caso, ajustando las nuevas condiciones a las necesidades del estudiante y a la logística de la
                                                        institución. Para ello el estudiante deberá encontrarse a paz y salvo con la institución. 9. En el evento de que
                                                        el estudiante, padre de Familia y/o acudiente, presente mora frente a la cancelación de las cuotas del valor del
                                                        contrato, El INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. establece un término
                                                        de treinta (30) días calendario, contado a partir de la fecha en que debió realizarse el pago, para que se
                                                        realicen conciliaciones frente al pago y pagos totales del curso, pasado dicho término, el Instituto realizara el
                                                        procedimiento necesario para el reporte a Centrales de Riesgo e iniciar las acciones legales pertinentes para la
                                                        ejecución de los valores adeudados.
                                                        ',
                                    'orden'         => 4,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA CUARTA - DERECHOS DE LAS PARTES: A) ESTUDIANTE: 1. Recibir las clases del
                                                        programa matriculado. 2. Recibir asistencia técnica por parte de la INSTITUCIÓN para el uso de los
                                                        recursos y herramientas que se utilicen para el programa. El estudiante podrá presentar ante el instructor del
                                                        programa de la sede, ante coordinación académica, asistente académica en forma oportuna y respetuosa, los
                                                        reclamos, quejas y peticiones que considere pertinentes. B). INSTITUTO DE CAPACITACIÓN
                                                        POLIANDINO CENTRAL S.A.S: 1. Recibir oportunamente en los términos establecidos en el Anexo 1 del
                                                        presente Contrato, el pago respecto al precio pactado por la prestación del servicio. 2. Cerrar o fusionar
                                                        modalidades de cursos, que no cuenten con la población mínima de (10) estudiantes establecidas por la
                                                        INSTITUCIÓN, otorgando en todo caso a los estudiantes de estos grupos, diferentes alternativas de horarios para asegurar la prestación del servicio.',
                                    'orden'         => 5,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA QUINTA: VALOR Y FORMA DE PAGO: 1. Las partes acuerdan que el valor total del
                                                        programa equivale a la suma de DOS MILLONES OCHOCIENTOS CINCUENTA MIL PESOS 00/100
                                                        M.N. ($2.850.000,00), suma que el estudiante, padre de Familia y/o acudiente se obligan a pagar en su
                                                        totalidad, teniendo en cuenta que, a solicitud del estudiante, padre de Familia y/o acudiente, la institución le
                                                        otorgó crédito estudiantil, previo estudio y validación del área financiera/contable del INSTITUTO DE
                                                        CAPACITACIÓN POLIANDINO CENTRAL S.A.S., y le fue aprobada la siguiente modalidad de pago:
                                                        1( ) Diferido por cuotas: 6 cuotas mensuales pagaderas los 24 de cada mes y equivalentes a la suma de
                                                        CUATROCIENTOS CINCUENTA MIL PESOS 00/100 M.N. ($ 450.000,00), más costo de Matrícula
                                                        de CIENTO CINCUENTA MIL PESOS 00/100 M.N. ($ 150.000,00) cancelada al momento de la
                                                        inscripción.
                                                        2( ) Cancelación del valor total del curso de contado: ______ Medio de pago: Efectivo ___ PSE ___
                                                        Tarjeta de Crédito ___ Tarjeta Débito ___
                                                        3( ) Cheque: __________ Entidad Bancaria: __________
                                                        4( ) Desembolso de Cesantías: __________ Fondo Pensiones y Cesantías: __________
                                                        ',
                                    'orden'         => 6,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'La primera cuota deberá ser cancelada hasta el día: 24, A partir del vencimiento del día 25 se entiende que
                                                        existe mora frente al pago y, en consecuencia, comenzarán a regir el monto correspondiente a los intereses
                                                        moratorios según la tasa máxima legal permitida en Colombia, y la INSTITUCIÓN procederá con el
                                                        respectivo cobro y las acciones legales y/o judiciales que correspondan por incumplimiento del contrato.',
                                    'orden'         => 7,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'PARAGRAFO: DESCUENTO. - A la suma del valor total mencionado con anterioridad, se aplicará un
                                                        descuento adicional de $300.000 (trescientos mil pesos m/c) esto si efectúa el pago de la cuota antes de la
                                                        fecha máxima de vencimiento, la cual se encuentra programada para el día ____ de cada mes. Este descuento
                                                        se hará efectivo dentro de sus cuotas y/o mensualidades del programa por un valor de 50.000(cincuenta mil
                                                        pesos m/cte).',
                                    'orden'         => 8,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'PARAGRAFO: AUTORIZACIÓN. - El estudiante, padre de Familia y/o acudiente de conformidad con lo
                                                        establecido en el artículo 622 del Código de Comercio, autorizan en forma irrevocable a INSTITUTO DE
                                                        CAPACITACIÓN POLIANDINO CENTRAL S.A.S., para llenar el pagaré en blanco No. 19643 otorgado
                                                        a su favor y elaborado el día de la matrícula 19643, con los espacios relativos a la cuantía, intereses y fecha de
                                                        vencimiento, en cualquier tiempo y sin previo aviso, de acuerdo con las siguientes instrucciones: a) La cuantía
                                                        será igual al monto de todas las sumas adeudadas al INSTITUTO DE CAPACITACIÓN POLIANDINO
                                                        CENTRAL S.A.S., por concepto del valor de la matrícula y demás costos educativos. b) Los intereses serán
                                                        los moratorios que estén vigentes al momento que se haga exigible la obligación; c) La fecha de exigibilidad
                                                        del pagaré será la del día en que el título sea llenado. En caso de mora en la cancelación de cualquiera de las
                                                        obligaciones a cargo de los aceptantes del pagaré, serán exigibles inmediatamente las obligaciones existentes
                                                        a la fecha, sin necesidad de requerimiento ni constitución en mora, pues desde ya se autoriza a
                                                        INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S., para exigir de inmediato el pago
                                                        de todos y cada uno de los créditos a cargo de los obligados en el pagaré por vía ejecutiva o cualquier otro
                                                        medio legal. Igualmente autorizo al INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL
                                                        S.A.S., a consultar, reportar y divulgar en las Centrales de Riesgo e Información Comercial y Financiera o
                                                        cualquier entidad que maneje bases de datos de información comercial o crediticia que tengan los mismos propósitos, sobre la acusación, modificación, manejo y extinción de obligaciones contraídas con anterioridad
                                                        o en desarrollo del presente contrato.',
                                    'orden'         => 9,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'PARAGRAFO 1: VALOR DE OTROS DOCUMENTOS: Los derechos de grado del programa (Diploma
                                                        y Constancia de Notas), tiene un costo adicional, valor que será informado al estudiante en el momento de la
                                                        matrícula, y el cual se incrementará anualmente conforme a los establecido por el ministerio de educación
                                                        para tal fin.
                                                        ',
                                    'orden'         => 10,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'Adicionalmente el estudiante cancelará el kit de seguridad y overol, valores que se establecen dependiendo de
                                                        la talla de cada uniforme, este valor está establecido en el Reglamento estudiantil de la INSTITUCIÓN.',
                                    'orden'         => 11,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA SEXTA - INCUMPLIMIENTO DEL ESTUDIANTE: El incumplimiento o retraso del
                                                        estudiante, padre de familia y/o acudiente, en el pago de alguna de las cuotas mensuales estipuladas en la
                                                        Cláusula Quinta del presente Contrato, dará lugar a la constitución de mora en el pago, evento en el cual, la
                                                        INSTITUCIÓN podrá suspender total o parcialmente las lecciones presenciales adquiridas por el estudiante
                                                        y permitirá nuevamente el ingreso del estudiante a las lecciones presenciales, una vez el estudiante haya
                                                        efectuado el pago de sus obligaciones pendientes.',
                                    'orden'         => 12,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA SÉPTIMA - CAUSALES DE TERMINACIÓN DEL CONTRATO: 1. Por expiración del
                                                        término pactado. 2. Por mutuo consentimiento de las partes. 3. DE FORMA UNILATERAL POR PARTE
                                                        DE LA INSTITUCIÓN: 1. Cuando se evidencie un comportamiento indebido estipulado en el reglamento
                                                        estudiantil por parte del estudiante hacia INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL
                                                        S.A.S., o alguno de sus trabajadores o demás estudiantes. 2. Mora en alguno de los pagos de las obligaciones
                                                        adquiridas en el presente Contrato, según lo establecido en la Cláusula Quinta del Contrato, se considera mora
                                                        un día después de la fecha de pago de cada cuota. 3. Por el incumplimiento del estudiante frente a alguna de
                                                        las obligaciones establecidas en el Reglamento estudiantil.',
                                    'orden'         => 13,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA OCTAVA - CIRCUNSTANCIAS DE FUERZA MAYOR: Teniendo en cuenta la existencia
                                                        de circunstancias de fuerza mayor que pueden acontecer durante el desarrollo del presente Contrato de
                                                        Prestación de Servicios Educativos, el Instituto se reserva la facultad, de que, en el caso de llegar a
                                                        presentarse tales eventos, podrá tomar de manera unilateral la decisión de reubicar a los estudiantes de
                                                        acuerdo a la logística que considere pertinente y adecuada, así como establecer, de ser necesario, nuevas
                                                        fechas y horarios para el inicio o continuidad del programa educativo, todo a fin de que se le garantice al
                                                        estudiante la prestación del servicio educativo adquirido por él.
                                                        ',
                                    'orden'         => 14,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA NOVENA - TRATAMIENTO DE DATOS PERSONALES: el estudiante, padre de familia
                                                        y/o acudiente, otorga autorización previa, expresa e informada al INSTITUTO DE CAPACITACIÓN
                                                        POLIANDINO CENTRAL S.A.S., para el tratamiento de sus datos personales contenidos en este Contrato y
                                                        en sus Anexos, para que sean utilizados de conformidad con las políticas y procedimientos para el manejo de
                                                        datos personales de la institución y con lo dispuesto en la Ley 1581 de 2012 y sus decretos Reglamentarios.
                                                        Los datos personales del estudiante serán objeto del siguiente tratamiento: recolección, almacenamiento,
                                                        actualización, facturación, cobros, monitoreo de las lecciones, envío de información sobre nuevos programas
                                                        educativos o actividades académicas, copia de seguridad en el CCTV (Circuito Cerrado de Televisión) dentro
                                                        de las sedes de la INSTITUCIÓN y envío de la información de contacto a la empresa de logística contratada
                                                        por la INSTITUCIÓN para el agendamiento y entrega personalizada del material de estudio. El responsable y Encargado del Tratamiento de los datos personales será el INSTITUTO DE CAPACITACIÓN
                                                        POLIANDINO S.A.S., El Manual de Políticas de Privacidad del Instituto respecto del tratamiento de los
                                                        datos personales está disponible en www.poliandinocentral.com. El estudiante podrá ejercer todos los
                                                        derechos previstos en la Ley 1581 de 2012 y sus Decretos Reglamentarios, entre los cuales se encuentra
                                                        conocer, actualizar, rectificar, entre otros, para lo cual podrá dirigirse al siguiente correo electrónico:
                                                        poliandinocentral@gmail.com
                                                        ',
                                    'orden'         => 15,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLÁUSULA DÉCIMA: AUTORIZACIÓN PARA LA CONSULTA, REPORTE Y
                                                        PROCESAMIENTO DE DATOS FINANCIEROS EN LAS CENTRALES DE RIESGO CIFIN Y
                                                        DATACREDITO. El abajo firmante, en su propio nombre declara que la información suministrada es
                                                        verídica y da su consentimiento expreso e irrevocable a el INSTITUTO DE CAPACITACIÓN
                                                        POLIANDINO S.A.S., o a quien en el futuro haga sus veces como titular del crédito o servicio Solicitado,
                                                        para: a) Consultar, en cualquier tiempo, en Data Crédito o en cualquier otra base de datos manejada por un
                                                        operador de información financiera y crediticia, toda la información relevante para conocer su desempeño
                                                        como deudor, su capacidad de pago, la viabilidad para entablar o mantener una relación contractual, o para
                                                        cualquier otra finalidad, incluyendo sin limitarse la realización de campañas de mercadeo, ofrecimiento de
                                                        productos y publicidad en general b) Reportar a Data Crédito o a cualquier otra base de datos manejada por
                                                        un operador datos, tratados o sin tratar, sobre el cumplimiento o incumplimiento de sus obligaciones
                                                        crediticias, sus deberes legales de contenido patrimonial, sus datos de ubicación y contacto (número de
                                                        teléfono fijo, número de teléfono celular, dirección del domicilio, dirección laboral y correo electrónico), sus
                                                        solicitudes de crédito así como otros atinentes a sus relaciones comerciales, financieras y en general
                                                        socioeconómicas que haya entregado o que consten en registros públicos, bases de datos públicas o
                                                        documentos públicos. c) La autorización anterior no impedirá al abajo firmante o su representada, ejercer el
                                                        derecho a corroborar en cualquier tiempo en LA ENTIDAD, en Data Crédito o en la central de información
                                                        de riesgo a la cual se hayan suministrado los datos, que la información suministrada es veraz, completa,
                                                        exacta y actualizada, y en caso de que no lo sea, a que se deje constancia de su desacuerdo, a exigir la
                                                        rectificación y a ser informado sobre las correcciones efectuadas.',
                                    'orden'         => 16,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLÁUSULA DÉCIMA PRIMERA - LEGALIDAD: para efectos legales el estudiante, padre de familia y/o
                                                        acudiente, certifica que la información diligenciada y enviada en su Pre-Inscripción e/o Inscripción es veraz.
                                                        Los datos que representan validez para el presente contrato del estudiante, padre de familia y/o acudiente, son
                                                        aquellos diligenciados en el proceso de Inscripción.
                                                        ',
                                    'orden'         => 17,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLÁUSULA DÉCIMA SEGUNDA - MODIFICACIONES: Toda modificación de este Contrato o sus
                                                        Anexos deberá constar por escrito en Otrosí que deberá estar suscrito por las partes.',
                                    'orden'         => 18,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA DÉCIMA TERCERA: DIRECCIÓN PARA NOTIFICACIONES: El Estudiante, Padre de
                                                        Familia y/o Acudiente recibirá notificaciones en: DG 15 D 44-14 SAN RAFAEL, PUENTE ARANDA
                                                        Y el INSTITUTO DE CAPACITACIÓN POLIANDINO S.A.S.: CALLE 66A Nro. 17-48 CHAPINERO
                                                        ',
                                    'orden'         => 19,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA DÉCIMA CUARTA: - MÉRITO EJECUTIVO: El presente contrato por sí solo presta
                                                        mérito ejecutivo, incorporada una Obligación, Clara, Expresa y Exigible, según lo determina el Artículo 422
                                                        del Código General del Proceso, y será prueba como documento auténtico según lo determina el artículo 244
                                                        del Código General del Proceso.',
                                    'orden'         => 20,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CLAUSULA DÉCIMA QUINTA: Autorizo a entregar información sobre asistencias, notas, proceso
                                                        académico, estado de cartera e información general a:
                                                        Nombre: WILSON MURCIA C.C.: ____________________ Número de contacto: 3118520224',
                                    'orden'         => 21,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'Para constancia se firma por las Partes en la ciudad de Bogotá, a los 15 días del mes de diciembre del año
                                                        2023, en dos ejemplares de igual tenor y valor.
                                                        ',
                                    'orden'         => 22,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                            DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'firma',
                                    'contenido'     => 'firma',
                                    'orden'         => 23,
                                    'documento_id'  => $contrato->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);


        $pagare=Documento::create([
                            'fecha'     =>now(),
                            'tipo'      =>"pagare",
                            'titulo'    =>"Pagare",
                            'status'    =>3,
                            'creador_id'=>1,
                        ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                        'contenido'     => 'PRIMERA. OBJETO: Que por medio del presente PAGARÉ, nos obligamos a pagar cumplida, incondicional y solidariamente a INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. , con NIT 900656857-5, ubicado en la la ciudad Bogotá D.C.,o a su orden, ó a quien represente sus derechos, la suma de ____________________________________________________ moneda legal colombiana, ($___________________)',
                                    'orden'         => 1,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'SEGUNDA. INTERESES: Nos obligamos a reconocer y pagar a favor del INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. los intereses de mora, en caso de mora en el pago de una o varias cuotas de capital, a la tasa ( %) mensual, la cual es la máxima permitida por la Ley; liquidados sobre las cuotas de capital pactadas y adeudadas, sin perjuicio de las acciones legales que el INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. pueda adelantar para el cobro judicial y/o extrajudicial de la obligación, caso en el cual, serán de nuestro cargo exclusivo los gastos y las costas de la cobranza, incluyendo los honorarios del abogado, a  quien se confíe las gestiones de cobro que serán equivalentes al 20% del total de la deuda por capital e intereses.',
                                    'orden'         => 2,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'TERCERA. CLAUSULA ACELERATORIA: En el evento de la mora frente al pago de las obligaciones aquí adquiridas y a que se refiere el presente pagaré, cancelaremos al INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. , la totalidad de la suma global adeudada. El tenedor del presente pagaré podrá declarar vencidos la totalidad de los plazos de esta obligación o de las cuotas que constituyan el saldo de lo debido y exigir su pago inmediato ya sea judicial o extrajudicialmente, cuando los deudores entren en mora o incumplan una cualquiera de las obligaciones derivadas del presente documento.',
                                    'orden'         => 3,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'CUARTA. Expresamente declaramos excusado el protesto del presente pagaré y los requerimientos judiciales o extrajudiciales para la constitución en mora.',
                                    'orden'         => 4,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'Para garantizar el cumplimiento de las obligaciones, EL DEUDOR Y/O DEUDORES aceptamos firmar libremente el presente pagaré y autorizamos expresamente al INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL S.A.S. , para que llene los espacios en blanco del citado pagaré, según lo establecido en el parágrafo de la cláusula número quinta del contrato del contrato de prestación de servicios educativos suscrito el día ______________________________________________________',
                                    'orden'         => 5,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'MÉRITO EJECUTIVO: El presente pagaré por sí solo presta mérito ejecutivo, incorporada una Obligación, Clara, Expresa y Exigible, según lo
                                    determina el Artículo 422 del Código General del Proceso que establece: “Pueden demandarse ejecutivamente las obligaciones expresas, claras y
                                    exigibles que consten en documentos que provengan del deudor o de su causante, y constituyan plena prueba contra él, o las que emanen de una
                                    sentencia de condena proferida por juez o tribunal de cualquier jurisdicción, o de otra providencia judicial, o de las providencias que en procesos de policía
                                    aprueben liquidación de costas o señalen honorarios de auxiliares de la justicia, y los demás documentos que señale la ley..”
                                    ',
                                    'orden'         => 6,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'IMPORTANTE: El cumplimiento de este acuerdo no depende de la asistencia del estudiante a clases, se entiende como un compromiso contractual,
                                    el cual debe ser cumplido y cancelado en su totalidad ya que es producto de un préstamo a nombre del DEUDOR.
                                    En constancia de lo anterior, se suscribe este documento el día , del mes de de 2021',
                                    'orden'         => 7,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'firma',
                                    'contenido'     => 'firma',
                                    'orden'         => 9,
                                    'documento_id'  => $pagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

        $cartapagare=Documento::create([
                            'fecha'     =>now(),
                            'tipo'      =>"cartaPagare",
                            'titulo'    =>"carta Pagare",
                            'status'    =>3,
                            'creador_id'=>1,
                        ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'De conformidad con lo establecido en el artículo 622 del Código de Comercio Colombiano, que establece:
                                        “Lleno de espacios en blanco y títulos en blanco – validez Si en el título se dejan espacios en blanco
                                        cualquier tenedor legítimo podrá llenarlos, conforme a las instrucciones del suscriptor que los haya dejado,
                                        antes de presentar el título para el ejercicio del derecho que en él se incorpora.Una firma puesta sobre un
                                        papel en blanco, entregado por el firmante para convertirlo en un título-valor, dará al tenedor el derecho
                                        de llenarlo. Para que el título, una vez completado, pueda hacerse valer contra cualquiera de los que en
                                        él han intervenido antes de completarse, deberá ser llenado estrictamente de acuerdo con la autorización
                                        dada para ello. Si un título de esta clase es negociado, después de llenado, a favor de un tenedor de
                                        buena fe exenta de culpa, será válido y efectivo para dicho tenedor y éste podrá hacerlo valer como si se
                                        hubiera llenado de acuerdo con las autorizaciones dadas”. Autorizo (amos) expresa e irrevocablemente
                                        al INSTITUTO POLIANDINO CENTRAL y/o a quien represente sus derechos, para llenar los espacios en
                                        blanco que se han dejado en el pagaré que aparece al respaldo, para lo cual deberá ceñirse a las
                                        siguientes instrucciones:
                                        ',
                                    'orden'         => 1,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);
                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => '1. La fecha de vencimiento será la del día en que sea llenado.',
                                    'orden'         => 2,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => '2. El monto del pagaré será igual al valor de todas las obligaciones exigibles a mi (nuestro) cargo a favor
                                    de INSTITUTO POLIANDINO CENTRAL y/o quien represente sus derechos, que existan al momento
                                    de ser llenados los espacios para lo cual se tendrán en cuenta los compromisos que por todo
                                    concepto haya (mos) asumido para con INSTITUTO POLIANDINO CENTRAL',
                                    'orden'         => 3,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => '3. La cuota que comprenderá capital e intereses y que será fija, podrá ser determinada por INSTITUTO
                                    POLIANDINO CENTRAL y/o quien represente sus derechos y consignada en el correspondiente
                                    espacio en blanco del pagaré desde el momento en que se produzca el desembolso del crédito. Así
                                    mismo llenará el espacio correspondiente a la tasa remuneratoria.',
                                    'orden'         => 4,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => '4. Los espacios en blanco podrán llenarse además cuando ocurra una cualquiera de las circunstancias
                                    estipulad',
                                    'orden'         => 5,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'a) Si fuere (mos) demandado(s) ante cualquier autoridad y por cualquier persona.
                                    ',
                                    'orden'         => 6,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'b) Si las garantías que se otorguen para amparar las obligaciones a cargo de los deudores a
                                    favor del acreedor resultaren insuficientes, se depreciaren a juicio del acreedor, carezcan de
                                    los correspondientes seguros, o si fueren perseguidas judicialmente por terceros.
                                    ',
                                    'orden'         => 7,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'c) Por mora en el pago, cualquiera que sea la causa, de una o más de las obligaciones periódicas
                                    pactadas con el acreedor, aun cuando las mismas sólo comprendan intereses o cuotas de
                                    seguro.',
                                    'orden'         => 8,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'parrafo',
                                    'contenido'     => 'd) Por la muerte del deudor (o cualquiera de los deudores).',
                                    'orden'         => 9,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);

                        DB::table('detalle_documento')
                                ->insert([
                                    'tipodetalle'   => 'firma',
                                    'contenido'     => 'firma',
                                    'orden'         => 10,
                                    'documento_id'  => $cartapagare->id,
                                    'created_at'    =>now(),
                                    'updated_at'    =>now()
                                ]);
    }
}
