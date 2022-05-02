@extends('layout')

@section('title')
Inicio
@endsection

@section('import_css')
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
<link rel="stylesheet" href="{{ URL::asset('/js/chart.js/dist/Chart.min.css')}}">

<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
<script src="{{ URL::asset('/js/chart.js/dist/Chart.min.js')}}"></script>
@endsection

@section('content-header')
    <h1 class="display-1">
        Inicio
    </h1>
    <br>
    
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$presupuestos_activos}}</h3>

                    <p><b>Presupuestos Activos</b><br> (Pendientes de aprobación) </p>
                </div>
                <div class="icon">
                    <i class="fa fa-exclamation"></i>
                </div>
                <a href="{{route('presupuestos.index')}}" class="small-box-footer">Ver presupuestos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6" hidden>
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="fa fa-google-plus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
       
        <div class="col-lg-3 col-xs-6" hidden>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="fa fa-google-plus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
                
        <div class="col-lg-3 col-xs-6" hidden>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="fa fa-google-plus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Presupuestos emitidos en los últimos 12 meses</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="chartPresupuestos" width="507" height="150"></canvas>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    <script>
        var fecha = new Date();
        var mesActual = fecha.getMonth()+1;
        
        var añoActual = fecha.getFullYear();
        var añoAnterior = añoActual-1;

        switch (mesActual) {
            case 0: //Enero
                var labels = ['Enero'+' '+añoAnterior, 'Febrero'+' '+añoAnterior, 'Marzo'+' '+añoAnterior, 'Abril'+' '+añoAnterior, 'Mayo'+' '+añoAnterior, 'Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior];
                break;
            case 1: //Febrero
                var labels = ['Febrero'+' '+añoAnterior, 'Marzo'+' '+añoAnterior, 'Abril'+' '+añoAnterior, 'Mayo'+' '+añoAnterior, 'Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual];
                break;
            case 2: //Marzo
                var labels = ['Marzo'+' '+añoAnterior, 'Abril'+' '+añoAnterior, 'Mayo'+' '+añoAnterior, 'Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual];
                break;
            case 3: //Abril
                var labels = ['Abril'+' '+añoAnterior, 'Mayo'+' '+añoAnterior, 'Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual];
                break;
            case 4: //Mayo
                var labels = ['Mayo'+' '+añoAnterior, 'Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual];
                break;
            case 5: //Junio
                var labels = ['Junio'+' '+añoAnterior, 'Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual];
                break;
            case 6: //Julio
                var labels = ['Julio'+' '+añoAnterior, 'Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual];
                break;
            case 7: //Agosto
                var labels = ['Agosto'+' '+añoAnterior, 'Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual, 'Julio'+' '+añoActual];
                break;
            case 8: //Septiembre
                var labels = ['Septiembre'+' '+añoAnterior, 'Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual, 'Julio'+' '+añoActual, 'Agosto'+' '+añoActual];
                break;
            case 9: //Octubre
                var labels = ['Octubre'+' '+añoAnterior, 'Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual, 'Julio'+' '+añoActual, 'Agosto'+' '+añoActual, 'Septiembre'+' '+añoActual];
                break;
            case 10: //Noviembre
                var labels = ['Noviembre'+' '+añoAnterior, 'Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual, 'Julio'+' '+añoActual, 'Agosto'+' '+añoActual, 'Septiembre'+' '+añoActual, 'Octubre'+' '+añoActual];
                break;
            default: //Diciembre
                var labels = ['Diciembre'+' '+añoAnterior, 'Enero'+' '+añoActual, 'Febrero'+' '+añoActual, 'Marzo'+' '+añoActual, 'Abril'+' '+añoActual, 'Mayo'+' '+añoActual, 'Junio'+' '+añoActual, 'Julio'+' '+añoActual, 'Agosto'+' '+añoActual, 'Septiembre'+' '+añoActual, 'Octubre'+' '+añoActual, 'Noviembre'+' '+añoActual];
                break;
        };
        
        var presupuestos_por_mes = @json($presupuestos_por_mes);
        console.log(presupuestos_por_mes);

        var miGrafico = document.getElementById('chartPresupuestos').getContext('2d');
        console.log(typeof (presupuestos_por_mes[3][8]));
        var chartPresupuestos = new Chart(miGrafico, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    barPercentage: 0.9,
                    label: 'Presupuestos no aprobados, en Dólares',
                    data: presupuestos_por_mes[3],
                    
                    backgroundColor: [
                        'rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)'
                    ],
                    borderColor: [
                        'rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)','rgba(96, 160, 59, 1)'
                    ],
                    stack: 1, //dolares
                    borderWidth: 2 //ancho del borde de la barra
                },{
                    barPercentage: 0.9,
                    label: 'Presupuestos aprobados, en Dólares',
                    data: presupuestos_por_mes[1],
                    backgroundColor: [
                        'rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)'
                    ],
                    borderColor: [
                        'rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)','rgba(156, 235, 136, 1)'
                    ],
                    stack: 1, //dolares
                    borderWidth: 2 //ancho del borde de la barra
                }, {
                    barPercentage: 0.9,
                    label: 'Presupuestos no aprobados, en Pesos',
                    data: presupuestos_por_mes[2],
                    backgroundColor: [
                        'rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)'
                    ],
                    borderColor: [
                        'rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)','rgba(48, 156, 186, 1)'
                    ],
                    stack: 2,
                    borderWidth: 2 //ancho del borde de la barra
                }, {
                    barPercentage: 0.9,
                    label: 'Presupuestos aprobados, en Pesos',
                    data: presupuestos_por_mes[0],
                    backgroundColor: [
                        'rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)'
                    ],
                    borderColor: [
                        'rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)','rgba(124, 207, 232, 1)'
                    ],
                    stack: 2,
                    borderWidth: 2 //ancho del borde de la barra
                }]
            },
            options: {
                scales: {
                    xAxes: [{ stacked: true}],
                    yAxes: [{ stacked: true, ticks: { beginAtZero: true }}],
                }/* ,title: {
                    display: true,
                    text: ''
                } */,
            }
        });
    </script>
@endsection

@section('content')

@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

@endsection

@section('content-header')
    <h1 class="display-1">Presupuestos</h1>
@endsection