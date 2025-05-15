<?php

namespace Database\Seeders;

use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class SaldoSeeder extends Seeder
{
    public $almacenes;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos=Inventario::select('producto_id')->groupby('producto_id')->get();
        $this->almacenes=Almacen::select('id')->orderby('name','ASC')->get();

        foreach ($productos as $value) {
            $this->saldoAlmacen($value->producto_id);
        }
    }

    private function saldoAlmacen($producto){

        foreach ($this->almacenes as $value) {
            $inventarios=Inventario::where('status',1)
                                    ->where('producto_id',intval($producto))
                                    ->where('almacen_id',$value->id)
                                    ->orderBy('id','DESC')
                                    ->get();

            $final=$inventarios->first();

            if($inventarios->count()>1){
                Inventario::where('status',1)
                                    ->where('producto_id',intval($producto))
                                    ->where('almacen_id',$value->id)
                                    ->update([
                                        'status'    =>0
                                    ]);

                Inventario::where('id',$final->id)
                            ->update([
                                'status'    =>1
                            ]);

                Log::info('PRODUCTO: ' . $producto.' Almacen: '.$value->id.' Final: '.$final->id);
            }
        }

    }
}
