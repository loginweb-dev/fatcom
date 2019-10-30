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
                        <form id="form-search" method="post" action='{{route("ventas_reporte_generar")}}'>
                            @csrf
                            {{-- <div class="col-md-4 form-group">
                                <label>Inicio</label>
                                <input type="date" class="form-control" name="inicio" value="{{date('Y-m-d')}}" required>
                            </div> --}}
                            <div class="col-md-5 form-group">
                                <label>Fecha</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="inicio" value="{{date('Y-m-d')}}" required>
                                    <span class="input-group-btn">
                                        <input type="date" class="form-control" name="fin" value="{{date('Y-m-d')}}" required>
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
        <div id="detalle_reporte"></div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        $(document).ready(function(){
            $('#form-search').on('submit', function(e){
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

