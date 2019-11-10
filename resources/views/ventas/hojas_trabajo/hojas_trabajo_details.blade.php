@extends('voyager::master')
@section('page_title', 'Hoja de trabajo')

@if(auth()->user()->hasPermission('add_compras'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> Hoja de trabajo
            </h1>
        </div>
    @stop

    @section('content')
        <div class="page-content browse container-fluid">
            {{-- Detalles de la prodorma --}}
            <form action="{{ route('hojas_trabajos_close') }}" method="post">
                <div class="row">
                    @csrf
                    <br>
                    @if(!$abierta)
                    <div class="alert alert-warning">
                        <strong>Atención:</strong>
                        <p>No puede realizar el cierre de la hoja de trabajo debido a que no se ha aperturado la caja.</p>
                    </div>
                    @endif
                    <div class="col-md-12">
                        <div class="panel panel-bordered" style="margin-top:-30px">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Producto</th>
                                            <th style="width:120px">Precio</th>
                                            <th style="width:120px">Cantidad de salidad</th>
                                            <th style="width:120px">Cantidad devuelta</th>
                                            <th style="width:120px">Cantidad vendida</th>
                                            <th style="width:120px">Importe</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $estado = false;
                                                $codigo_hoja = '';
                                                $sucursal_id = 0;
                                            @endphp
                                            @foreach ($registros as $item)
                                            @php
                                                $estado = $item->estado == 1 ? true : false;
                                                $codigo_hoja = $item->codigo;
                                                $sucursal_id = $item->sucursal_id;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->producto }} <input type="hidden" name="producto_id[]" value="{{ $item->producto_id }}"></td>
                                                <td><input type="number" @if(!$estado) disabled @endif name="precio[]" id="input-precio{{ $item->detalle_id }}" class="form-control input-change" data-id="{{ $item->detalle_id }}" min="0" step="0.01" name="precio" value="{{ $item->precio }}" required></td>
                                                <td id="label-catidad{{ $item->detalle_id }}">{{ $item->cantidad }}</td>
                                                <td><input type="number" @if(!$estado) disabled @endif id="input-cantidad_devuelta{{ $item->detalle_id }}" class="form-control input-change" data-id="{{ $item->detalle_id }}" min="0" step="1" max="{{ $item->cantidad }}" value="0" required></td>
                                                <td><span id="label-vendido{{ $item->detalle_id }}">{{ $item->cantidad }}</span><input type="hidden" id="input-cantidad{{ $item->detalle_id }}" name="cantidad[]" value="{{ $item->cantidad }}"></td>
                                                <td class="label-importe" id="label-importe{{ $item->detalle_id }}">{{ $item->cantidad * $item->precio }} Bs.</td>
                                            </tr>  
                                            @endforeach
                                            <tr>
                                                <td>Gastos</td>
                                                <td colspan="4"><input type="text" @if(!$estado) disabled @endif name="detalle_gasto" class="form-control" placeholder="Detalles de los gatos"></td>
                                                <td><input type="number" id="input-monto_gasto" @if(!$estado) disabled @endif name="monto_gasto" min="0" style="0.1" class="form-control" value="0" required></td>
                                            </tr>
                                            <tr id="detalle_venta">
                                                <td colspan="5" class="text-right"><h4>TOTAL</h4></td>
                                                <td>
                                                    <h4 id="label-total">0.00 Bs.</h4>
                                                    <input type="hidden" id="input-importe" name="importe">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <label for="">Observaciones</label>
                                        <textarea name="observaciones" @if(!$estado) disabled @endif class="form-control" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="caja_id" value="{{ $caja_id }}">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="codigo" value="{{ $codigo_hoja }}">
                                    <input type="hidden" name="sucursal_id" value="{{ $sucursal_id }}">
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                @if($estado)
                                <button type="submit" @if(!$abierta) disabled @endif class="btn btn-primary">Cerrar hoja</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @stop

    @section('css')
        <style>
            
        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/loginweb.js')}}"></script>
        <script>
            // cargar vista de detalle de compra según tipo
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();

                calcular_total();

                // Evento que desencadena el cambiar la cantidad devuelta
                $('.input-change').keyup(function(){
                    let id = $(this).data('id');
                    cambiar_cantidad(id);
                });
                $('.input-change').change(function(){
                    let id = $(this).data('id');
                    cambiar_cantidad(id);
                });

                // Evento que desencadena el cambiar el gasto
                $('#input-monto_gasto').keyup(function(){
                    let id = $(this).data('id');
                    cambiar_cantidad(id);
                });
                $('#input-monto_gasto').change(function(){
                    let id = $(this).data('id');
                    cambiar_cantidad(id);
                });
                
            });

            // Cambiar cantidad devuelto
            function cambiar_cantidad(id){
                let cantidad_salida = $(`#label-catidad${id}`).text() != '' ?  parseInt($(`#label-catidad${id}`).text()) : 0;
                let cantidad_devuelta = $(`#input-cantidad_devuelta${id}`).val() != '' ? parseInt($(`#input-cantidad_devuelta${id}`).val()) : 0;
                let precio = $(`#input-precio${id}`).val() != '' ? parseInt($(`#input-precio${id}`).val()) : 0;
                $(`#label-vendido${id}`).text(cantidad_salida - cantidad_devuelta)
                $(`#input-cantidad${id}`).val(cantidad_salida - cantidad_devuelta)
                $(`#label-importe${id}`).text(`${(cantidad_salida - cantidad_devuelta) * precio} Bs.`);
                calcular_total();
            }

            // Calcular total
            function calcular_total(){
                var total = 0;
                let gastos = $('#input-monto_gasto').val() != '' ? parseFloat($('#input-monto_gasto').val()) : 0;
                $('.label-importe').each(function(){
                    let monto = parseFloat($(this).text().replace(' Bs.', ''));
                    total += monto;
                });
                $('#label-total').text(`${(total-gastos).toFixed(2)} Bs.`);
                $('#input-importe').val(total);
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan
