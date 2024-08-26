<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cobranza;
use App\Traits\MailTrait;
use App\Traits\PdfTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CobranzaGestion extends Command
{
    use MailTrait;
    use PdfTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cobranza:Gestion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía los correos de cobranza necesarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dias=config('instituto.dias_cobranza');
        $cobranza=config('instituto.dias_reporte');
        $diferencia=$cobranza-$dias;

        $cobranzas=Cobranza::where('status',3)->get();

        foreach ($cobranzas as $value) {

            try {

                if($value->dias===intval($dias)){
                    //Enviar primera notificación
                    //Genera Carta
                    $this->cobranzapdf($value->id);

                    //Enviar email
                    $this->claseEmail(4,$value->id);
                }

                if($value->dias>intval($dias) && $value->dias<intval($cobranza)){
                    //Enviar invitaciones a negociar
                    //Genera invitación a negociar
                    $this->cobranzanegociacionpdf($value->id);

                    //Enviar email
                    $this->claseEmail(5,$value->id);

                    //Actualizar campo diasreporte restando un día.
                    $value->update([
                        'diasreporte'=>$value->diasreporte-1,
                        'correos'=>now()." AUTOMATICO: Correo Notificación anticipación: ".$value->diasreporte." días. ----- ".$value->correos,
                    ]);
                }

                if($value->dias===intval($cobranza)){
                    //Enviar notificación de reporte
                    //Genera notificación
                    $this->cobranzareportepdf($value->id);

                    //Enviar email
                    $this->claseEmail(6,$value->id);

                    //Actualizar campo correos
                    $value->update([
                        'correos'=>now()." AUTOMATICO: Correo Notificación envío reporte. ----- ".$value->correos,
                    ]);
                }

                if($value->dias>intval($cobranza) && $value->diasreporte<=$diferencia){
                    //Enviar notificación de negociación
                    //Genera invitación a negociar
                    $this->cobranzareportenegocipdf($value->id);

                    //Enviar email
                    $this->claseEmail(7,$value->id);

                    //Aumentar diasreporte
                    $value->update([
                        'diasreporte'=>$value->diasreporte+1,
                        'correos'=>now()." AUTOMATICO: Correo Notificación negociación: ".$value->diasreporte." días. ----- ".$value->correos,
                    ]);
                }

            } catch(Exception $exception){
                Log::info('Cobranza N°: ' . $value->id . ' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
            }
        }
    }
}