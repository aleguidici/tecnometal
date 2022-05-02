<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveLocalidadRequest;
use Illuminate\Http\Request;
use App\Localidad;
use App\Provincia;
use App\Pais;

use Illuminate\Support\Facades\Log;

class LocalidadController extends Controller
{
    public function index()
    {
        return view('localidades.index', [
            'localidades' => Localidad::orderBy('provincia_id', 'DESC')->get()
            //Persona::where('id', '=', 1)->orderBy('created_at', 'DESC')->get()
        ]);
    }
    
    public function create()
    {
        //Obtener paises
        $paises = Pais::all();
        return view('localidades/create',['paises'=>$paises]);
    }

    public function store(SaveLocalidadRequest $request)
    {
        
        Localidad::create([
            'name'=>$request->name,
            'codigo_postal'=>$request->codigo_postal,
            'provincia_id'=>$request->provincia_id,
        ]);

        return redirect()->route('localidades.index');
    }

    public function edit($id)
    {
        $localidad = Localidad::findOrFail($id);
        $provincias = Provincia::where('pais_id',$localidad->provincia->pais->id)->get();
        
        return view('localidades.edit', [
            'localidad' => $localidad,
            'paises' => Pais::all(),
            'provincias'=>$provincias]);
    }

    public function update($id, SaveLocalidadRequest $request)
    {
        $localidad = Localidad::findOrFail($id);

        $localidad->update( $request->validated() );

        return redirect()->route('localidades.index');
    }
    
    public function destroy($id)
    {
        $localidad = Localidad::findOrFail($id);

        //Project::destroy($id)
        
        try{
            $localidad->delete();
            return redirect()->route('localidades.index');
        } catch(\Exception $e) {
            return redirect()->route('localidades.index')->with('alert', 'No se puede borrar la localidad porque está siendo referenciada por otra instancia.');
        }

    }

    public function store_loc(Request $request){
        $loc = Localidad::create([
            'name'=>$request->name,
            'codigo_postal'=>$request->codigo_postal,
            'provincia_id'=>$request->provincia_id,
        ]);

        return response()->json(["status"=>TRUE,"data"=>$loc]);
    }

    public function get_localidades(Request $request){
        $localidades = Localidad::where('provincia_id',$request->provincia_id)->get();
        return response()->json(['status'=>TRUE,'data'=>$localidades]);
    }
}
