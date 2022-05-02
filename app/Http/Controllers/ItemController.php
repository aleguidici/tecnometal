<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presupuesto;
use App\Material;
use App\ManoObra;
use App\ActividadPreestablecida;
use App\AP_ManoObra;
use App\AP_Material;
use App\AP_Item;
use App\GastoPreest;
use App\Item;
use App\Item_Material;
use App\Item_ManoObra;
use App\Presupuesto_Gasto;
use App\Item_Gasto;
use App\Persona;
use App\TipoPersona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index()
    {
        $presupuestos = Presupuesto::orderBy('created_at', 'DESC')->get();

        $proporsion_diff = [];
        foreach ($presupuestos as $presupuesto){
            $inicio = Carbon::parse($presupuesto->fecha);
            $vencimiento = Carbon::parse($presupuesto->vencimiento);
            $actual = Carbon::now();
            if ($actual->lt($vencimiento)){
                if($actual->lt($inicio)){
                    $proporsion_diff[] = 0;
                }else{
                    $proporsion_diff[] = (1-($vencimiento->diffInDays($actual) / $vencimiento->diffInDays($inicio)))*100;
                }
            }else{
                $proporsion_diff[] = 100;
            }
        }

        return view('presupuestos.index', [
            'presupuestos' => $presupuestos,
            'proporciones' => $proporsion_diff
        ]);
    }

    public function create($id)
    {
        //estandares disponibles
        $actividades = ActividadPreestablecida::get();
        $actividades_disponibles = array();

        foreach ($actividades as $una_activ) {
            if (!$una_activ->pendiente){
                //CONTEO DE MANOS DE OBRA
                $AP_manos_obra = AP_ManoObra::where('ap_id',$una_activ->id)->get();
                $duracion_total = 0;
                foreach ($AP_manos_obra as $una_relacion) {
                    $duracion_total = $duracion_total + $una_relacion->duracion;
                }
                $una_activ->tiempo_total = $duracion_total/3600;

                $total_horas = floor($una_activ->tiempo_total);
                $total_minutos = ($una_activ->tiempo_total-$total_horas)*60;

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

                array_push($actividades_disponibles, $una_activ);
            }
        }

        //OBTENER Presupuesto e Item
        $item = Item::find($id);
        $presupuesto = Presupuesto::find($item->presupuesto_id);
        $id_tipo_persona = TipoPersona::where('name','Proveedor')->value('id');
        $proveedores = Persona::where('tipo_persona_id',$id_tipo_persona)->get();
        $IIBB = GastoPreest::where('descripcion', 'Per. Ingresos Brutos')->get();
        $GastosGenerales = GastoPreest::where('descripcion', 'Gastos Generales')->get();

        //Cargar actividades preestrablecidas del item
        foreach($item->items_materiales as $item_mat){
            $item_mat->cant_estandar = 0.00;
            foreach($item->AP_items as $ap_items){
                foreach($ap_items->actividad_preestablecida->AP_materiales as $mat){
                    if ($mat->material->id == $item_mat->material->id){
                        $item_mat->cant_estandar += $mat->cantidad * $ap_items->cantidad;
                        break;
                    }
                }
            }
        }
        foreach($item->items_manos_obra as $item_mo){
            $item_mo->cant_estandar = 0.00;
            foreach($item->AP_items as $ap_items){
                foreach($ap_items->actividad_preestablecida->AP_manos_obra as $mo){
                    if ($mo->mano_obra->id == $item_mo->mano_obra->id){
                        $item_mo->cant_estandar += $mo->duracion * $ap_items->cantidad;
                        break;
                    }
                }
            }
        }

        return view('presupuestos.create_item_detalles',[
            'materiales' => Material::with('unidad')->get(),
            'manos_obra' => ManoObra::all(),
            'item' => $item,
            'presupuesto' => $presupuesto,
            'actividades_disponibles'=>$actividades_disponibles,
            'proveedores' => $proveedores,
            'IIBB' => $IIBB,
            'gastosGrales' => $GastosGenerales
        ]);
    }

    public function store_material(Request $request)
    {
        $gastos_del_item = Item_Gasto::where("item_id",$request->item)->get();
        $iibb = $gastos_del_item[0]->percentage;
        $gg = $gastos_del_item[1]->percentage;

        $item = Item_Material::create([
            'cantidad' => $request->cant,
            'precio_unitario' => $request->pu,
            'reventa' => $request->reventa,
            'marca' => null,
            'codigo' => null,
            'item_id' => $request->item,
            'material_id' => $request->mat_id,
            'moneda_id' => $request->moneda_id,
            'iibb'=>$iibb,//Default ingresos brutos
            'gastos_generales'=>$gg,
            'persona_id' => null,
        ]);

        $item->material; //Esto añade materiales al item
        $item->material->unidad;

        return response()->json(['status'=>TRUE, 'item'=>$item]);
    }


    public function store_mano_obra(Request $request)
    {
        $item = Item_ManoObra::create([
            'cantidad'=>$request->cant,
            'precio_unitario'=>$request->pu,
            'item_id'=>$request->item_id,
            'mano_obra_id'=>$request->mano_obra_id,
            'moneda_id'=>$request->moneda_id,
        ]);

        $item->mano_obra;

        return response()->json(['status'=>TRUE,'item'=>$item]);
    }

    public function update_material(Request $request){
        $item_material = Item_Material::find($request->id_item_mat);

        $item_material->cantidad = $request->cant;
        $item_material->precio_unitario = $request->pu;
        $item_material->marca = $request->marca;
        $item_material->codigo = $request->codigo;
        $item_material->item_id = $request->item;
        $item_material->material_id = $request->mat_id;
        $item_material->moneda_id = $request->moneda_id;

        $item_material->save();

        $item_material->material;
        $item_material->material->unidad;

        return response()->json(['status'=>TRUE,'item'=>$item_material]);
    }

    //ACTIVIDAD PREESTABLECIDA ITEMS
    public function store_ap_item(Request $request){
        $ap_item = AP_Item::create([
            'ap_id'=>$request->ap_id,
            'item_id'=>$request->item_id,
            'cantidad'=>$request->cantidad,
        ]);

        //Carga del objeto a enviar a js
        $ap_item->item;
        $ap_item->actividad_preestablecida;
        $ap_item->actividad_preestablecida->AP_materiales;
        foreach($ap_item->actividad_preestablecida->AP_materiales as $mat){
            $mat->material;
        }
        $ap_item->actividad_preestablecida->AP_manos_obra;
        foreach($ap_item->actividad_preestablecida->AP_manos_obra as $mo){
            $mo->mano_obra;
        }

        return response()->json(['status'=>TRUE,'ap_item'=>$ap_item]);
    }

    public function update_amount_ap_item(Request $request)
    {
        $ap_item = AP_Item::find($request->ap_item_id);

        $ap_item->cantidad = $request->cantidad;
        $ap_item->save();

        //Carga del objeto a enviar a js
        $ap_item->item;
        $ap_item->actividad_preestablecida;
        $ap_item->actividad_preestablecida->AP_materiales;
        foreach($ap_item->actividad_preestablecida->AP_materiales as $mat){
            $mat->material;
        }
        $ap_item->actividad_preestablecida->AP_manos_obra;
        foreach($ap_item->actividad_preestablecida->AP_manos_obra as $mo){
            $mo->mano_obra;
        }

        return response()->json(['status'=>TRUE,'ap_item'=>$ap_item]);
    }

    public function delete_ap_item(Request $request){
        $ap_item = AP_Item::findOrFail($request->id_st);
        $items_mat = Item_Material::where("item_id",$ap_item->item_id)->get();
        $items_mo = Item_ManoObra::where("item_id",$ap_item->item_id)->get();

        $existen_en_otros_mat = $this->get_ids_array_mat($ap_item->item_id);
        $existen_en_otros_mo = $this->get_ids_array_mo($ap_item->item_id);

        foreach ($ap_item->actividad_preestablecida->AP_materiales as $ap_mat){
            foreach ($items_mat as $item_mat){
                if ($ap_mat->material_id == $item_mat->material_id and !in_array($item_mat->material_id,$existen_en_otros_mat)){
                    if($item_mat->cantidad == 0){
                        $item_mat->delete();
                        break;
                    }
                }
            }
        }

        foreach ($ap_item->actividad_preestablecida->AP_manos_obra as $ap_mo){
            foreach ($items_mo as $item_mo){
                if ($ap_mo->mano_obra_id == $item_mo->mano_obra_id and !in_array($item_mo->mano_obra_id,$existen_en_otros_mo)){
                    if($item_mo->cantidad == 0){
                        $item_mo->delete();
                        break;
                    }
                }
            }
        }

        $ap_item->delete();

        return response()->json(['status'=>TRUE]);
    }

    public function get_ids_array_mat($item_id){
        $aps_item = AP_Item::where('item_id',$item_id)->get();

        $ids_nuevos = [];
        $ids_duplicados = [];

        foreach ($aps_item as $ap_it){
            foreach ($ap_it->actividad_preestablecida->AP_materiales as $ap_mat){
                if (in_array($ap_mat->material_id,$ids_nuevos)){
                    if (!in_array($ap_mat->material_id,$ids_duplicados)){
                        $ids_duplicados[] = $ap_mat->material_id;
                    }
                }else{
                    $ids_nuevos[]=$ap_mat->material_id;
                }
            }
        }
        return $ids_duplicados;
    }

    public function get_ids_array_mo($item_id){
        $aps_item = AP_Item::where('item_id',$item_id)->get();

        $ids_nuevos = [];
        $ids_duplicados = [];

        foreach ($aps_item as $ap_it){
            foreach ($ap_it->actividad_preestablecida->AP_manos_obra as $ap_mo){
                if (in_array($ap_mo->mano_obra_id,$ids_nuevos)){
                    if (!in_array($ap_mo->mano_obra_id,$ids_duplicados)){
                        $ids_duplicados[] = $ap_mo->mano_obra_id;
                    }
                }else{
                    $ids_nuevos[]=$ap_mo->mano_obra_id;
                }
            }
        }
        return $ids_duplicados;
    }


    //ITEMS MATERIALES

    public function update_amount_materiales(Request $request)
    {
        $item_material = Item_Material::find($request->id_item_mat);
        $item = $item_material->item;

        //Cargar actividades preestrablecidas del item
        $cant_estandar = $this->get_relationships_apmat($item,$item_material->material->id,$item_material->reventa);

        if ($request->cantidad>0 or $cant_estandar>0){
            $item_material->cantidad = $request->cantidad;
            $item_material->save();
        }else{
            $item_material->delete();
        }

        return response()->json(['status'=>TRUE]);
    }

    public function get_relationships_apmat($item,$id_mat,$reventa){
        $cant_estandar = 0;
        if(!$reventa){
            foreach($item->AP_items as $ap_items){
                foreach($ap_items->actividad_preestablecida->AP_materiales as $mat){
                    if ($mat->material->id == $id_mat){
                        $cant_estandar += 1;
                        break;
                    }
                }
            }
        }
        return $cant_estandar;
    }


    public function update_materiales_pu (Request $request)
    {
        $item_material = Item_Material::find($request->id_item_mat);

        if ($request->pu != $item_material->precio_unitario){
            $item_material->precio_unitario = $request->pu;
            $item_material->save();
        }

        return response()->json(['status'=>TRUE]);
    }

    public function update_materiales_marca_codigo(Request $request){

        if ($request->marca=="null" or !isset($request->marca)){
            $marca = $request->marca;
        }else{
            $marca = null;
        }

        if ($request->codigo=="null" or !isset($request->codigo)){
            $codigo = $request->codigo;
        }else{
            $codigo = null;
        }

        $item_material = Item_Material::find($request->id_item_mat);

        $item_material->marca = $request->marca;
        $item_material->codigo = $request->codigo;
        $item_material->save();

        return response()->json(['status'=>TRUE]);
    }

    public function update_impuestos(Request $request){
        $item_material = Item_Material::find($request->id_item_mat);

        $item_material->persona_id = $request->prov;
        $item_material->iibb = $request->iibb/100;
        $item_material->gastos_generales = $request->gastos_generales/100;
        $item_material->presupuesto_proveedor = $request->ref_prov;
        $item_material->save();

        return response()->json(['status'=>TRUE]);
    }

    public function delete_item_material(Request $request)
    {
        $item_mat = Item_Material::findOrFail($request->id_item_mat);
        $item = $item_mat->item;

        $cant_estandar = $this->get_relationships_apmat($item,$item_mat->material->id,$item_mat->reventa);

        if ($cant_estandar==0){
            $item_mat->delete();
            $status_res=0; //without error
        }else{
            $status_res = 1; // An error has happened.
        }

        return response()->json(['status'=>TRUE,'status_result'=>$status_res]);
    }

    // ITEMS MANOS OBRA

    public function update_amount_mano_obra(Request $request){
        $item_mo = Item_ManoObra::find($request->id_item_mano_obra);
        $item = $item_mo->item;

        $cant_estandar = $this->get_relationships_apmo($item,$item_mo->mano_obra->id);

        if ($request->cantidad>0 or $cant_estandar>0){
            $item_mo->cantidad = $request->cantidad;
            $item_mo->save();
        }else{
            $item_mo->delete();
        }

        return response()->json(['status'=>TRUE]);
    }

    public function get_relationships_apmo($item,$id_mo){
        $cant_estandar = 0;
        foreach($item->AP_items as $ap_items){
            foreach($ap_items->actividad_preestablecida->AP_manos_obra as $mo){
                if ($mo->mano_obra->id == $id_mo){
                    $cant_estandar += 1;
                    break;
                }
            }
        }
        return $cant_estandar;
    }

    public function update_mano_obra_pu(Request $request)
    {
        $item = Item_ManoObra::find($request->id_item_mano_obra);

        if($item->precio_unitario != $request->pu){
            $item->precio_unitario = $request->pu;
            $item->save();
        }

        return response()->json(['status'=>TRUE]);
    }

    public function delete_item_mano_obra(Request $request)
    {
        $item_mo = Item_ManoObra::findOrFail($request->id_item_mano_obra);
        $item = $item_mo->item;

        $cant_estandar = $this->get_relationships_apmo($item,$item_mo->mano_obra->id);

        if ($cant_estandar==0){
            $item_mo->delete();
            $status_res=0;
        }else{
            $status_res=1;
        }

        return response()->json(['status'=>TRUE,'status_result'=>$status_res]);
    }

    public function destroy($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->delete();
        return redirect()->route('proveedores.index');
    }

    public function get_datos_estandar(Request $request){
        $estandar_materiales = AP_Material::where('ap_id',$request->id)->with(['material','material.unidad'])->get();

        $estandar_manos_obra = AP_ManoObra::where('ap_id',$request->id)->with('mano_obra')->get();

        return response()->json(["status"=>TRUE,"data"=>['materiales'=>$estandar_materiales, 'manos_obra'=>$estandar_manos_obra]]);
    }
}
