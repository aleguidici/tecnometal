<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Presupuesto</title>
        <link rel="stylesheet" href='{{ URL::asset('/css/bootstrap.css')}}'>
        <style>
            @page {
                margin-top: 4.5cm;
                margin-bottom: 3.3cm;
            }
            .page-break {
                page-break-after: always;
            }
            .text-right {
                text-align: right;
            }
            .w-full {
                width: 100%;
            }
            .small-width {
                width: 15%;
            }
            header {
                position: fixed;
                top: -4cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
                z-index: 1000;
            }
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 0cm;
                z-index: 1000;
            }
            footer .page:after {
                content: counter(page, upper-roman);
            }
            .table_resumen{
                border: 1px solid rgb(185, 185, 185);
                table-layout:fixed;
            }
            .table_text_resumen{
                font-size: 11px;
            }
            #watermark {
                position: fixed;
                opacity: 0.5;
                z-index:  -1000;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="row">
                <div class="col-4" style="float:left;">
                    <img src="{{ URL::to('/') }}/img/logos_imp/tecnometal_logo.jpg" width="300px" height="110px">
                </div>
                <div class="col-8 text-left" style="float:right;">
                    <div style="line-height: 1.6;">
                        @if ($presupuesto->estado_presupuesto_id != 5)
                            <h3 style="font-size: 20px; margin-top: 0%;">Cotización Nro. {{substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)}}</h3>
                        @else
                            <h3 style="font-size: 20px; margin-top: 0%;">Borrador</h3>
                        @endif
                    </div>
                    <div style="line-height: 0.5;">
                        <p style="font-size: 12px">González Silvia Ester</p>
                        <p style="font-size: 12px">Av. Francisco de Haro 5143</p>
                        <p style="font-size: 12px">CUIT: 27-20338944-8</p>
                        <p style="font-size: 12px">Tel: 03764-4450591</p>
                        <p style="font-size: 12px">Email: tecnica@tecnometalmisiones.com.ar</p>
                    </div>
                </div>
            </div>
            <hr style="border: 1px solid #71c7d6">
        </header>
        <!--./Header-->
        <!--Footer-->
        <footer>
            <hr style="border: 1px solid #71c7d6; margin-bottom: 0%;">
            <p style="font-size: 12px; margin-top:0%;">Distribuidor y Servicio Oficial</p>
            <div class="row">
                <table style="width: 100%; table-layout:fixed;">
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 14%"><img src="{{ URL::to('/') }}/img/logos_imp/logo_lowara.png" width="100px" height="30px"> </td>
                        <td style="width: 5%"></td>
                        <td style="width: 14%"><img src="{{ URL::to('/') }}/img/logos_imp/logo_vogel.jpg" width="100px" height="30px"> </td>
                        <td style="width: 5%"></td>
                        <td style="width: 14%"><img src="{{ URL::to('/') }}/img/logos_imp/logo_flygt.jpeg" width="100px" height="30px"> </td>
                        <td style="width: 5%"></td>
                        <td style="width: 14%"><img src="{{ URL::to('/') }}/img/logos_imp/logo_saer.png" width="100px" height="30px"></td>
                        <td style="width: 5%"></td>
                        <td style="width: 14%"><img src="{{ URL::to('/') }}/img/logos_imp/hilti.svg" width="100px" height="30px"></td>
                        <td style="width: 5%"></td>
                        <!-- <td style="width: 15%"><img src="{{ URL::to('/') }}/img/logos_imp/iso-9001.jpg" width="120px" height="60px"></td> -->
                    </tr>
                </table>
            </div>
        </footer>
        <!--/Footer-->

        <!-- NOT FIXED ZONE-->

        <!--Encabezado cliente-->
        @switch($presupuesto->estado_presupuesto_id)
            @case(5)
                <div id="watermark">
                    <img src="{{ URL::to('/') }}/img/logos_imp/BORRADOR.png" height="100%" width="100%" />
                </div>
                @break
            @case(2)
                <div id="watermark">
                    <img src="{{ URL::to('/') }}/img/logos_imp/VENCIDO.png" height="100%" width="100%" />
                </div>
                @break
            @case(4)
                <div id="watermark">
                    <img src="{{ URL::to('/') }}/img/logos_imp/ANULADO.png" height="100%" width="100%" />
                </div>
                @break
        @endswitch

        <div class="row" >
            <table style="width:100%; font-size: 12px">
                <tr>
                    <td style="width: 70%; vertical-align: top;"><div class="text-left">Sres.: {{$presupuesto->persona->name}} @if ($presupuesto->contacto) {{'(Solicitante: '.$presupuesto->contacto->name.')'}} @endif</div></td>
                    <td style="width: 30%; vertical-align: top;"><div class="text-right"> <em>Posadas, {{$fecha_ini}}</em> </div></td>
                </tr>
                <tr>
                    <td style="width: 50%; vertical-align: top;"><div class="text-left">Ref.: {{$presupuesto->referencia}}</div></td>
                    <td style="width: 50%; vertical-align: top;"><div class="text-right">Validez de Oferta: {{$validez}} @if ($validez > 1) Dias. @else Dia. @endif</div></td>
                </tr>
                <tr>
                    <td style="width: 50%; vertical-align: top;"><div class="text-left">Obra: {{$presupuesto->obra}}</div></td>
                </tr>
            </table>
        </div>

        <!--Tables zone-->
        <main>
            @if ($separadas)
                <!--Materiales-->
                @if ($hasMats)
                    <h4>Detalle de Materiales</h4>
                    <table style="table-layout: 100%; border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr style="background-color: rgb(185, 185, 185)">
                                <th class="table_text_resumen" style="width: 7%; text-align: center;">Item</th>
                                <th class="table_text_resumen" style="width: 8%; text-align: center;">Cantidad</th>
                                <th class="table_text_resumen" style="width: 51%; text-align: center;">Descripción</th>
                                <th class="table_text_resumen" style="width: 17%; text-align: center;">Precio Unitario {{$presupuesto->moneda_materiales->signo}}</th>
                                <th class="table_text_resumen" style="width: 17%; text-align: center;">Subtotal {{$presupuesto->moneda_materiales->signo}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Items Materiales-->
                            @php ($num = 0);
                            @foreach($presupuesto->items as $item)
                                @if ($item->total_material > 0)
                                    <tr>
                                        <td class="table_resumen table_text_resumen" style="text-align: center;">{{$num = $num+1}}</td>
                                        <td class="table_resumen table_text_resumen" style="text-align: center;">{{$item->cantidad}}</td>
                                        <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">@isset($item->descripcion_materiales){{$item->descripcion_materiales}}@else{{$item->descripcion}}@endisset</td>
                                        <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$item->total_material, 2, '.', '')}}</td>
                                        <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$item->total_material*$item->cantidad, 2, '.', '')}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <!--Gastos e impuestos Materiales-->
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="table_resumen table_text_resumen"  style="padding-right:5px; padding-left:3px">Subtotal {{$presupuesto->moneda_materiales->signo}}</td>
                                <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mat,2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">IVA {{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}} %</td>
                                <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[2]->percentage,2,'.','')}}</th>
                            </tr>
                            <tr>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Per. IIBB {{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}} %</td>
                                <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[1]->percentage,2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Per. Mun. {{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}} %</td>
                                <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[0]->percentage,2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td style="border-top: hidden;"></td>
                                <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Total {{$presupuesto->moneda_materiales->signo}}</td>
                                <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$tot_mat_cliente,2,'.','')}}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                <br>
                <!--Manos De Obra-->
                @if ($hasMO)
                    <h4>Detalle de Mano de Obra</h4>
                    <table style="table-layout: fixed;border-collapse: collapse;width: 100%;">
                        <tr style="background-color: rgb(185, 185, 185)">
                            <th class="table_text_resumen" style="width: 7%; text-align: center;">Item</td>
                            <th class="table_text_resumen" style="width: 8%; text-align: center;">Cantidad</td>
                            <th class="table_text_resumen" style="width: 51%; text-align: center;">Descripción</td>
                            <th class="table_text_resumen" style="width: 17%; text-align: center;">Precio Unitario {{$presupuesto->moneda_manos_obra->signo}}</td>
                            <th class="table_text_resumen" style="width: 17%; text-align: center;">Subtotal {{$presupuesto->moneda_manos_obra->signo}}</td>
                        </tr>
                        <!--Items Manos de Obra-->
                        @php ($num = 0);
                        @foreach ($presupuesto->items as $item)
                            @if ($item->total_mo > 0)
                                <tr>
                                    <td class="table_resumen table_text_resumen" style="text-align: center;">{{$num = $num+1}}</td>
                                    <td class="table_resumen table_text_resumen" style="text-align: center;">{{$item->cantidad}}</td>
                                    <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">@isset($item->descipcion_manos_obra){{$item->descipcion_manos_obra}}@else{{$item->descripcion}}@endisset</th>
                                    <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)($item->total_mo ),2,'.','')}}</td>
                                    <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$item->total_mo*$item->cantidad,2,'.','')}}</td>
                                </tr>
                            @endif
                        @endforeach
                        <!--Gastos e impuestos Manos de Obra-->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Subtotal {{$presupuesto->moneda_manos_obra->signo}}</td>
                            <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{$subtot_mo}}</td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">IVA {{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}} %</td>
                            <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[2]->percentage,2,'.','')}}</td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Per. IIBB {{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}} %</td>
                            <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[1]->percentage,2,'.','')}}</td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Per. Mun. {{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}} %</td>
                            <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[0]->percentage,2,'.','')}}</td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen" style="padding-right:5px; padding-left:3px">Total {{$presupuesto->moneda_manos_obra->signo}}</td>
                            <td class="table_resumen text-right table_text_resumen" style="padding-right:5px; padding-left:3px">{{number_format((float)$tot_mo_cliente,2,'.','')}}</td>
                        </tr>
                    </table>
                @endif
            @else
                <!--Manos De Obra-->
                @if ($hasItems)
                    <h4>Detalle de Items</h4>
                    <table style="table-layout: fixed;border-collapse: collapse;width: 100%;">
                        <tr style="background-color: rgb(185, 185, 185)">
                            <th class="table_text_resumen" style="width: 7%; text-align: center;">Item</td>
                            <th class="table_text_resumen" style="width: 8%; text-align: center;">Cantidad</td>
                            <th class="table_text_resumen" style="width: 51%; text-align: center;">Descripción</td>
                            <th class="table_text_resumen" style="width: 17%; text-align: center;">Precio Unitario {{$presupuesto->moneda_manos_obra->signo}}</td>
                            <th class="table_text_resumen" style="width: 17%; text-align: center;">Subtotal {{$presupuesto->moneda_manos_obra->signo}}</td>
                        </tr>
                        <!--Items Manos de Obra-->
                        @foreach ($presupuesto->items as $item)
                            <tr>
                                <td class="table_resumen table_text_resumen" style="text-align: center;">{{$loop->index + 1}}</td>
                                <td class="table_resumen table_text_resumen" style="text-align: center;">{{$item->cantidad}}</td>
                                <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">{{$item->descripcion}}</p></th>
                                <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)($item->total_item ),2,'.','')}}</p></td>
                                <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)$item->total_item*$item->cantidad,2,'.','')}}</p></td>
                            </tr>
                        @endforeach
                        <!--Gastos e impuestos Manos de Obra-->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">Subtotal {{$presupuesto->moneda_manos_obra->signo}}</p></td>
                            <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{$subtot_mo + $subtot_mat}}</p></td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">IVA {{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}} %</p></td>
                            <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)($subtot_mo+$subtot_mat) * $presupuesto->presupuesto_gastos_preest[2]->percentage,2,'.','')}}</p></td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">Per. IIBB {{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}} %</p></td>
                            <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)($subtot_mo * $presupuesto->presupuesto_gastos_preest[1]->percentage + $subtot_mat * $presupuesto->presupuesto_gastos_preest[1]->percentage),2,'.','')}}</p></td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">Per. Mun. {{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}} %</p></td>
                            <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)($subtot_mo+$subtot_mat) * $presupuesto->presupuesto_gastos_preest[0]->percentage,2,'.','')}}</p></td>
                        </tr>
                        <tr>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td style="border-top: hidden;"></td>
                            <td class="table_resumen table_text_resumen"><p style="margin-left:3px;">Total {{$presupuesto->moneda_manos_obra->signo}}</p></td>
                            <td class="table_resumen text-right table_text_resumen"><p style="margin-right:3px;">{{number_format((float)($tot_mo_cliente+$tot_mat_cliente),2,'.','')}}</p></td>
                        </tr>
                    </table>
                @endif
            @endif

            <br>

            <!--OBSERVACIONES-->
            @if ($presupuesto->observaciones)
                <table style="width: 100%">
                    <tr>
                        <th class="table_resumen table_text_resumen" style="background-color: rgb(185, 185, 185);"><p style="margin-left: 3px;"><b>Observaciones</b></p></th>
                    </tr>
                    <tr>
                        <td class="table_resumen table_text_resumen"><p style="margin-left: 3px;">{!!$presupuesto->observaciones!!}</p></td>
                    </tr>
                </table>
            @endif
        </main>
    </body>
</html>
