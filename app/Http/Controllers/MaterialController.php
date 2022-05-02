<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Material;
use App\Unidad;

use Illuminate\Support\Facades\Log;


class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::get();
        return view('materiales.index', ['materiales'=>$materiales]);
    }

    public function create()
    {
        //Obtener paises
        $unidades = Unidad::all();
        return view('materiales/create',['unidades'=>$unidades]);
    }

    public function store(MaterialRequest $request)
    {
        Material::create([
            'descripcion'=>$request->descripcion,
            'unidad_id'=>$request->unidad_id
        ]);
        return redirect()->route('materiales.index');
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);

        return view('materiales.show',['material'=>$material]);
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $unidades = Unidad::all();

        return view('materiales.edit', [
            'material'=>$material,
            'unidades'=>$unidades
            ]);
    }

    public function update(MaterialRequest $request, $id)
    {
        $material = Material::findOrFail($id);
        $material->update($request->validated());
        return redirect()->route('materiales.index');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        //Project::destroy($id)
        try{
            $material->delete();
            return redirect()->route('materiales.index');
        } catch(\Exception $e) {
            return redirect()->route('materiales.index')->with('alert', 'No se puede borrar el material porque está siendo referenciado por otra instancia.');
        }
    }
}
