<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ActividadPreestablecidaRequest;
use App\ActividadPreestablecida;
use App\AP_ManoObra;
use App\AP_Material;
use App\AP_Item;
use App\TipoManoObra;
use App\ManoObra;
use App\Material;
use Redirect;

use Illuminate\Support\Facades\Log;


class ActividadPreestablecidaController extends Controller
{
    public function index()
    {
        $actividades = ActividadPreestablecida::get();
        $actividades_pendientes = array();
        $actividades_disponibles = array();

        foreach ($actividades as $una_activ) {
            //CONTEO DE MANOS DE OBRA
            $AP_manos_obra = AP_ManoObra::where('ap_id',$una_activ->id)->get();
            $duracion_total = 0;
            foreach ($AP_manos_obra as $una_relacion) {
                $duracion_total = $duracion_total + $una_relacion->duracion;
            }
            $una_activ->tiempo_total = $duracion_total/3600;

            $total_horas = floor($una_activ->tiempo_total);
            $total_minutos = ($una_activ->tiempo_total-$total_horas)*60;

            /* Ej.:
                0,47hs. (28,2 minutos)
                3,31hs. (3 horas y 18,6 minutos)
                2hs. (2 horas) */

            if(fmod($total_minutos, 1) !== 0.00) {
                $una_activ->minutos = number_format($total_minutos, 2);
            } else {
                $una_activ->minutos = $total_minutos;
            }
            $una_activ->horas = $total_horas;

            if(fmod($una_activ->tiempo_total, 1) !== 0.00) {
                $una_activ->tiempo_total = number_format($una_activ->tiempo_total, 2);
            }

            //CONTEO DE MATERIALES
            $AP_materiales = AP_Material::where('ap_id',$una_activ->id)->get();
            $cant_materiales = 0;
            foreach ($AP_materiales as $un_material) {
                $cant_materiales++;
            }

            $una_activ->total_materiales = $cant_materiales;

            if (!$una_activ->pendiente){
                array_push($actividades_disponibles, $una_activ);
            } else {
                array_push($actividades_pendientes, $una_activ);
            }
        }

        return view('actividades_preestablecidas.index', ['actividades_disponibles'=>$actividades_disponibles, 'actividades_pendientes'=>$actividades_pendientes]);
    }

    public function create()
    {
        return view('actividades_preestablecidas/create');
    }

    public function store(ActividadPreestablecidaRequest $request)
    {
        ActividadPreestablecida::create([
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion
        ]);
        return redirect()->route('actividades_preestablecidas.index');
    }

    public function show($id)
    {
        $mano_obra = ManoObra::findOrFail($id);

        return view('actividades_preestablecidas.show',['mano_obra'=>$mano_obra]);
    }

    public function edit($id)
    {
        $mano_obra = ManoObra::findOrFail($id);
        $tipos_mano_obra = TipoManoObra::all();

        return view('actividades_preestablecidas.edit', [
            'mano_obra'=>$mano_obra,
            'tipos_mano_obra'=>$tipos_mano_obra
            ]);
    }

    public function update(Request $request)
    {
        //TODO: Arreglar Update, Esto en realidad tiene que ser actualización de actividad preestablecida.
        Log::info($request);
        $ap = ActividadPreestablecida::findOrFail($request->id_ap);
        $ap->update([
            'titulo'=>$request->titulo,
            'descripcion'=>$request->desc,
        ]);
        return response()->json(['status'=>TRUE]);
    }

    public function destroy($ap_id)
    {
        $ap = ActividadPreestablecida::find($ap_id);

        //Project::destroy($id)
        try{
            if(!empty(AP_Item::where('ap_id',$ap_id)->get()->first())){
                throw new \Exception('');
            } else {
                AP_ManoObra::where('ap_id', $ap_id)->delete();
                AP_Material::where('ap_id', $ap_id)->delete();
                ActividadPreestablecida::findOrFail($ap_id)->delete();
                return redirect()->route('actividades_preestablecidas.index')->with('alertOk', 'Actividad Preestablecida borrada exitosamente.');
            }

        } catch(\Exception $e) {
            return redirect()->route('actividades_preestablecidas.index')->with('alert', 'No se puede borrar la actividad preestablecida porque está siendo referenciado por otra instancia.');
        }
    }

