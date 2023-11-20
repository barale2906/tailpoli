<?php

namespace App\Livewire\Layouts;

use App\Models\Inventario\Inventario;
use App\Models\Menu;
use Livewire\Component;

class Navbar extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    private function menus(){
        return Menu::where('status',true)
                    ->get();
    }

    private function pendInventarios(){

        return Inventario::where('entregado', false)
                            ->count('entregado');
    }

    public function render()
    {
        return view('livewire.layouts.navbar', [
            'menus'=>$this->menus(),
            'pendInventarios'=>$this->pendInventarios()
        ]);
    }
}
