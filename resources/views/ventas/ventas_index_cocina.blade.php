@extends('voyager::master')
@section('page_title', 'Pedidos pendientes')

@if(auth()->user()->hasPermission('browse_ventascocina'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-dashboard"></i> Pedidos pendientes
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
                            <div id="lista-pendientes"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
    @section('css')
        <style>
            .select2{
                border: 1px solid #ddd
            }
            .btn-cambiar_estado{
                padding: 3px 10px
            }
        </style>
    @stop
    @section('javascript')
        <script>
            // Pedir autorización para mostrar notificaciones
            Notification.requestPermission();
            
            var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
            var loader_request = `  <div style="height:200px" class="text-center">
                                        <br><br><br>
                                        <img src="${loader}" width="100px">
                                    </div>`;
            $(document).ready(function(){
                get_pendientes();
            });
            function get_pendientes(){
                $('#lista-pendientes').html(loader_request);
                $.get('{{ route("cocina.list") }}', function(data){
                    $('#lista-pendientes').html(data);
                });
            }
        </script>
        {{-- Laravel Echo --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            Echo.channel('PedidoCocinaChannel{{ $sucursal_id }}')
            .listen('pedidoPreparacion', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification('Nuevo pedido!',{
                        body: 'Se ingresado un nuevo pedido desde caja.',
                        icon: '{{ url("img/assets/info.png") }}'
                    });
                }
                get_pendientes();
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
