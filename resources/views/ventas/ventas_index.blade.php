@extends('voyager::master')
@section('page_title', 'Ventas')

@if(auth()->user()->hasPermission('browse_ventas'))
    @section('page_header')
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">
                <i class="voyager-basket"></i> Ventas
            </h1>
            @if(auth()->user()->hasPermission('add_ventas'))
            <a href="{{route('ventas_create')}}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Añadir nueva</span>
            </a>
            @endif
        </div>
        <div class="form-group col-md-4 @if(!$cambiar_sucursal) hidden @else hola @endif" style="margin-top:50px">
            {{-- <label for="">Sucursal actual</label> --}}
            <select name="sucursal_id" id="select-sucursal_id" class="form-control">
                <option value="">Todas</option>
                @foreach ($sucursales as $item)
                <option value="{{$item->id}}">{{$item->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
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
                                        <div class="col-md-8"></div>
                                        <form id="form-search" class="form-search">
                                            <div class="input-group col-md-4">
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Cliente, tipo o estado">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" style="margin-top:0px;padding:5px 10px" type="submit">
                                                        <i class="voyager-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="data"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal cambiar tipo de venta --}}
        <form id="form-change" action="{{route('convertir_factura')}}" method="POST">
            <div class="modal modal-primary fade" tabindex="-1" id="modal_change" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-certificate"></i> Estás seguro que deseas convertir este recibo en factura?
                            </h4>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="submit" class="btn btn-dark pull-right delete-confirm"value="Sí, convertir!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- modal delete --}}
        <form id="form-delete" action="{{route('venta_delete')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres anular la venta?
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>Si anula una venta ya no podra cambiar el estado de la misma.</p>
                            <select name="tipo" style="display:none" class="form-control" id="">
                                <option value="A">Anulada</option>
                                <option value="V">Valida</option>
                                <option value="E">Extraviada</option>
                                <option value="N">No autorizada</option>
                                <option value="C">Emitida en contingencia</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="importe" value="">
                            <input type="hidden" name="caja_id" value="">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, borrar!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- modal repartidor --}}
        <form id="form-delivery" action="{{ route('asignar_repartidor') }}" method="POST">
            <div class="modal modal-info fade" tabindex="-1" id="modal_delivery" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-truck"></i> Elija al repartidor
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <select name="repartidor_id" class="form-control select2" id="select-repartidor_id" required>
                                <option value="">--Seleccione al repartidor--</option>
                                @foreach ($delivery as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right delete-confirm"value="Sí, elegir!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Audio --}}
        <audio id="alert" src="{{url('audio/alert.mp3')}}" preload="auto"></audio>
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

            var page_actual = 1;
            var sucursal_actual = "{{ $sucursal_actual ?? 'all' }}";
            var search = $('#search_value').val();

            var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
            var loader_request = `  <div style="height:200px" class="text-center">
                                        <br><br><br>
                                        <img src="${loader}" width="100px">
                                        <p>Cargando...</p>
                                    </div>`;

            $(document).ready(function() {
                $('#select-sucursal_id').val({{ $sucursal_actual }});
                $('#select-sucursal_id').select2();

                // Imagen de carga para la lista de ventas
                $('#data').html(loader_request);
                get_data(sucursal_actual, search, page_actual);

                // Cambiar de susursal
                $('#select-sucursal_id').change(function(){
                    sucursal_actual = $(this).val() ? $(this).val() : 'all';
                    page_actual = 1
                    $('#data').html(`<div class="text-center" style="height:200px"><br><img src="${loader}" width="100px"></div>`);
                    get_data(sucursal_actual, search, page_actual);
                });
                
                $('[data-toggle="tooltip"]').tooltip();

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    search = $('#search_value').val();
                    page_actual = 1
                    $('#data').html(`<div class="text-center" style="height:200px"><br><img src="${loader}" width="100px"></div>`);
                    get_data(sucursal_actual, search, page_actual);
                });

                // Send form-change
                $('#form-change').on('submit', function(e){
                    e.preventDefault();
                    $.post("{{ route('convertir_factura') }}", $('#form-change').serialize(), function(data){
                        if(data){
                            toastr.success('Factura generada correctamente.', 'Bien hecho');
                            get_data(sucursal_actual, search, page_actual);
                        }else{
                            toastr.error('Ocurrió un error al generar la factura.', 'Error');
                        }
                    });
                    $('#modal_change').modal('hide');
                });

                // Send form-delete
                $('#form-delete').on('submit', function(e){
                    e.preventDefault();
                    $.post("{{ route('venta_delete') }}", $('#form-delete').serialize(), function(data){
                        if(data){
                            toastr.success('Venta anulada exitosamenete.', 'Bien hecho');
                            get_data(sucursal_actual, search, page_actual);
                        }else{
                            toastr.error('Ocurrió un error al anular la venta.', 'Error');
                        }
                    });
                    $('#modal_delete').modal('hide');
                });

                // setInterval(function(){
                //     get_data(sucursal_actual, search, page_actual);
                // }, 20000);

            });

            // Obtenes lista de ventas
            function get_data(sucursal_id, search, page){
                let url = '{{ url("admin/ventas/lista") }}';
                let sucursal = sucursal_id ? sucursal_id : 'all';
                let q = search ? search : 'all';
                $.get(`${url}/${sucursal_id}/${q}?page=${page}`, function(data){
                    $('#data').html(data);
                });
            }

            // Asiganr repartidor al pedido
            $('#form-delivery').on('submit', function(e){
                e.preventDefault();
                $.post("{{ route('asignar_repartidor') }}", $('#form-delivery').serialize(), function(data){
                    if(data.success){
                        toastr.success('Pedido asignado exitosamente.', 'Bien hecho!');
                        get_data(sucursal_actual, search, page_actual);
                    }else{
                        toastr.error(data.error, 'Error!');
                    }
                    $('#modal_delivery').modal('hide');
                });
            });

            // Reimprimir factura/recibo
            function print(id){
                @if($tamanio=='rollo')
                    $.get("{{url('admin/venta/impresion/rollo')}}/"+id, function(){});
                @else
                    window.open("{{url('admin/venta/impresion/normal')}}/"+id, "Factura", `width=700, height=400`)
                @endif
            }
        </script>
        {{-- Laravel Echo --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            // Escuchando los pedidos nuevo
            Echo.channel('PedidoNuevoChannel{{ $sucursal_actual }}')
            .listen('pedidoNuevo', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification('Pedido nuevo!',{
                        body: 'Se ha recibido un pedido nuevo.',
                        icon: '{{ url("img/assets/success.png") }}'
                    });
                }
                document.getElementById('alert').play();
                get_data(sucursal_actual, search, page_actual);
            });

            // Escuchando los pedidos listos desde cocina
            Echo.channel('PedidoCocinaListoChannel{{ $sucursal_actual }}')
            .listen('pedidoListo', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification('Pedido listo!',{
                        body: 'Pedidos listo para entregar desde cocina.',
                        icon: '{{ url("img/assets/info.png") }}'
                    });
                }
                get_data(sucursal_actual, search, page_actual);
            });

            // Escuchando los pedidos entregados por los repartidores
            Echo.channel('PedidoEntregadoChannel{{ $sucursal_actual }}')
            .listen('pedidoEntregado', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification('Pedido entregado!',{
                        body: 'Pedidos entregado por delivery.',
                        icon: '{{ url("img/assets/info.png") }}'
                    });
                }
                get_data(sucursal_actual, search, page_actual);
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
