<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PresupuestoRequest;


use App\Presupuesto;
use App\Material;
use App\ActividadPreestablecida;
use App\AP_ManoObra;
use App\AP_Material;
use App\AP_Item;
use App\GastoPreest;
use App\Item;
use App\Presupuesto_Gasto;
use App\Item_Gasto;
use App\Persona;
use App\Contacto;
use App\EstadoPresupuesto;
use App\Moneda;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class PresupuestoController extends Controller
{
    public function index()
    {
        $this->vencer_presupuestos();
        $presupuestos = Presupuesto::where('eliminado',false)->orderBy('created_at', 'DESC')->get();

        $borradores = [];
        $pres_cerrados = [];
        foreach ($presupuestos as $presupuesto){
            $inicio = Carbon::parse($presupuesto->fecha);
            $vencimiento = Carbon::parse($presupuesto->vencimiento)->addDays(1);
            
            $actual = Carbon::now()->subHours(3);
            if ($actual->lt($vencimiento)){
                if($actual->lt($inicio)){
                    $presupuesto->proporcion_diff = 0;
                }else{
                    LOG::info("Hoy: ".$actual." - Vencimiento: ".$vencimiento." - Dif: ".$vencimiento->diffInMinutes($actual));
                    LOG::info("Hoy: ".$actual." - Inicio: ".$inicio." - Dif: ".$vencimiento->diffInMinutes($inicio));
                    $presupuesto->proporcion_diff = (1-($vencimiento->diffInMinutes($actual) / $vencimiento->diffInMinutes($inicio)))*100;
                }
            }else{
                $presupuesto->proporcion_diff = 100;
            }
            if ($presupuesto->estado_presupuesto->descripcion == "Borrador"){
                $borradores[] = $presupuesto;
            }else{
                $pres_cerrados[] = $presupuesto;
            }
        }

        return view('presupuestos.index', [
            'borradores' => $borradores,
            'pres_cerrados' => $pres_cerrados,
        ]);
    }

    public function create()
    {
        /* $ultimo_presupuesto = Presupuesto::all()->last();
        $last_cotization_id = isset($ultimo_presupuesto) ? $this->create_new_id($ultimo_presupuesto->id) : $this->create_new_id(-1); */
        $ultimo_borrador = Presupuesto::where('estado_presupuesto_id','5')->orderBy('id', 'DESC')->first();
        $last_cotization_id = isset($ultimo_borrador) ? $this->create_new_id_borrador($ultimo_borrador->id) : $this->create_new_id_borrador(-1);
        $tipos_moneda = Moneda::all();

        return view('presupuestos.create',[
            'last_id' => $last_cotization_id,
            'clientes' => Persona::where('tipo_persona_id', '=', 1)->orderBy('name', 'DESC')->get(),
            'tipos_moneda' => $tipos_moneda,
        ]);
    }

    public function create_new_id_borrador($borrador_id)
    {
        if ($borrador_id != -1){
            $new_id_borrador = $borrador_id + 1;
        } else {
            $new_id_borrador = 1; //Cambiar de acuerdo al comienzo que se desee.
        }

        return $new_id_borrador;
    }

    public function create_new_id($pres_id)
    {
        $current_year = Carbon::now()->format('y');
        $new_id = $current_year * 100000;
        if ($pres_id != -1){
            $last_year = substr($pres_id,0,2);
            if ($last_year == $current_year){
                $last_number = intval(substr($pres_id,2));
                $new_id = $new_id + $last_number + 1;
            }
        }else{
            $new_id+=300; //Cambiar de acuerdo al comienzo que se desee.
        }
        return $new_id;
    }

    public function store(Request $request)
    {
        $estado_pres_id = EstadoPresupuesto::where('descripcion','Borrador')->value('id');
        $presupuesto = Presupuesto::create([
            'id'=>$request->presupuesto_id,
            'fecha'=>new Carbon(),
            'vencimiento'=>new Carbon(),
            'referencia'=>$request->referencia,
            'obra'=>$request->obra,
            'observaciones'=>$request->observaciones,
            'persona_id'=>$request->cliente_id,
            'contacto_id'=>$request->contacto_id,
            'estado_presupuesto_id'=>$estado_pres_id,
            'moneda_material'=>$request->moneda_material,
            'moneda_mano_obra'=>$request->moneda_mano_obra,
            'user_id'=>auth()->user()->id,
        ]);

        $impuestos = GastoPreest::all();

        //0
        Presupuesto_Gasto::create([
            'percentage' => $impuestos[1]->valor,
            'es_monto'=>false,
            'descripcion' => 'Perc. Mun.',
            'presupuesto_id' => $request->presupuesto_id,
        ]);
        //1
        Presupuesto_Gasto::create([
            'percentage' => 0.0331,
            'es_monto'=>false,
            'descripcion' => 'Perc. IIBB',
            'presupuesto_id' => $request->presupuesto_id,
        ]);
        //2
        Presupuesto_Gasto::create([
            'percentage' => $impuestos[6]->valor,
            'es_monto'=>false,
            'descripcion' => 'I.V.A.',
            'presupuesto_id' => $request->presupuesto_id,
        ]);

        return redirect()->route('presupuestos.items', ['id' => $request->presupuesto_id]);
    }

    public function update_impuestos(Request $request){

        $gastos_del_item = Item_Gasto::where("item_id",$request->item_id)->get();

        //Modificacion de ingresos brutos
        $gastos_del_item[0]->percentage = $request->iibb/100;
        $gastos_del_item[0]->save();

        //Modificacion de gastos generales
        $gastos_del_item[1]->percentage = $request->gastos_grales/100;
        $gastos_del_item[1]->save();
        //Modificacion de flete materiales
        $gastos_del_item[2]->monto = $request->flete;
        $gastos_del_item[2]->save();

        //Modificacion de flete reventa
        Log::info($request->flete_rev);
        $gastos_del_item[7]->monto = $request->flete_rev;
        $gastos_del_item[7]->save();

        //Modificacion de beneficio materiales
        if ($request->perc_mat){
            $gastos_del_item[3]->percentage = $request->beneficio_mat/100;
            $gastos_del_item[3]->es_monto = false;
        }else{
            $gastos_del_item[3]->monto = $request->beneficio_mat;
            $gastos_del_item[3]->es_monto = true;
        }
        $gastos_del_item[3]->save();

        //Modificacion de beneficio materiales reventa
        if ($request->perc_rev){
            $gastos_del_item[8]->percentage = $request->beneficio_rev/100;
            $gastos_del_item[8]->es_monto = false;
        }else{
            $gastos_del_item[8]->monto = $request->beneficio_rev;
            $gastos_del_item[8]->es_monto = true;
        }
        $gastos_del_item[8]->save();

        //Modificacion de beneficio mano de obra
        if ($request->perc_mo){
            $gastos_del_item[4]->percentage = $request->beneficio_mo/100;
            $gastos_del_item[4]->es_monto = false;
        }else{
            $gastos_del_item[4]->monto = $request->beneficio_mo;
            $gastos_del_item[4]->es_monto = true;
        }
        $gastos_del_item[4]->save();

        //modificacion de impuestos a la ganancia
        $gastos_del_item[5]->percentage = $request->ganancia/100;
        $gastos_del_item[5]->save();

        //modificacion de impuesto al cheque
        $gastos_del_item[6]->percentage = $request->cheque/100;
        $gastos_del_item[6]->save();



        $this->actualizar_items_materiales($request->item_id);

        return response()->json(['status'=>TRUE]);
    }

    public function update_impuestos_cliente(Request $request){

        $gastos_del_pres = Presupuesto_Gasto::where("presupuesto_id",$request->pres_id)->get();

        $gastos_del_pres[0]->percentage = $request->perc_mun_cliente/100;
        $gastos_del_pres[0]->save();

        $gastos_del_pres[1]->percentage = $request->iibb_cliente/100;
        $gastos_del_pres[1]->save();

        $gastos_del_pres[2]->percentage = $request->iva_cliente/100;
        $gastos_del_pres[2]->save();


        return response()->json(['status'=>TRUE]);
    }

    public function actualizar_items_materiales($item_id){
        $item = Item::find($item_id);

        $gastos_del_item = Item_Gasto::where("item_id",$item_id)->get();
        $iibb = $gastos_del_item[0]->percentage;
        $gg = $gastos_del_item[1]->percentage;

        foreach($item->items_materiales as $item_mat){
            $item_mat->iibb = $iibb;
            $item_mat->gastos_generales=$gg;
            $item_mat->save();
        }
    }

    public function confirmar_presupuesto (Request $request){
        $ESTADO_ACTIVO = 1;

        $presupuesto = Presupuesto::find($request->id_presupuesto);
        //$ultimo_presupuesto = Presupuesto::all()->last();
        $ultimo_presupuesto = Presupuesto::where('estado_presupuesto_id','!=','5')->orderBy('id', 'DESC')->first();

        $presupuesto->fecha = Carbon::createFromFormat('d/m/Y',$request->fechaEmisionPres);
        $presupuesto->vencimiento =Carbon::createFromFormat('d/m/Y',$request->fechaVenc);
        $presupuesto->estado_presupuesto_id = $ESTADO_ACTIVO;
        //$presupuesto->id = $this->create_new_id($ultimo_presupuesto->id);
        $presupuesto->id = isset($ultimo_presupuesto) ? $this->create_new_id($ultimo_presupuesto->id) : $this->create_new_id(-1);;
        $presupuesto->save();

        return response()->json(['status'=>TRUE,'url'=>route('presupuestos.edit',$presupuesto->id)]);
    }

    public function anular_presupuesto(Request $request){
        $ESTADO_ANULADO = 4;

        $presupuesto = Presupuesto::find($request->id_presupuesto);
        $presupuesto->estado_presupuesto_id = $ESTADO_ANULADO;
        $presupuesto->save();

        return response()->json(['status'=>TRUE]);
    }

    public function booleanTablas_presupuesto(Request $request){
        $presupuesto = Presupuesto::find($request->id_presupuesto);

        Log::info($presupuesto->tablas_unificadas);
        if ($presupuesto->tablas_unificadas == "0"){
            $presupuesto->tablas_unificadas = 1;
        } else {
            $presupuesto->tablas_unificadas = 0;
        }
            
        $presupuesto->save();

        return response()->json(['status'=>TRUE]);
    }

    public function rechazar_presupuesto(Request $request){
        $ESTADO_RECHAZADO = 6;

        $presupuesto = Presupuesto::find($request->id_presupuesto);
        $presupuesto->estado_presupuesto_id = $ESTADO_RECHAZADO;
        $presupuesto->rechazado = $request->rechazado;
        $presupuesto->save();

        return response()->json(['status'=>TRUE]);
    }

    public function aprobar_presupuesto(Request $request){
        $ESTADO_APROBADO = 3;

        $presupuesto = Presupuesto::find($request->id_presupuesto);
        $presupuesto->estado_presupuesto_id = $ESTADO_APROBADO;
        $presupuesto->save();

        return response()->json(['status'=>TRUE]);
    }

    public function vencer_presupuestos(){
        $ESTADO_VENCIDO = 2;
        $ESTADO_ACTIVO = 1;

        $presupuestos = Presupuesto::where('estado_presupuesto_id',$ESTADO_ACTIVO)
        ->where('vencimiento', '<' ,Carbon::now()->format('Y-m-d'))->get();

        foreach($presupuestos as $presupuesto){
            if ($presupuesto->estado_presupuesto_id == 1){
                $presupuesto->estado_presupuesto_id = $ESTADO_VENCIDO;
                $presupuesto->save();
            }
        }
    }

    public function show_items($id)
    {
        $presupuesto = Presupuesto::find($id);

        //Items Materiales Subtotal
        $subtot_mat = 0.00;
        $subtot_mo = 0.00;

        foreach ($presupuesto->items as $item){
            $ap_items = $item->AP_Items;
            $item->subtot_item_material = 0.00;
            $item->subtot_item_reventa = 0.00;

            foreach($item->items_materiales as $item_mat){
                //Calculo de totales
                $subtotal_unitario_mat = number_format((float)$item_mat->cantidad,2,'.','') * $item_mat->precio_unitario;

                if (!$item_mat->reventa){
                    $item->subtot_item_material += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb + $item_mat->gastos_generales));
                }else{
                    $item->subtot_item_reventa += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb + $item_mat->gastos_generales));
                }


                if (count($ap_items)>0 and !$item_mat->reventa){
                    foreach ($ap_items as $ap_item){
                        foreach ($ap_item->actividad_preestablecida->AP_materiales as $mat){
                            if ($mat->material->id == $item_mat->material->id){
                                $subtotal_unitario_mat = number_format((float)$mat->cantidad * $ap_item->cantidad,2,'.','') * $item_mat->precio_unitario;
                                $item->subtot_item_material += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb +$item_mat->gastos_generales));
                                break;
                            }
                        }
                    }
                }
            }
            $item->total_material = $this->get_monto_total_materiales($item->subtot_item_material, $item);
            $item->total_material += $this->get_monto_total_materiales_reventa($item->subtot_item_reventa,$item);

            $subtot_mat += $item->total_material*$item->cantidad;

            //Mano de Obra

            $item->subtot_item_mo = 0.00;

            foreach($item->items_manos_obra as $item_mo){
                $monto_mano_obra = number_format((float)$item_mo->cantidad/3600,2,'.','') * $item_mo->precio_unitario;
                $item->subtot_item_mo += $monto_mano_obra;
                $item->subtot_item_mo += $monto_mano_obra * $item->gastos[1]->percentage;

                if (count($ap_items)>0){
                    foreach ($ap_items as $ap_item){
                        foreach ($ap_item->actividad_preestablecida->AP_manos_obra as $mo){
                            if ($mo->mano_obra->id == $item_mo->mano_obra->id){
                                $monto_mano_obra = number_format((float)$mo->duracion/3600 * $ap_item->cantidad,2,'.','') * $item_mo->precio_unitario;
                                $item->subtot_item_mo += $monto_mano_obra;
                                $item->subtot_item_mo += $monto_mano_obra * $item->gastos[1]->percentage;
                                break;
                            }
                        }
                    }
                }
            }

            $item->total_mo = $this->get_monto_total_mano_obra($item->subtot_item_mo,$item);
            $subtot_mo += $item->total_mo * $item->cantidad;
        }

        $total_cliente_mat = $subtot_mat + ($subtot_mat * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

        $total_cliente_mo = $subtot_mo + ($subtot_mo * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

        return view('presupuestos.items',['presupuesto'=>$presupuesto,'subtot_mat'=>$subtot_mat,'subtot_mo'=>$subtot_mo,'tot_mat_cliente'=>$total_cliente_mat,'tot_mo_cliente'=>$total_cliente_mo]);
    }

    public function get_monto_total_materiales($subtot_mat, $item){
        $coef = ($subtot_mat > 0) ? 1:0;
        $flete = $item->gastos[2]->monto * $coef;
        if ($item->gastos[3]->es_monto){
            $beneficio_tot_mat = $item->gastos[3]->monto * $coef;
        }else{
            $beneficio_tot_mat = $item->gastos[3]->percentage * ($subtot_mat + $flete);
        }
        $total_imp_ganancias_mat = $beneficio_tot_mat * $item->gastos[5]->percentage;
        $subtotal_con_impuestos_mat = $subtot_mat + $beneficio_tot_mat + $total_imp_ganancias_mat + $flete;
        $imp_al_cheque_mat = $subtotal_con_impuestos_mat * $item->gastos[6]->percentage;
        $total_material = $subtotal_con_impuestos_mat + $imp_al_cheque_mat;
        $total_material = number_format((float) $total_material,2,'.','');

        return $total_material;
    }

    public function get_monto_total_materiales_reventa($subtot_mat, $item){
        $coef = ($subtot_mat > 0) ? 1:0;
        $flete = $item->gastos[7]->monto * $coef;
        if ($item->gastos[8]->es_monto){
            $beneficio_tot_mat = $item->gastos[8]->monto * $coef;
        }else{
            $beneficio_tot_mat = $item->gastos[8]->percentage * ($subtot_mat + $flete);
        }
        $total_imp_ganancias_mat = $beneficio_tot_mat * $item->gastos[5]->percentage;
        $subtotal_con_impuestos_mat = $subtot_mat + $beneficio_tot_mat + $total_imp_ganancias_mat + $flete;
        $imp_al_cheque_mat = $subtotal_con_impuestos_mat * $item->gastos[6]->percentage;
        $total_material = $subtotal_con_impuestos_mat + $imp_al_cheque_mat;
        $total_material = number_format((float) $total_material,2,'.','');

        return $total_material;
    }

    public function get_monto_total_mano_obra($subtot_mo,$item){
        $coef = ($subtot_mo > 0) ? 1:0;
        if ($item->gastos[4]->es_monto){
            $beneficio_tot_mo = $item->gastos[4]->monto * $coef;
        }else{
            $beneficio_tot_mo = $item->gastos[4]->percentage * $subtot_mo;
        }
        $imp_gan_mo = $beneficio_tot_mo * $item->gastos[5]->percentage;
        $subtotal_con_impuestos_mo = $subtot_mo + $beneficio_tot_mo + $imp_gan_mo;
        $imp_cheque_mo = $subtotal_con_impuestos_mo * $item->gastos[6]->percentage;
        $total_mo = $subtotal_con_impuestos_mo + $imp_cheque_mo;
        $total_mo = number_format((float)$total_mo,2,'.','');

        return $total_mo;
    }

    public function create_item(Request $request)
    {
        $desc_mat = isset($request->desc_mat) ? $request->desc_mat : null;
        $desc_mo = isset($request->desc_mo) ? $request->desc_mo : null;
        $item = Item::create([
            'descripcion'=>$request->desc_item,
            'cantidad'=>$request->cantidad,
            'descripcion_materiales'=> $desc_mat,
            'descipcion_manos_obra'=>$desc_mo,
            'presupuesto_id'=>$request->id_pres,
        ]);

        $impuestos = GastoPreest::all();

        //Crear Impuestos Item

        //0
        Item_Gasto::create([
            'percentage' => $impuestos[0]->valor,
            'es_monto'=>false,
            'descripcion' => 'Ingresos Brutos',
            'item_id' => $item->id,
        ]);
        //1
        Item_Gasto::create([
            'percentage' => $impuestos[2]->valor,
            'es_monto'=>false,
            'descripcion' => 'Gastos Generales',
            'item_id' => $item->id,
        ]);
        //2
        Item_Gasto::create([
            'monto' => 0.00,
            'es_monto'=>true,
            'descripcion' => 'Flete Materiales',
            'item_id' => $item->id,
        ]);
        //3
        Item_Gasto::create([
            'percentage' => $impuestos[3]->valor,
            'es_monto'=>false,
            'descripcion' => 'Beneficios Materiales',
            'item_id' => $item->id,
        ]);
        //4
        Item_Gasto::create([
            'percentage' => $impuestos[3]->valor,
            'es_monto'=>false,
            'descripcion' => 'Beneficios Mano de Obra',
            'item_id' => $item->id,
        ]);
        //5
        Item_Gasto::create([
            'percentage' => $impuestos[4]->valor,
            'es_monto'=>false,
            'descripcion' => 'Impuesto a la Ganancia',
            'item_id' => $item->id,
        ]);
        //6
        Item_Gasto::create([
            'percentage' => $impuestos[5]->valor,
            'es_monto'=>false,
            'descripcion' => 'Impuesto al Cheque',
            'item_id' => $item->id,
        ]);
        //7
        Item_Gasto::create([
            'monto' => 0.00,
            'es_monto'=>true,
            'descripcion' => 'Flete Materiales Reventa',
            'item_id' => $item->id,
        ]);
        //8
        Item_Gasto::create([
            'percentage' => $impuestos[3]->valor,
            'es_monto'=>false,
            'descripcion' => 'Beneficios Materiales Reventa',
            'item_id' => $item->id,
        ]);

        return response()->json(['status'=>TRUE, 'data'=>$item]);
    }

    public function edit_item(Request $request){
        $desc_mat = isset($request->desc_mat) ? $request->desc_mat : null;
        $desc_mo = isset($request->desc_mo) ? $request->desc_mo : null;
        $item = Item::where('id',$request->id_item)->first();

        $item->descripcion = $request->desc_item;
        $item->cantidad = $request->cantidad;
        $item->descripcion_materiales= $desc_mat;
        $item->descipcion_manos_obra=$desc_mo;

        $item->save();

        return response()->json(['status'=>TRUE]);
    }

    public function edit($id)
    {
        $presupuesto = Presupuesto::find($id);
        $tipos_moneda = Moneda::all();

        return view('presupuestos.edit',[
            'presupuesto' => $presupuesto,
            'clientes' => Persona::where('tipo_persona_id', '=', 1)->orderBy('name', 'DESC')->get(),
            'contactos' => Contacto::where('persona_id', '=', $presupuesto['persona_id'])->orderBy('id', 'ASC')->get(),
            'tipos_moneda' => $tipos_moneda,
        ]);
    }

    public function reactivar_presupuesto(Request $request){

        $presupuesto = Presupuesto::find($request->id_presupuesto);

        //$ultimo_presupuesto = Presupuesto::all()->last();
        //$last_cotization_id = isset($ultimo_presupuesto) ? $this->create_new_id($ultimo_presupuesto->id) : $this->create_new_id(-1);

        $ultimo_borrador = Presupuesto::where('estado_presupuesto_id','5')->orderBy('id', 'DESC')->first();
        $last_cotization_id = isset($ultimo_borrador) ? $this->create_new_id_borrador($ultimo_borrador->id) : $this->create_new_id_borrador(-1);

        $estado_pres_id = EstadoPresupuesto::where('descripcion','Borrador')->value('id');
        $pres_nuevo = Presupuesto::create([
            'id'=>$last_cotization_id,
            'fecha'=>new Carbon(),
            'vencimiento'=>new Carbon(),
            'referencia'=>$this->remake_referene($presupuesto->referencia,substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)),
            'obra'=>$presupuesto->obra,
            'observaciones'=>$presupuesto->observaciones,
            'persona_id'=>$presupuesto->persona_id,
            'estado_presupuesto_id'=>$estado_pres_id,
            'moneda_material'=>$presupuesto->moneda_material,
            'moneda_mano_obra'=>$presupuesto->moneda_mano_obra,
            'user_id'=>auth()->user()->id,
        ]);

        $impuestos = GastoPreest::all();

        //0
        Presupuesto_Gasto::create([
            'percentage' => $presupuesto->presupuesto_gastos_preest[0]->percentage,
            'es_monto'=>false,
            'descripcion' => 'Perc. Mun.',
            'presupuesto_id' => $last_cotization_id,
        ]);
        //1
        Presupuesto_Gasto::create([
            'percentage' =>  $presupuesto->presupuesto_gastos_preest[1]->percentage,
            'es_monto'=>false,
            'descripcion' => 'Perc. IIBB',
            'presupuesto_id' => $last_cotization_id,
        ]);
        //2
        Presupuesto_Gasto::create([
            'percentage' =>  $presupuesto->presupuesto_gastos_preest[2]->percentage,
            'es_monto'=>false,
            'descripcion' => 'I.V.A.',
            'presupuesto_id' => $last_cotization_id,
        ]);


        //create Items
        foreach ($presupuesto->items as $item){
            $new_item = $item->replicate()->fill([
                'presupuesto_id'=> $last_cotization_id,
            ]);
            $new_item->save();

            //create gastos items
            foreach($item->gastos as $gasto){
                $new_gasto = $gasto->replicate()->fill([
                    'item_id'=>$new_item->id,
                ]);
                $new_gasto->save();
            }

            //Crate items materiales
            foreach($item->items_materiales as $mat){
                $new_item_mat = $mat->replicate()->fill([
                    'item_id'=>$new_item->id,
                ]);
                $new_item_mat->save();
            }
            //create items mano obra
            foreach($item->items_manos_obra as $mo){
                $new_item_mo = $mo->replicate()->fill([
                    'item_id'=>$new_item->id,
                ]);
                $new_item_mo->save();
            }
            //create AP items
            foreach($item->AP_items as $ap_item){
                $new_ap_item = $ap_item->replicate()->fill([
                    'item_id'=>$new_item->id,
                ]);
                $new_ap_item->save();
            }

        }

        return response()->json(['status'=>TRUE]);
    }

    public function remake_referene($ref, $nro_presupuesto){
        if (preg_match("/\-\sRef\.\sPresupuesto\s\d{5}\/\d{2}/",$ref)>0){
            $new_ref = preg_replace("/\-\sRef\.\sPresupuesto\s\d{5}\/\d{2}/","- Ref. Presupuesto ".$nro_presupuesto,$ref);
        }else{
            $new_ref = $ref." - Ref. Presupuesto ".$nro_presupuesto;
        }
        return $new_ref;
    }

    public function update(Request $request, $id)
    {
        $presupuesto = Presupuesto::find($id);

        //Calculo dias de diferencia
        $diff_fechas = Carbon::parse($presupuesto->vencimiento)->diffInDays(Carbon::parse($presupuesto->fecha));

        $presupuesto->fecha=Carbon::now();
        $presupuesto->vencimiento=Carbon::now();
        $presupuesto->referencia=$request->referencia;
        $presupuesto->obra=$request->obra;
        $presupuesto->observaciones=$request->observaciones;
        $presupuesto->persona_id=$request->cliente_id;
        $presupuesto->contacto_id=$request->contacto_id;
        $presupuesto->moneda_material=$request->moneda_material;
        $presupuesto->moneda_mano_obra=$request->moneda_mano_obra;
        $presupuesto->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        //TODO: Eliminacion de presupuesto con todos sus items y detalles
        $presupuesto = Presupuesto::findOrFail($id);

        foreach ($presupuesto->items as $item){
            $item->delete();
        }

        if ($presupuesto->estado_presupuesto_id == 5) {
            $presupuesto->delete();
        } else {
            $presupuesto->eliminado = true;
            $presupuesto->estado_presupuesto_id = 4;
            $presupuesto->save();
        }

        return redirect()->route('presupuestos.index');
    }

    public function delete_item($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->back();
    }
}
