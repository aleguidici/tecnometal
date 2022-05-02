<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ManoObraRequest;
use App\ManoObra;
use App\TipoManoObra;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class ManoObraController extends Controller
{
    public function index()
    {
        $manos_obra = ManoObra::get();

        foreach ($manos_obra as $una_mano_obra) {
            $tiempo_total_float = $una_mano_obra->duracion/3600;
            $total_horas = floor($tiempo_total_float);
            $total_minutos = ($tiempo_total_float-$total_horas)*60;

            /* Ej.:
                0,47hs. (28,2 minutos)
                3,31hs. (3 horas y 18,6 minutos)
                2hs. (2 horas) */

            if(fmod($total_minutos, 1) !== 0.00) {
                $una_mano_obra->minutos = number_format($total_minutos, 2);
            } else {
                $una_mano_obra->minutos = $total_minutos;
            }
            $una_mano_obra->horas = $total_horas;

            if(fmod($tiempo_total_float, 1) !== 0.00) {
                $una_mano_obra->tiempo_total = number_format($tiempo_total_float, 2);
            } else {
                $una_mano_obra->tiempo_total = $tiempo_total_float;
            }
        }

        return view('manos_obra.index', ['manos_obra'=>$manos_obra]);
    }

    public function create()
    {
        $tipos_mano_obra = TipoManoObra::all();
        return view('manos_obra/create',['tipos_mano_obra'=>$tipos_mano_obra]);
    }

    public function store(ManoObraRequest $request)
    {
        $id_TipoManoObra = TipoManoObra::where('descripcion','Mantenimiento')->value('id');

        ManoObra::create([
            'name'=>$request->name,
            'descripcion'=>$request->descripcion,
            'tipo_mano_obra_id' => $request->tipo_mano_obra_id,
        ]);
        return redirect()->route('manos_obra.index');
    }

    public function show($id)
    {
        $mano_obra = ManoObra::findOrFail($id);

        return view('manos_obra.show',['mano_obra'=>$mano_obra]);
    }

    public function edit($id)
    {
        $mano_obra = ManoObra::findOrFail($id);
        $tipos_mano_obra = TipoManoObra::all();

        return view('manos_obra.edit', [
            'mano_obra'=>$mano_obra,
            'tipos_mano_obra'=>$tipos_mano_obra
            ]);
    }

    public function update(ManoObraRequest $request, $id)
    {
        $mano_obra = ManoObra::findOrFail($id);
        $mano_obra->update([
            'name'=>$request->name,
            'descripcion'=>$request->descripcion,
            'tipo_mano_obra_id' => $request->tipo_mano_obra_id,
        ]);
        return redirect()->route('manos_obra.index');
    }

    public function destroy($id)
    {
        $mano_obra = ManoObra::findOrFail($id);

        //Project::destroy($id)
        try{
            $mano_obra->delete();
            return redirect()->route('manos_obra.index');
        } catch(\Exception $e) {
            return redirect()->route('manos_obra.index')->with('alert', 'No se puede borrar el detalle de mano de obra porque está siendo referenciado por otra instancia.');
        }
    }
}
