@extends('voyager::master')
@section('page_title', 'Viendo Caja')

@if(auth()->user()->hasPermission('read_cajas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-treasure"></i> Viendo Caja
        </h1>

        @if($caja->abierta)
            @if(auth()->user()->hasPermission('close_cajas'))
            <button class="btn btn-danger btn-small btn-close" data-id="{{$caja->id}}" data-toggle="modal" data-target="#modal_close">
                <i class="voyager-lock"></i> <span>Cerrar caja</span>
            </button>
            @else
            <button type="button" class="btn btn-success btn-small">Abierta</button>
            @endif
        @else
        <button type="button" class="btn btn-danger btn-small">Cerrada</button>
        @endif
        <a href="{{route('cajas_index')}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
    @stop

    @section('content')
        <div class="page-content">
            {{-- <form action="{{route('cajas_close')}}" method="post"> --}}
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto total de ingresos</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->total_ingresos}} Bs.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto total de egresos</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->total_egresos}} Bs.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-4" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto de apertura</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->monto_inicial}} Bs.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Pagos con tajeta</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{ number_format($tarjeta->total, 2, '.', '') }} Bs.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto de cierre</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->monto_final}} Bs.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($caja->abierta)
                                            <div class="row">
                                                <div class="col-md-12" style="margin:0px">
                                                    <div class="panel-body" style="padding-top:0;max-height:200px;overflow-y:auto">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Corte</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista_cortes"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-12" style="margin:0px">
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Observaciones</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        <p>{{$caja->observaciones}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto de cierre</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p id="label-total">{{$caja->monto_real}} Bs.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto faltante</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p id="label-faltante">{{$caja->monto_faltante}} Bs.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="table-responsive" style="height:300px">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Hora</th>
                                                        <th>Concepto</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_ingreso = 0;
                                                        $cont = 1;
                                                        $ingresos_borrados = 0;
                                                        $total_ingresos_borrados = 0;
                                                    @endphp
                                                    @forelse($ingresos as $item)
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td>{{$item->hora}}</td>
                                                        <td>{{$item->concepto}} {{ $item->venta_id ? 'ID:'.$item->venta_id : '' }} @if($item->deleted_at) <label class="label label-danger">Eliminado</label> @endif</td>
                                                        <td @if($item->deleted_at) class="text-danger" @endif>{{$item->monto}} Bs.</td>
                                                    </tr>
                                                    @php
                                                        if(!$item->deleted_at){
                                                            $total_ingreso+= $item->monto;
                                                        }else{
                                                            $ingresos_borrados++;
                                                            $total_ingresos_borrados+= $item->monto;
                                                        }
                                                        $cont++;
                                                    @endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="4"><br><center><h5>No existen ingresos registrados.</h5></center></td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <h4>Total ingresos: {{number_format($total_ingreso, 2, ',', '')}} Bs.</h4>
                                        </div>
                                        @if($ingresos_borrados)
                                        <div class="alert alert-danger">
                                            <strong>Atención:</strong>
                                            <p>Se eliminaron {{$ingresos_borrados}} resgistro(s) de ingreso, sumando un total de <b>{{number_format($total_ingresos_borrados, 2, ',', '')}}</b> Bs.</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive" style="height:300px">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Hora</th>
                                                        <th>Concepto</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_egreso = 0;
                                                        $cont = 1;
                                                        $egresos_borrados = 0;
                                                        $total_egresos_borrados = 0;
                                                    @endphp
                                                    @forelse($egresos as $item)
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td>{{$item->hora}}</td>
                                                        <td>{{$item->concepto}} {{ $item->compra_id ? 'ID:'.$item->compra_id : '' }} @if($item->deleted_at) <label class="label label-danger">Eliminado</label> @endif</td>
                                                        <td @if($item->deleted_at) class="text-danger" @endif>{{$item->monto}} Bs.</td>
                                                    </tr>
                                                    @php
                                                        if(!$item->deleted_at){
                                                            $total_egreso+= $item->monto;
                                                        }else{
                                                            $egresos_borrados++;
                                                            $total_egresos_borrados+= $item->monto;
                                                        }
                                                        $cont++;
                                                    @endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="4"><br><center><h5>No existen egresos registrados.</h5></center></td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <h4>Total egresos: {{number_format($total_egreso, 2, ',', '')}} Bs.</h4>
                                        </div>
                                        @if($egresos_borrados)
                                        <div class="alert alert-danger">
                                            <strong>Atención:</strong>
                                            <p>Se eliminaron {{$egresos_borrados}} resgistro(s)de engreso, sumando un total de <b>{{number_format($total_egresos_borrados, 2, ',', '')}}</b> Bs.</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </form> --}}
        </div>
        @include('cajas.modal_cerrar')
    @stop
    @section('css')
        <style>

        </style>
    @stop
    @section('javascript')
        <script>
            let monto_cierre = "{{$caja->monto_final}}";
            monto_cierre = parseFloat(monto_cierre);
            $(document).ready(function(){
                // set valor de cerrar caja

                $('.btn-close').click(function(){
                    $('#modal_close input[name="id"]').val($(this).data('id'));
                });

                $('.input-corte').keyup(function(){
                    let corte = $(this).data('value');
                    let cantidad = $(this).val() ? $(this).val() : 0;
                    calcular_subtottal(corte, cantidad);
                });
                $('.input-corte').change(function(){
                    let corte = $(this).data('value');
                    let cantidad = $(this).val() ? $(this).val() : 0;
                    calcular_subtottal(corte, cantidad);
                });
            });

            function calcular_subtottal(corte, cantidad){
                let total = (parseFloat(corte)*parseFloat(cantidad)).toFixed(2);
                $('#label-'+corte.toString().replace('.', '')).text(total+' Bs.');
                $('#input-'+corte.toString().replace('.', '')).val(total);
                calcular_total();
            }

            function calcular_total(){
                let total = 0;
                $(".input-subtotal").each(function(){
                    total += $(this).val() ? parseFloat($(this).val()) : 0;
                });
                $('#label-total').html('<b>'+(total).toFixed(2)+' Bs.</b>');
                $('#input-total').val(total);
                $('#label-faltante').html('<b>'+(monto_cierre-total).toFixed(2)+' Bs.</b>');
                $('#input-faltante').val(monto_cierre-total);

                if(monto_cierre-total>0){
                    $('#label-faltante').css('color', 'red')
                }else if(monto_cierre-total==0){
                    $('#label-faltante').css('color', 'green')
                }else{
                    $('#label-faltante').css('color', 'blue')
                }

            }
            @if($caja->abierta)
            calcular_total();
            let cortes = new Array('0.5', '1', '2', '5', '10', '20', '50', '100', '200')
            cortes.map(function(value){
                $('#lista_cortes').append(`<tr>
                                <td><h4><img src="{{url('img/billetes/${value}.jpg')}}" alt="${value} Bs." width="80px"> ${value} Bs. </h4></td>
                                <td><input type="number" min="0" step="1" style="width:100px" data-value="${value}" class="form-control input-corte" value="0" required></td>
                                <td><label id="label-${value.replace('.', '')}">0.00 Bs.</label><input type="hidden" class="input-subtotal" id="input-${value.replace('.', '')}"></td>
                            </tr>`)
            });
            @endif
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan
