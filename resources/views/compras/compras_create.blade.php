@extends('voyager::master')
@section('page_title', 'Nueva compra')

@if(auth()->user()->hasPermission('add_compras'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-edit"></i> Nueva compra <input type="checkbox" id="switch-factura" checked data-toggle="toggle" data-on="Con factura" data-off="Sin factura">
            </h1>
        </div>
    @stop

    @section('content')
    <form id="form" action="{{route('compras_store')}}" method="post">
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class="text-center">Datos del Generales</h4>
                            <hr>
                            @csrf
                            <div class="form-group">
                                <label>Nro de factura</label>
                                <input type="number" min="0" name="nro_factura" id="input-nro_factura" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nro de DUI</label>
                                <input type="number" min="0" name="nro_dui" class="form-control con_factura" data-toggle="popover" data-trigger="focus" title="Información" data-placement="bottom" data-content="Número de la Declaración Única de Importación. Este dato es obligatorio solamente cuando la compra se trate de una importación.">
                            </div>
                            <div class="form-group">
                                <label id="label-nit">NIT del proveedor</label>
                                <input type="number" min="0" name="nit" id="input-nit" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label id="label-razon_social">Razón social</label>
                                <input type="text" name="razon_social" id="input-razon_social" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label id="label-fecha">Fecha de factura</label>
                                <input type="date" name="fecha" class="form-control" value="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class="text-center">Datos de la factura</h4>
                            <hr>
                            <div class="form-group">
                                <label>Tipo de compra</label>
                                <select name="tipo_compra" id="select-tipo_compra" class="form-control select2">
                                    <option value="1">Interno/Actividades agravadas (Estandar)</option>
                                    <option value="2">Interno/Actividades no agravadas</option>
                                    <option value="3">Sujetas a proporcinalidad</option>
                                    <option value="4">Exportaciones</option>
                                    <option value="5">Interno/Exportaciones</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Código de control</label>
                                <input type="text" name="codigo_control" class="form-control con_factura" data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="bottom" data-content="En caso de ser una factura manual dejar en blanco este campo.">
                            </div>
                            <div class="form-group">
                                <label>Nro de autorización</label>
                                <input type="number" min="0" name="nro_autorizacion" class="form-control con_factura">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6" style="margin-bottom:10px">
                                    <label>Monto exento</label>
                                    <input type="number" min="0" step="0.1" name="monto_exento" value="0" class="form-control calculable con_factura" id="input-exento" data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="top" data-content="Monto que no está sujeto al IVA o que está exento (ICE, IEHD, Tasas, IPJ y Contribuciones e Importes Exentos). También se consignará el importe de las compras
                                    gravadas a Tasa Cero. Ejemplos:<br>
                                    En el caso de compras de Gasolina o Diésel a estaciones de servicio debe registrar el 30% del importe total.<br>
                                    Para el caso de Actividades gravadas a Tasa Cero también se registra el 100% del Importe Total de la compra." required>
                                </div>
                                <div class="form-group col-md-6" style="margin-bottom:10px">
                                    <label>Descuento</label>
                                    <input type="number" min="0" step="0.1" name="descuento" value="0" class="form-control calculable con_factura" id="input-descuento" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Depositos</label>
                                <select name="deposito_id" class="form-control select2" required>
                                    @foreach($depositos as $item)
                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top:-30px">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class="text-center">Detalle de la compra</h4>
                            <div class="clearfix"></div>
                            <hr style="margin-top:0px">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab1" onclick="cargar_detalle('productos', '{{url('admin/compras/crear')}}')">Productos</a>
                                    </li>
                                    <li id="btn-otra_compra">
                                        <a data-toggle="tab" href="#tab1" onclick="cargar_detalle('normal','{{url('admin/compras/crear')}}')">Otras compras</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab1" class="tab-pane fade in  active ">
                                        <div id="detalle_venta">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="row" id="table-datos_calculados">
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sub total</th>
                                            <th>Importe base p/ credito fiscal</th>
                                            <th>Crédito fiscal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" readonly name="importe_compra" id="input-importe_compra" class="form-control" value=""></td>
                                            <td><input type="text" readonly name="importe_base" id="input-importe_base" class="form-control" value=""></td>
                                            <td><input type="text" readonly name="credito_fiscal" id="input-credito_fiscal" class="form-control" value=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input type="checkbox" id="check-crear_asiento" @if($caja) value="{{$caja->id}}" @else disabled @endif name="crear_asiento" data-toggle="tooltip" data-placement="right" title="Crear un registro de egreso en caja con el monto de la compra realizada.">
                            <label for="check-crear_asiento">Crear registro de egreso en caja</label>
                            <br>
                            {{-- <button type="reset" id="btn-reset" class="btn btn-default">Vaciar</button> --}}
                            <button type="submit" data-toggle="modal" data-target="#confirm_modal" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal de detalle de producto --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal-info_producto" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="voyager-harddrive"></i> Detalle de producto</h4>
                    </div>
                    <div class="modal-body" id="info_producto"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" id="btn-cancel-map" data-dismiss="modal">cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @stop

    @section('css')
        <style>
            .popover{
                width: 350px
            }
            .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover{
                background:#fff !important;
                color:#62a8ea !important;
                border-bottom:1px solid #fff !important;
                top:-1px !important;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/compras.js')}}"></script>
        <script src="{{ url('js/loginweb.js') }}"></script>
        <script src="{{ url('js/inventarios/productos.js') }}"></script>
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script>
            // cargar vista de detalle de compra según tipo
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();
                // obtener datos de proveedor
                $('#input-nit').change(function(){
                    let nit = $(this).val();
                    if(nit!=''){
                        $.ajax({
                            url: `{{url('admin/proveedores/get_proveedor/${nit}')}}`,
                            type: 'get',
                            success: function(data){
                                if(data){
                                    $('#form input[name="razon_social"]').val(data);
                                    toastr.info('Proveedor seleccionado.', 'Información');
                                }
                            },
                            error: function(){
                                console.log('error');
                            }
                        });
                    }
                });
                // deshabilitar datos segun compra
                $('#switch-factura').change(function() {
                    let con_factura = $(this).prop('checked');
                    if(con_factura){
                        $('.con_factura').removeAttr('readonly');
                        $('#table-datos_calculados').css('display', 'block');
                        $('#input-nit').attr('required', true);
                        $('#input-nro_factura').removeAttr('disabled');
                        $('#select-tipo_compra').removeAttr('disabled');

                        $('#label-nit').text('NIT del proveedor');
                        $('#label-razon_social').text('Razón social');
                        $('#label-fecha').text('Fecha de factura');

                        $('#btn-otra_compra').css('display', 'block');
                    }else{
                        $('.con_factura').prop('readonly', true);
                        $('#table-datos_calculados').css('display', 'none');
                        $('#input-nit').removeAttr('required');
                        $('#input-nro_factura').attr('disabled', true);
                        $('#select-tipo_compra').attr('disabled', true);

                        $('#label-nit').text('NIT del proveedor (opcional)');
                        $('#label-razon_social').text('Nombre del proveedor');
                        $('#label-fecha').text('Fecha de compra');

                        $('#btn-otra_compra').css('display', 'none');
                        // cargar_detalle('mercaderia')
                    }
                });

                $('#btn-enviar').click(function(){
                    let con_factura = $(this).prop('checked');
                    if(con_factura){
                        $('#confirm_modal').modal('hide');
                        let factura = $('#input-nro_factura').val();
                        let nit = $('#input-nit').val();
                        let nombre = $('#input-razon_social').val();
                        if(factura==''){
                            toastr.error('Debe ingresar un número de factura para realizar la venta.', 'Error');
                        }
                        if(nit==''){
                            toastr.error('Debe ingresar un NIT para realizar la venta.', 'Error');
                        }
                        if(nombre==''){
                            toastr.error('Debe ingresar la razón social para realizar la venta.', 'Error');
                        }
                    }
                });
            });

            cargar_detalle('productos')
            function cargar_detalle(tipo){
                $('#detalle_venta').html('<br><h4 class="text-center">Cargando...</h4><br>');
                $.ajax({
                    url: `{{url('admin/compras/crear')}}/`+tipo,
                    type: 'get',
                    success: function(data){
                        $('#detalle_venta').html(data);
                    },
                    error: function(){
                        console.log('error');
                    }
                });
            }

            function producto_info(id){
                $('#modal-info_producto').modal();
                $('#info_producto').html('<br><h4 class="text-center">Cargando...</h4>');
                $.get('{{url("admin/productos/ver/informacion")}}/'+id, function(data){
                    $('#info_producto').html(data);
                });
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan
