<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::latest('id')->paginate();
        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
        Country::create($request->all());

        session()->flash('Swal', [

                'icon'  => 'success',
                'title' => '¡Correcto!',
                'text'  => 'El País se ha creado correctamente.',
        ]);

        return redirect()->route('admin.countries.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $country->update($request->all());

        session()->flash('Swal', [

                'icon'  => 'success',
                'title' => '¡Correcto!',
                'text'  => 'El País se actualizo correctamente.',
        ]);

        return redirect()->route('admin.countries.edit', $country);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {

        $country->delete();

        session()->flash('Swal', [

            'icon'  => 'error',
            'title' => '¡Eliminado!',
            'text'  => 'El País se eliminó correctamente.',
        ]);

        return redirect()->route('admin.countries.index');

    }
}
