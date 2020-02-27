@extends('voyager::master')
@section('page_title', 'Reporte de ganancia estimada')
@if(auth()->user()->hasPermission('browse_reportesganancia_producto'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bar-chart"></i> Reporte de ganancia estimada
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
                        <form id="form-search" method="post" action='{{route("ganancia_producto_reporte_generar")}}'>
                            @csrf
                            <div class="col-md-4 form-group">
                                <label>Inicio</label>
                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="inicio" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Fin</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="fin" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" style="margin-top:0px;padding:9px">
                                            <span class="voyager-search"></span> 
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="detalle_reporte"></div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
        var loader_request = `  <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <img src="${loader}" width="80px">
                                        </div>
                                    </div>
                                </div>`;
        $(document).ready(function(){
            $('#form-search').on('submit', function(e){
                e.preventDefault();
                let datos = $(this).serialize();
                $('#detalle_reporte').html(loader_request);
                $.ajax({
                    url: '{{route("ganancia_producto_reporte_generar")}}',
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

        // // ver factura en ventana emergente
        // function ver_factura(id){
        //     window.open("{{url('admin/factura')}}/"+id, "Factura", `width=800, height=600`)
        // }
    </script>
@stop
@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
