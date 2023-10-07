<?php

namespace App\Livewire\Layouts;

use App\Models\Menu;
use Livewire\Component;

class Navbar extends Component
{
    private function menus(){
        return Menu::where('status',true)
                    ->get();
    }

    public function render()
    {
        return view('livewire.layouts.navbar', [
            'menus'=>$this->menus()
        ]);
    }
}
