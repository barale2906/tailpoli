<?php

namespace App\Livewire\Configuracion\Documento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentosTipo extends Component
{
    use WithPagination;

    public $ordena='name';
    public $ordenado='DESC';
    public $pages=15;

    public $name;
    public $descripcion;


    protected $listeners = ['refresh' => '$refresh'];

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    //Crear tipo de documento
    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'          => 'required|unique:tipo_documentos|max:255',
        'descripcion'   => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'descripcion'
                    );
    }

    public function new(){

        // validate
        $this->validate();

        DB::table('tipo_documentos')->insert([
            'name'          =>strtolower($this->name),
            'descripcion'   =>strtolower($this->descripcion),
            'created_at'    =>now(),
            'updated_at'    =>now(),
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el tipo de documento:  '.strtoupper($this->name));
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
    }

    private function documentos(){
        return DB::table('tipo_documentos')
                    ->where('status', true)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.configuracion.documento.documentos-tipo',[
            'documentos'=>$this->documentos()
        ]);
    }
}