    public function update_pendiente(Request $request){
        $ap = ActividadPreestablecida::find($request->id);
        Log::info($ap);

        $ap->pendiente = false;
        $ap->save();

        return response()->json(['status'=>TRUE]);
    }

    public function manos_obra($id)
    {
        $actividad_preestablecida = ActividadPreestablecida::findOrFail($id);
        $all_relaciones = AP_ManoObra::where('ap_id',$id)->get();
        $all_relaciones->duracion_total = 0;

        $ids_mano_obra = [];

        foreach ($all_relaciones as $una_relacion) {
            $ids_mano_obra[] = $una_relacion->mano_obra_id;
            //duracion_individual
            $una_relacion->duracion_individual = $una_relacion->duracion/3600;
            $una_relacion->horas_individual = floor($una_relacion->duracion_individual);
            $una_relacion->minutos_individual = ($una_relacion->duracion_individual-$una_relacion->horas_individual)*60;
            if(fmod($una_relacion->minutos_individual, 1) !== 0.00) {
                $una_relacion->minutos_individual = number_format($una_relacion->minutos_individual, 2);
            }

            /* Ej.:
                0,47hs. (28,2 minutos)
                3,31hs. (3 horas y 18,6 minutos)
                2hs. (2 horas) */

            $all_relaciones->duracion_total = $all_relaciones->duracion_total + $una_relacion->duracion_individual;

            //formatos
            if(fmod($una_relacion->duracion_individual, 1) !== 0.00) {
                $una_relacion->duracion_individual = number_format($una_relacion->duracion_individual, 2);
            }

        }

        $all_relaciones->tot_horas = floor($all_relaciones->duracion_total);
        $all_relaciones->total_minutos = ($all_relaciones->duracion_total-$all_relaciones->tot_horas)*60;

        if(fmod($all_relaciones->duracion_total, 1) !== 0.00) {
            $all_relaciones->duracion_total = number_format($all_relaciones->duracion_total, 2);
        }

        if(fmod($all_relaciones->total_minutos, 1) !== 0.00) {
            $all_relaciones->total_minutos = number_format($all_relaciones->total_minutos, 2);
        }

        if(!empty($ids_mano_obra)){
            $manos_obra = ManoObra::whereNotIn('id',$ids_mano_obra)->get();
        }else{
            $manos_obra = ManoObra::all();
        }

        return view('actividades_preestablecidas.manos_obra',[
            'all_relaciones'=>$all_relaciones,
            'actividad_preestablecida'=>$actividad_preestablecida,
            'manos_obra'=>$manos_obra,]);
    }

    public function mano_obra_update_amount(Request $request){
        Log::info("id_ap: ".$request->id_ap." mano_obra_id: ".$request->id_mano_obra." cantidad: ".$request->cantidad);
        $relacion = AP_ManoObra::where('ap_id',$request->id_ap)->where('mano_obra_id',$request->id_mano_obra)->first();
        if(!empty($relacion)){
            $relacion->duracion = $request->duracion/1000;
            $relacion->save();

            return response()->json(["status"=>TRUE,"data"=>$relacion]);
        }else{
            return response()->json(["status"=>500]);
        }
    }

    public function mano_obra_save(Request $request)
    {
        AP_ManoObra::create([
            'ap_id' => $request->ap_id,
            'mano_obra_id' => $request->mo_id,
            'duracion' => $request->duracion/1000,
        ]);

        return response()->json(['status'=>TRUE]);
    }

