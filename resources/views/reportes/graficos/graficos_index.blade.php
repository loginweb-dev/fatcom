@extends('voyager::master')
@section('page_title', 'Gráficos')

@if(auth()->user()->hasPermission('browse_reportesgraficos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-pie-graph"></i> Gráficos
        </h1>
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                @include('voyager::alerts')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="form" method="post" action="{{route("graficos_generar")}}">
                                            @csrf
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a class="tab-tipo" data-toggle="tab" data-value="mensual" href="#mensual">Mensual</a></li>
                                                <li><a class="tab-tipo" data-toggle="tab" data-value="anual" href="#anual">Anual</a></li>
                                                <li><a class="tab-tipo" data-toggle="tab" data-value="seguimiento" href="#seguimiento">Seguimiento</a></li>
                                            </ul>    
                                            <div class="tab-content">
                                                <div id="mensual" class="tab-pane fade in active">
                                                    <div class="form-group col-md-6">
                                                        <div class="input-group">
                                                            <select name="mes" class="form-control" class="form-control" id="">
                                                                <option value="1">Enero</option>
                                                                <option value="2">Febrero</option>
                                                                <option value="3">Marzo</option>
                                                                <option value="4">Abril</option>
                                                                <option value="5">Mayo</option>
                                                                <option value="6">Junio</option>
                                                                <option value="7">Julio</option>
                                                                <option value="8">Agosto</option>
                                                                <option value="9">Septiembre</option>
                                                                <option value="10">Octubre</option>
                                                                <option value="11">Noviembre</option>
                                                                <option value="12">Diciembre</option>
                                                            </select>
                                                            <span class="input-group-btn">
                                                                <input type="number" min="2019" step="1" style="width:80px" name="anio_mes" value="{{date('Y')}}" class="form-control" required>
                                                                <button class="btn btn-primary" type="submit" style="margin:0px;padding:9px">
                                                                    <span class="hidden-xs hidden-sm">Generar</span> <span class="voyager-bulb" aria-hidden="true"></span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="anual" class="tab-pane fade">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <div class="input-group">
                                                                <input type="number" min="2019" step="1" name="anio" value="{{date('Y')}}" class="form-control">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary" type="submit" style="margin:0px;padding:9px">
                                                                        <span class="hidden-xs hidden-sm">Generar</span> <span class="voyager-bulb" aria-hidden="true"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="seguimiento" class="tab-pane fade">
                                                    <div class="form-group col-md-6">
                                                        <div class="input-group">
                                                            <select name="mes" class="form-control" class="form-control" id="">
                                                                <option value="2">Preparación</option>
                                                                <option value="4">Entrega</option>
                                                            </select>
                                                            <span class="input-group-btn">
                                                                <select name="mes" class="form-control" class="form-control" style="width:200px" id="">
                                                                    <option value="Todas">Todas</option>
                                                                    @foreach ($sucursales as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </span>
                                                            <span class="input-group-btn">
                                                                <input type="date" style="width:200px" name="inicio" class="form-control" required>
                                                                <button class="btn btn-primary" type="submit" style="margin:0px;padding:9px">
                                                                    <span class="hidden-xs hidden-sm">Generar</span> <span class="voyager-bulb" aria-hidden="true"></span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="tipo" id="input-tipo" value="mensual">
                                            </div>
                                        </form>
                                        <div class="col-md-12">
                                            <input type="radio" class="radio-tipo_grafico" name="tipo" checked value="line" id="radio_line"> <label for="radio_line">Lineas</label>
                                             &nbsp;&nbsp; 
                                            <input type="radio" class="radio-tipo_grafico" name="tipo" value="bar" id="radio_bar"> <label for="radio_bar">Barras</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="list-data"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
        <style>

        </style>
    @stop
    @section('javascript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                // definir tipo de gráfico
                var chart_type = 'line';

                const nombre_dias = ["dom", "lun", "mar", "mie", "jue", "vie", "sab"];
                const nombre_meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                // Cambiar duración de oferta
                $('.tab-tipo').click(function(){
                    let value = $(this).data('value');
                    switch (value) {
                        case 'mensual':
                            $('#form input[name="anio_mes"]').attr('required', true)
                            $('#form input[name="anio"]').removeAttr('required')
                            break;
                        case 'anual':
                        $('#form input[name="anio"]').attr('required', true)
                            $('#form input[name="anio_mes"]').removeAttr('required')
                            break;
                        default:
                            break;
                    }
                    $('#input-tipo').val(value)
                    $('#list-data').html('<canvas id="canvas"></canvas>');
                });

                // Enviar formulario
                $('#form').on('submit', function(e){
                    // e.preventDefault();
                    // enviar_form();
                });

                // Cambiar tipo de gráfico
                $('.radio-tipo_grafico').click(function(){
                    chart_type = $(this).val();
                    enviar_form();
                });

                function enviar_form(){
                    let datos = $('#form').serialize();
                    $.ajax({
                        url: '{{route("graficos_generar")}}',
                        data: datos,
                        type: 'post',
                        success: function(data){
                            switch ($('#input-tipo').val()) {
                                case 'mensual':
                                    generar_mensual(data);
                                    break;
                                case 'anual':
                                    generar_anual(data);
                                    break;
                            
                                default:
                                    break;
                            }
                        },error: () => console.log('error')
                    });
                }

                function generar_mensual(data){
                    var montos = [];
                    var dias = [];

                    let mes_actual = '';
                    let anio_actual = '';

                    data.map((value) => {
                        montos.push(value.monto);
                        var dato = new Date(value.fecha);
                        dias.push(nombre_dias[dato.getUTCDay()]+' '+value.dia);
                        mes_actual = nombre_meses[dato.getMonth()];
                        anio_actual = dato.getUTCFullYear();
                    });
                    generar_grafico(dias, montos, 'Ventas de '+mes_actual+' del '+anio_actual, 'Venta por día', 'Días', 'Monto Bs.');
                }

                function generar_anual(data){
                    var montos = [];
                    var meses = [];

                    let anio_actual = '';

                    data.map((value) => {
                        montos.push(value.monto);
                        meses.push(nombre_meses[value.mes - 1]);
                    });
                    generar_grafico(meses, montos, 'Ventas del '+anio_actual, 'Venta por mes', 'Mes', 'Monto Bs.');
                }

                function generar_grafico(label, data, title, tittleDataset, labelX, labelY){
                    // Imagen de carga
                    $('#list-data').html(`<div style="display: flex;justify-content: center;align-items: center;height:200px">
                                            <img src="{{voyager_asset('images/load.gif')}}" width="80px" alt="">
                                        </div>`);
                    var config = {
                        type: chart_type,
                        data: {
                            labels: label,
                            datasets: [{
                                label: tittleDataset,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255,99,132,1)',
                                data: data,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: title
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: labelX
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: labelY
                                    }
                                }]
                            }
                        }
                    };
                    $('#list-data').html('<canvas id="canvas"></canvas>');
                    var ctx = document.getElementById('canvas').getContext('2d');
			        window.myLine = new Chart(ctx, config);
                }
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
