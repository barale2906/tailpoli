<?php

namespace App\Livewire\Academico\Curso;

use App\Models\Academico\Curso;
use App\Models\Academico\Planes as AcademicoPlanes;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Planes extends Component
{
    use WithFileUploads;

    public $actual;
    public $word;
    public $rutaword;
    public $pdf;
    public $rutapdf;
    public $nombre;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($elegido){
        $this->actual=Curso::find($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'nombre'  => 'required|max:100',
        'word'  => 'required|mimes:xls,xlsx,doc,docx',
        'pdf'  => 'required|mimes:pdf',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('nombre', 'word', 'pdf');
    }

    public function cargar(){

        // validate
        $this->validate();

        //Inactivar anterior
        AcademicoPlanes::where('curso_id', $this->actual->id)
                                    ->where('status', true)
                                    ->update([
                                        'status' => false
                                    ]);


        $this->rutaword='planes/word/'.$this->actual->id."-".uniqid().".".$this->word->extension();
        $this->word->storeAs($this->rutaword);

        $this->rutapdf='planes/pdf/'.$this->actual->id."-".uniqid().".".$this->pdf->extension();
        $this->pdf->storeAs($this->rutapdf);

        AcademicoPlanes::create([
            'curso_id'      => $this->actual->id,
            'ruta_pdf'      => $this->rutapdf,
            'ruta_word'     => $this->rutaword,
            'name'          => strtolower($this->nombre)
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha anexado correctamente el archivo: '.$this->nombre);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }


    public function render()
    {
        return view('livewire.academico.curso.planes');
    }
}
