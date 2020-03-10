@extends('voyager::master')
@section('page_title', 'Reporte de ventas')
@if(auth()->user()->hasPermission('browse_reportesventas'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bar-chart"></i> Reporte de ventas
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form id="form_report" name="form_report" class="form-inline" method="post" action='{{route("ventas_reporte_generar")}}'>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Desde</label>
                                        <input type="date" class="form-control" name="inicio" value="{{date('Y-m-d')}}" required>
                                        <label for="">Hasta</label>
                                        <input type="date" class="form-control" name="fin" value="{{date('Y-m-d')}}" required>
                                        <label for="">Agrupado</label>
                                        <select name="filtro" class="form-control">
                                            <option value="1">Por venta</option>
                                            <option value="2">Por Producto</option>
                                        </select>
                                        <select name="tipo" class="form-control">
                                            <option value="">Todas</option>
                                            <option value="1">Recibos</option>
                                            <option value="2">Facturas</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-top:-5px">
                                        <button type="submit" class="btn btn-primary"><i class="voyager-settings"></i> Generar</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="report_type" name="type">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="detalle_reporte"></div>
    </div>
@stop

@section('css')
<link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
@stop

@section('javascript')
    <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
    <script>
        var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
        var loader_request = `  <div style="height:200px;background-color:white" class="text-center">
                                    <br><br><br>
                                    <img src="${loader}" width="100px">
                                    <p>Cargando...</p>
                                </div>`;
        $(document).ready(function(){
            $('#form_report').on('submit', function(e){
                $('#detalle_reporte').html(loader_request);
                e.preventDefault();
                let datos = $(this).serialize();
                $.ajax({
                    url: '{{route("ventas_reporte_generar")}}',
                    type: 'post',
                    data: datos,
                    success: function(data){
                        $('#detalle_reporte').html(data);
                    },
                    error: function(){
                        console.log('Error');
                    }
                });
            });
        });

        // ver factura en ventana emergente
        function ver_factura(id){
            window.open("{{url('admin/factura')}}/"+id, "Factura", `width=800, height=600`)
        }
    </script>
@stop
@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

