<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presupuesto;
use Carbon\Carbon;
use PDF;

use Illuminate\Support\Facades\Log;

class PresupuestoImprimible extends Controller
{


    public function presupuesto_cliente($id_pres){

        //Carga Objeto Presupuesto
        $presupuesto = Presupuesto::find($id_pres);
        $presupuesto->items;
        $presupuesto->persona;

        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $fecha_inicio = Carbon::parse($presupuesto->fecha);
        $mes_inicio = $meses[$fecha_inicio->format('n')-1];
        $fecha_ini_imp = $fecha_inicio->format('d') .' de '. $mes_inicio .' de '. $fecha_inicio->format('Y');

        $validez = Carbon::parse($presupuesto->vencimiento)->diffInDays(Carbon::parse($presupuesto->fecha));

        //Items Materiales Subtotal
        $subtot_mat = 0.00;
        $hasMats = false;
        $subtot_mo = 0.00;
        $subtot_item = 0.00;
        $hasMO = false;
        $hasItems = false;

        
        $separadas = false;
        Log::info($presupuesto->moneda_material);
        Log::info($presupuesto->moneda_mano_obra);
        if ($presupuesto->moneda_material != $presupuesto->moneda_mano_obra) {
            $separadas = true;
        } else {
            if ($presupuesto->tablas_unificadas == 0) {
                $separadas = true;
                Log::info("Monedas iguales y tablas separadas");
            }
        };
        Log::info("Separadas: ".$separadas);
        Log::info("----");

        foreach ($presupuesto->items as $item){
            $hasItems = true;
            $ap_items = $item->AP_Items;
            $item->subtot_item_material = 0.00;
            $item->subtot_item_reventa = 0.00;

            foreach($item->items_materiales as $item_mat){
                $hasMats = true;
                //Calculo de totales
                $subtotal_unitario_mat = number_format((float)$item_mat->cantidad,2,'.','') * $item_mat->precio_unitario;

                if (!$item_mat->reventa){
                    $item->subtot_item_material += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb + $item_mat->gastos_generales));
                }else{
                    $item->subtot_item_reventa += $subtotal_unitario_mat + ($subtotal_unitario_mat * ($item_mat->iibb + $item_mat->gastos_generales));
                    $hasMats = true;
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
                $hasMO = true;
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
            
            $item->total_item = $item->total_mo + $item->total_material;
            $subtot_item += $item->total_item * $item->cantidad;
        }

        $total_cliente_mat = $subtot_mat + ($subtot_mat * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

        $total_cliente_mo = $subtot_mo + ($subtot_mo * ($presupuesto->presupuesto_gastos_preest[2]->percentage + $presupuesto->presupuesto_gastos_preest[1]->percentage + $presupuesto->presupuesto_gastos_preest[0]->percentage));

        $pdf = PDF::loadView('imprimibles/presupuesto_cliente',['presupuesto'=>$presupuesto,'fecha_ini'=>$fecha_ini_imp,'validez'=>$validez,'subtot_mat'=>$subtot_mat,'subtot_mo'=>$subtot_mo,'tot_mat_cliente'=>$total_cliente_mat,'tot_mo_cliente'=>$total_cliente_mo,'hasMats'=>$hasMats,'hasMO'=>$hasMO,'hasItems'=>$hasItems ,'separadas'=>$separadas]);

        $pdf->setPaper('a4');

        $name=substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5) . '.pdf';
        return $pdf->stream($name);
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

}
