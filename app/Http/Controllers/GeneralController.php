<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Presupuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    
    public function index()
    {
        $presupuestos_activos = Presupuesto::where('estado_presupuesto_id', '=', 1)->count();
        $presupuestos_por_mes = [[]];

        $firstDate = Carbon::now()->subYear()->firstOfMonth()->format('Y-m-d');
        $lastDate = Carbon::now()->endOfMonth()->format('Y-m-d');

        for($i=0; $i<=11; $i++){
            $presupuestos_por_mes[0][$i] = 0;
            $presupuestos_por_mes[1][$i] = 0;
            $presupuestos_por_mes[2][$i] = 0;
            $presupuestos_por_mes[3][$i] = 0;
        }

        

        $presupuestos_ultimos12meses = Presupuesto::where('fecha', '>=', $firstDate)->where('fecha', '<=', $lastDate)->get();
        
        foreach ($presupuestos_ultimos12meses as $presupuesto) {
            $aprobados_pesos = 0.00;
            $aprobados_dolares = 0.00;
            $desaprobados_pesos = 0.00;
            $desaprobados_dolares = 0.00;
            $fecha_presupuesto = Carbon::createFromFormat('Y-m-d', $presupuesto->fecha);
            $posicionArray = $fecha_presupuesto->diffInMonths($firstDate)-1;
            
            //Items Materiales Subtotal
            $subtot_mat = 0.00;
            $subtot_mo = 0.00;

            foreach ($presupuesto->items as $item){
                $ap_items = $item->AP_Items;
                $item->subtot_item_material = 0.00;

                foreach($item->items_materiales as $item_mat){
                    //Calculo de totales
                    $subtotal_unitario_mat = $item_mat->cantidad * $item_mat->precio_unitario;

                    $item->subtot_item_material += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb + $item_mat->gastos_generales));
                    
                    if (count($ap_items)>0 and !$item_mat->reventa){
                        foreach ($ap_items as $ap_item){
                            foreach ($ap_item->actividad_preestablecida->AP_materiales as $mat){
                                if ($mat->material->id == $item_mat->material->id){
                                    $subtotal_unitario_mat = $mat->cantidad * $ap_item->cantidad * $item_mat->precio_unitario;
                                    $item->subtot_item_material += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb +$item_mat->gastos_generales));
                                    break;
                                }
                            }
                        }
                    }
                }
                $item->total_material = $this->get_monto_total_materiales($item->subtot_item_material, $item);

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
                                    $monto_mano_obra = (number_format((float)$mo->duracion/3600,2,'.','')) * $ap_item->cantidad * $item_mo->precio_unitario;
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

            $subtot_mat = $subtot_mat + ($subtot_mat * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

            $subtot_mo = $subtot_mo + ($subtot_mo * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

            
            //---------------------------
            if ($presupuesto->estado_presupuesto_id == 3) {
                // aprobados_pesos y aprobados_dolares
                switch ($presupuesto->moneda_material){
                    case 1: //Pesos Argentinos
                        $aprobados_pesos = $aprobados_pesos + $subtot_mat;
                        break;
                    case 2: //Dólares
                        $aprobados_dolares = $aprobados_dolares + $subtot_mat;
                        break;
                    default:
                        break;
                };
                switch ($presupuesto->moneda_mano_obra){
                    case 1: //Pesos Argentinos
                        $aprobados_pesos = $aprobados_pesos + $subtot_mo;
                        break;
                    case 2: //Dólares
                        $aprobados_dolares = $aprobados_dolares + $subtot_mo;
                        break;
                    default:
                        break;
                };
            } else {
                // desaprobados_pesos y desaprobados_dolares
                switch ($presupuesto->moneda_material){
                    case 1: //Pesos Argentinos
                        $desaprobados_pesos = $desaprobados_pesos + $subtot_mat;
                        break;
                    case 2: //Dólares
                        $desaprobados_dolares = $desaprobados_dolares + $subtot_mat;
                        break;
                    default:
                        break;
                };
                switch ($presupuesto->moneda_mano_obra){
                    case 1: //Pesos Argentinos
                        $desaprobados_pesos = $desaprobados_pesos + $subtot_mo;
                        break;
                    case 2: //Dólares
                        $desaprobados_dolares = $desaprobados_dolares + $subtot_mo;
                        break;
                    default:
                        break;
                };
            };
            
            $presupuestos_por_mes[0][$posicionArray] = round((floatval ( $presupuestos_por_mes[0][$posicionArray]) + $aprobados_pesos),2);
            $presupuestos_por_mes[1][$posicionArray] = round((floatval ( $presupuestos_por_mes[1][$posicionArray]) + $aprobados_dolares),2);
            $presupuestos_por_mes[2][$posicionArray] = round((floatval ( $presupuestos_por_mes[2][$posicionArray]) + $desaprobados_pesos),2);
            $presupuestos_por_mes[3][$posicionArray] = round((floatval ( $presupuestos_por_mes[3][$posicionArray]) + $desaprobados_dolares),2);
            
        }

        return view('home',['presupuestos_activos'=>$presupuestos_activos, 'presupuestos_por_mes'=>$presupuestos_por_mes]);
    }

    public function get_monto_total_materiales($subtot_mat, $item){
        if ($item->gastos[3]->es_monto){
            $beneficio_tot_mat = $item->gastos[3]->monto;
        }else{
            $beneficio_tot_mat = $item->gastos[3]->percentage * ($subtot_mat + $item->gastos[2]->monto);
        }
        $total_imp_ganancias_mat = $beneficio_tot_mat * $item->gastos[5]->percentage;
        $subtotal_con_impuestos_mat = $subtot_mat + $beneficio_tot_mat + $total_imp_ganancias_mat + $item->gastos[2]->monto;
        $imp_al_cheque_mat = $subtotal_con_impuestos_mat * $item->gastos[6]->percentage;
        $total_material = $subtotal_con_impuestos_mat + $imp_al_cheque_mat;
        $total_material = number_format((float) $total_material,2,'.','');

        return $total_material;
    }

    public function get_monto_total_mano_obra($subtot_mo,$item){
        if ($item->gastos[4]->es_monto){
            $beneficio_tot_mo = $item->gastos[4]->monto;
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