    public function mano_obra_destroy($ap_id, $mano_obra_id)
    {
        try{
            AP_ManoObra::where('ap_id', $ap_id)->where('mano_obra_id', $mano_obra_id)->delete();

            $actividad_preestablecida = ActividadPreestablecida::findOrFail($ap_id);
            $all_relaciones = AP_ManoObra::where('ap_id',$ap_id)->get();
            $all_relaciones->duracion_total = 0;

            foreach ($all_relaciones as $una_relacion) {
                //duracion_individual
                $una_relacion->duracion_individual = $una_relacion->mano_obra->duracion/3600;
                //duracion * cantidad
                $una_relacion->duracion_subtotal = $una_relacion->mano_obra->duracion*$una_relacion->cantidad/3600;

                $subtot_horas = floor($una_relacion->duracion_subtotal);
                $subtotal_minutos = ($una_relacion->duracion_subtotal-$subtot_horas)*60;

                /* Ej.:
                    0,47hs. (28,2 minutos)
                    3,31hs. (3 horas y 18,6 minutos)
                    2hs. (2 horas) */

                if(fmod($subtotal_minutos, 1) !== 0.00) {
                    $una_relacion->subtotal_minutos = number_format($subtotal_minutos, 2);
                } else {
                    $una_relacion->subtotal_minutos = $subtotal_minutos;
                }
                $una_relacion->subtotal_horas = $subtot_horas;

                //formatos
                if(fmod($una_relacion->duracion_individual, 1) !== 0.00) {
                    $una_relacion->duracion_individual = number_format($una_relacion->duracion_individual, 2);
                }

                if(fmod($una_relacion->duracion_subtotal, 1) !== 0.00) {
                    $una_relacion->duracion_subtotal = number_format($una_relacion->duracion_subtotal, 2);
                }

                //total duracion de actividad preestablecida
                $all_relaciones->duracion_total = $all_relaciones->duracion_total + $una_relacion->duracion_subtotal;
            }

            $all_relaciones->tot_horas = floor($all_relaciones->duracion_total);
            $all_relaciones->total_minutos = ($all_relaciones->duracion_total-$all_relaciones->tot_horas)*60;

            if(fmod($all_relaciones->duracion_total, 1) !== 0.00) {
                $all_relaciones->duracion_total = number_format($all_relaciones->duracion_total, 2);
            }

            if(fmod($all_relaciones->total_minutos, 1) !== 0.00) {
                $all_relaciones->total_minutos = number_format($all_relaciones->total_minutos, 2);
            }

            return Redirect::back()->with('message','Operation Successful !');
        } catch(\Exception $e) {

            return Redirect::back()->with('message','Operation Successful !');
        }
    }

    public function materiales($id){
        $actividad_preestablecida = ActividadPreestablecida::find($id);
        $relaciones = AP_Material::where('ap_id',$id)->get();

        foreach ($relaciones as $rel){
            $ids_materiales[] = $rel->material_id;
        }


        if(!empty($ids_materiales)){
            $materiales = Material::whereNotIn('id',$ids_materiales)->get();
        }else{
            $materiales = Material::all();
        }

        return view('actividades_preestablecidas.materiales',[
            'actividad_preestablecida' => $actividad_preestablecida,
            'relaciones' => $relaciones,
            'materiales' => $materiales,
        ]);
    }

    public function material_destroy($id)
    {
        try{
            AP_Material::where('id', $id)->delete();

            return Redirect::back()->with('message','Operation Successful !');
        } catch(\Exception $e) {

            return Redirect::back()->with('message','Operation Successful !');
        }
    }

    public function materiales_update_amount(Request $request){
        Log::info($request);
        $relacion = AP_Material::where('ap_id',$request->id_ap)->where('material_id',$request->id_material)->first();

        if(!empty($relacion)){
            $relacion->cantidad = $request->cantidad;
            $relacion->save();

            return response()->json(["status"=>TRUE]);
        }else{
            return response()->json(["status"=>500]);
        }
    }

    public function materiales_store(Request $request)
    {
        Log::info($request);
        AP_Material::create([
            'ap_id'=>$request->ap_id,
            'material_id'=>$request->mat_id,
            'cantidad' => $request->cantidad,
        ]);

        return response()->json(['status'=>TRUE]);
    }
}
