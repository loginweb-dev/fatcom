@extends('voyager::master')
@section('page_title', 'Reporte de productos en escasez')
@if(auth()->user()->hasPermission('browse_reportesproductosescasez'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-warning"></i> Reporte de productos en escasez
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
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Producto</th>
                                        <th>Stock actual</th>
                                        <th>Stock mínimo</th>
                                        <th>Ultima compra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productos as $item)
                                        <tr>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->stock }}</td>
                                            <td>{{ $item->stock_minimo }}</td>
                                            <td>
                                                @if ($item->ultima_compra)
                                                {{ date('d-m-Y', strtotime($item->ultima_compra)) }} <br> <small>{{ \Carbon\Carbon::parse($item->ultima_compra)->diffForHumans() }}</small> 
                                                @else
                                                    No realizada
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron resultados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
            $().html(`<h3></`);
            $('#form-search').on('submit', function(e){
                e.preventDefault();
                let datos = $(this).serialize();
                $('#detalle_reporte').html(`<div class="text-center"><br><img src="{{voyager_asset('images/loading.gif')}}" width="50px" alt=""> Cargando...</div>`)
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
