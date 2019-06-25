@extends('voyager::master')

@section('page_header')
    {{-- <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-basket"></i> Nueva venta
        </h1>
    </div> --}}
@stop

@section('content')
<form id="form" action="{{route('ventas_store')}}" method="post">
    <div class="page-content browse container-fluid">
        @if(!$abierta)
        <div class="alert alert-warning">
            <strong>Atención:</strong>
            <p>No puede realizar ventas debido a que no se ha aperturado la caja.</p>
        </div>
        @endif
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding:0px">
                        <ul class="nav nav-tabs">
                            @php
                                $clase = 'active';
                            @endphp
                            @foreach ($categorias as $item)
                            <li class="li-item {{$clase}}" id="li-{{$item->id}}">
                                <a data-toggle="tab" href="#tab1" onclick="productos_categoria({{$item->id}})">{{$item->nombre}}</a>
                            </li>
                            @php
                                $clase = '';
                            @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane fade in  active ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-bordered" style="height:400px">
                    <div class="panel-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="tipo" id="input-tipo" value="venta">
                            <input type="hidden" name="facturacion" value="{{setting('empresa.facturas')}}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre completo</label>
                                    <select name="cliente_id" class="form-control" id="select-cliente_id">
                                        <option value="1">--Ninguno--</option>
                                        @foreach ($clientes as $item)
                                        <option value="{{$item->id}}" data-nit="{{$item->nit}}">{{$item->razon_social}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>NIT/CI</label>
                                    <input type="number" name="nit" id="input-nit" class="form-control">
                                </div>
                            </div>
                            <hr style="margin-bottom:10px;margin-top:0px">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>¿Para llevar?</label><br>
                                    <input type="checkbox" id="check-llevar" name="llevar" data-toggle="toggle" data-on="Sí" data-off="No">
                                    <input type="hidden" name="fecha" class="form-control" value="{{date('Y-m-d')}}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>N&deg; de Mesa</label>
                                    <input type="number" min="1" step="1" name="nro_mesa" id="input-nro_mesa" class="form-control" value="" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>A domicilio</label><br>
                                    <input type="checkbox" id="check-llevar" name="llevar" data-toggle="toggle" data-onstyle="success" data-on="Sí" data-off="No">
                                </div>
                            </div>
                            <hr style="margin-bottom:10px;margin-top:0px">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Monto entregado</label>
                                    <input type="number" id="input-entregado" value="0" min="1" step="0.5" onchange="calcular_cambio()" onkeyup="calcular_cambio()" style="font-size:18px" name="monto_recibido" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Cambio</label>
                                    <input type="number" id="input-cambio" value="0" readonly style="font-size:18px" name="cambio" class="form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="caja_id" value="{{$caja_id}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-top:-30px">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width:300px">Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th colspan="2">Subtotal</th>
                                </thead>
                                <tbody>
                                    <tr id="detalle_venta">
                                        <td colspan="3" class="text-right"><h4>TOTAL</h4></td>
                                        <td id="label-total" colspan="2"><h4>0.00 Bs.</h4></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="importe" value="0" id="input-total">
                        </div>
                        <div class="col-md-12 text-right">
                            {{-- <button type="reset" id="btn-reset" class="btn btn-default">Vaciar</button> --}}
                            {{-- <input type="checkbox" id="check-factura" name="factura" data-toggle="toggle" data-on="Con factura" data-off="Sin factura" data-onstyle="success" data-offstyle="danger"> --}}
                            <button type="submit" @if(!$abierta) disabled @endif class="btn btn-primary" style="padding:20px">Vender <span class="voyager-basket"></span> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('partials.modal_load')
{{-- Variables PHP para inicializar la vista --}}
@php
    $categoria_id = 0;
    if(count($categorias)>0){
        $categoria_id = $categorias[0]->id;
    }
@endphp

@stop

@section('css')
    <style>
        .img-producto:hover{
            border: 5px solid #096FA9;
        }
    </style>
@stop

@section('javascript')
    <script src="{{url('js/ventas.js')}}"></script>
    <script src="{{url('js/loginweb.js')}}"></script>
    <script>
        $(document).ready(function(){
            inicializar_select2('cliente_id');
            productos_categoria({{$categoria_id}});

            // formulario de envio de venta
            $('#form').on('submit', function(e){
                $('#modal_load').modal('show');
                e.preventDefault();
                let datos = $(this).serialize();
                $.ajax({
                    url: "{{route('ventas_store')}}",
                    type: 'post',
                    data: datos,
                    success: function(data){
                        if(data){
                            let id = data;
                            toastr.success('Venta registrada correctamente.', 'Exito');
                            @if(setting('empresa.facturas')==1)
                            window.open("{{url('admin/factura')}}/"+id, "Factura", `width=800, height=600`)
                            @endif
                            $('#form')[0].reset();
                            $('.tr-detalle').remove();
                            $(".label-subtotal").text('0.00');
                            $("#label-total").text('0.00 Bs.');

                            // resetear panel de productos
                            @if(count($categorias)>0)
                            $('.li-item').removeClass('active');
                            $('#li-'+{{$categoria_id}}).addClass('active');
                            productos_categoria({{$categoria_id}})
                            @endif
                        }else{
                            toastr.error('Ocurrio un error al ingresar la venta.', 'Error');
                        }
                        $('#modal_load').modal('hide');
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });



            // anular o activar mesa si no es para llevar
            $('#check-llevar').change(function() {
                if($(this).prop('checked')){
                    $('#input-nro_mesa').val('');
                    $('#input-nro_mesa').attr('readonly', true);
                    $('#input-nro_mesa').removeAttr('required');
                    $('#input-tipo').val('llevar');
                }else{
                    $('#input-nro_mesa').removeAttr('readonly');
                    $('#input-nro_mesa').attr('required', true);
                    $('#input-tipo').val('venta');
                }
            });
        });

        // Agregar detalle de venta
        function agregar_detalle_restaurante(id, nombre, precio, stock){
            let cantidad = $('#input_cantidad-'+id).val();

            if(cantidad>stock){
                toastr.warning('La cantidad de producto ingresada sobrepasa la existente.', 'Atención');
                return false;
            }

            // recorer la lista para ver si el producto existe
            let existe = false;
            $(".tr-detalle").each(function(){
                if($(this).data('id')==id){
                    existe = true;
                }
            });
            if(existe){
                $(`#tr-${id} .label-precio`).html(`<input type="hidden" value="${cantidad}" name="cantidad[]">${cantidad}`);
                $(`#subtotal-${id}`).html(`<h5>${precio*cantidad} Bs.</h5>`);
            }else{
                $('#detalle_venta').before(`<tr class="tr-detalle" id="tr-${id}" data-id="${id}">
                                                <td><input type="hidden" value="${id}" name="producto_id[]">${nombre}</td>
                                                <td><input type="hidden" value="${precio}" name="precio[]">${precio} Bs.</td>
                                                <td class="label-precio"><input type="hidden" value="${cantidad}" name="cantidad[]">${cantidad}</td>
                                                <td class="label-subtotal" id="subtotal-${id}"><h5>${precio*cantidad} Bs.</h5></td>
                                                <td width="40px"><label onclick="borrarTr(${id})" class="text-danger" style="cursor:pointer;font-size:20px"><span class="voyager-trash"></span></label></td>
                                            <tr>`);
                toastr.remove();
                toastr.info('Producto agregar correctamente', 'Bien hecho!');
            }
            $('#input_cantidad-'+id).val('1');
            total();
            calcular_cambio();
        }

        // mostrar los productos de la categoria seleccionada
        function productos_categoria(id){
            $('#tab1').html(`  <div style="height:270px" class="text-center">
                                    <br><br><br>
                                    <img src="{{ voyager_asset('images/load.gif') }}" width="100px">
                                </div>`);
            $.ajax({
                url: `{{url('admin/ventas/crear/productos_categoria/${id}')}}`,
                type: 'get',
                success: function(data){
                    $('#tab1').html(data);
                },
                error: function(){console.log('Error');}
            });
        }



    </script>
@stop
