<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
        <title>Factura de venta</title>
        <style>
            .btn-print{
                background-color: #fa2a00;
                color:white;
                border: 1px solid #fa2a00;
                padding: 5px 8px;
                border-radius:5px
            }
            @media print {
                #print{
                    display: none;
                }
            }
            body{
                font-size: 11px;
                font-family: 'Noto Sans', sans-serif;
                /* border: 1px solid black;
                border-radius: 1px; */
                padding: 5px 10px;
                margin: 0px
            }

			@media all {
			   div.saltopagina{
			      display: none;
			   }
			}

			@media print{
			   div.saltopagina{
			      display:block;
			      page-break-before:always;
			   }
			}
            .badge{
                padding:2px 20px;
                background-color:black;
                color:white;
                font-size: 12px;
                font-weight:bold;
            }
		</style>
    </head>
    <body>
        <div style="text-align:right" id="print">
            <button onclick="javascript:window.print()" class="btn-print">Imprimir</button>
        </div>

        <table width="300px">
            <tr>
                {{-- cabezera --}}
                <td colspan="2" align="center" style="font-size:10px">
                    {{-- <br> --}}
                    <!-- no se puede acceder a ruta del setting, hay q concatenar "../../storage/" -->
                    <img src="{{ url('storage').'/'.setting('empresa.logo') }}" alt="loginweb" width="80px"><br>
                    <h2>{{ setting('empresa.title') }}</h2>
                    <b>De: {{ setting('empresa.propietario') }}</b><br>
                    <b>{{ strtoupper($detalle_venta[0]->sucursal) }}</b><br>
                    <b>{{ setting('empresa.direccion') }}<b><br>
                    @if(setting('empresa.telefono')!='')
                    <b>Telf: {{ setting('empresa.telefono') }}</b>
                    @endif
                    @if(setting('empresa.telefono')!='' && setting('empresa.celular')!='')
                        -
                    @endif
                    @if(setting('empresa.celular')!='')
                    <b>Cel: {{ setting('empresa.celular') }}</b>
                    @endif
                    <br>
                    <b>{{ setting('empresa.ciudad') }}</b><br>
                    <b>{{ setting('empresa.actividad_economica') }}</b><br>
                </td>
            </tr>
            <tr>
                {{-- consulta para saber si es factura o recibo --}}
                <td colspan="2" align="center">
                    <hr>
                    <b>F A C T U R A</b><br>
                    NIT : {{ setting('empresa.nit') }} <br>
                    AUTORIZACION : {{ $detalle_venta[0]->nro_autorizacion }} <br>
                    FACTURA Nro : {{ str_pad($detalle_venta[0]->nro_factura, 5, "0", STR_PAD_LEFT) }} <br>
                    {{-- {{ $detalle_venta[0]->tipo_nombre }} --}}
                    <hr>
                </td>
            </tr>
            {{-- datos de la factura --}}

            {{-- datos de la venta --}}
            <tr>
                <td><b>RAZON SOCIAL</b></td>
                <td>: {{$detalle_venta[0]->cliente}}</td>
            </tr>
            <tr>
                <td><b>NIT/CI</b></td>
                <td>: {{$detalle_venta[0]->nit}}</td>
            </tr>
            <tr>
                <td><b>FECHA</b></td>
                <td>: {{date('d/m/Y H:i:s', strtotime($detalle_venta[0]->created_at))}}</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                {{-- detalle de la venta --}}
                <td colspan="2">
                    <table width="100%">
                        <tr>
                           <th style="@if(setting('empresa.tipo_actividad')=='servicios') display:none @endif">CANTIDAD</th>
                           <th>DETALLE</th>
                           {{-- <th>P. UNITARIO</th> --}}
                           <th align="right">IMPORTE</th>
                        </tr>
                        @php
                            $total_venta = 0;
                            $indice = 0;
                        @endphp
                        @foreach ($detalle_venta as $item)
                            <tr>
                                <td align="center"><b>{{ $item->cantidad }}</b></td>
                                <td>{{ $item->subcategoria }} - {{ $item->producto }}{{ $item->producto_adicional ? '/'.$item->producto_adicional : '' }}</td>
                                {{-- <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td> --}}
                                <td align="right">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                            </tr>
                            @php
                                $total_venta += $item->precio*$item->cantidad;
                                $indice++;
                            @endphp
                        @endforeach
                        @if($detalle_venta[0]->cobro_adicional > 0)
                        <tr>
                            <td></td>
                            <td>Costo de envío</td>
                            <td align="right">{{number_format(($detalle_venta[0]->cobro_adicional), 2, ',', '.')}}</td>
                        </tr>
                        @php
                            $total_venta += $detalle_venta[0]->cobro_adicional;
                        @endphp
                        @endif
                        <tr>
                            <td colspan="2" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($total_venta, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->descuento, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->importe_base, 2, ',', '.')}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">Son {{ $total_literal }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td><b>FECHA LIMITE EMISION</b></td>
                <td>: {{ date('d-m-Y', strtotime($detalle_venta[0]->fecha_limite)) }}</td>
            </tr>
            <tr>
                <td><b>CODIGO CONTROL</b></td>
                <td>{{ $detalle_venta[0]->codigo_control }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="text-align:center">
                        {{-- nit empresa | nro_factura | Autorización | fecha / | monto | monto | codigo de control | nit | 0.00 | 0.00 | 0.00 | 0.00 --}}
                        @php
                            $qr = setting('empresa.nit').'|'.$detalle_venta[0]->nro_factura.'|'.$detalle_venta[0]->nro_autorizacion.'|'.$detalle_venta[0]->fecha.'|'.number_format($total_venta, 2, '.', '').'|'.number_format($total_venta, 2, '.', '').'|'.$detalle_venta[0]->codigo_control.'|'.$detalle_venta[0]->nit.'|0.00|0.00|0.00|0.00';
                        @endphp
                        <br>
                        {!! QrCode::size(150)->generate("$qr"); !!}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><center>{!! setting('empresa.leyenda_factura') !!}</center></td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><b>Atendido por : </b> {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="2"><b style="font-size:14px">TICKET Nro : {{ $detalle_venta[0]->nro_venta }}</b></td>
            </tr>
        </table>

        <div class="saltopagina"></div>

        <table width="300px">
            <tr>
                {{-- consulta para saber si es factura o recibo --}}
                <td colspan="2" align="center">
                    <h3>
                        ORDEN #{{$detalle_venta[0]->nro_venta}}<br>
                        {{date('d/m/Y H:i:s')}}<br>
                        <span class="badge">{{ strtoupper($detalle_venta[0]->tipo_nombre) }}</span>
                    </h3><hr>
                </td>
            </tr>
            <tr>
                {{-- detalle de la venta --}}
                <td colspan="2">
                    <table width="100%">
                        <tr>
                           <th style="@if(setting('empresa.tipo_actividad')=='servicios') display:none @endif">CANTIDAD</th>
                           <th>DETALLE</th>
                           <th>OBS.</th>
                           {{-- <th>P. UNITARIO</th> --}}
                           <th align="right">IMPORTE</th>
                        </tr>
                        @php
                            $total_venta = 0;
                            $indice = 0;
                        @endphp
                        @foreach ($detalle_venta as $item)
                            <tr>
                                <td align="center"><b>{{ $item->cantidad }}</b></td>
                                <td>{{ $item->subcategoria }} - {{ $item->producto }}{{ $item->producto_adicional ? '/'.$item->producto_adicional : '' }}</td>
                                <td>{{$item->observaciones}}</td>
                                {{-- <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td> --}}
                                <td align="right">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                            </tr>
                            @php
                                $total_venta += $item->precio*$item->cantidad;
                                $indice++;
                            @endphp
                        @endforeach
                        @if($detalle_venta[0]->cobro_adicional > 0)
                        <tr>
                            <td></td>
                            <td>Costo de envío</td>
                            <td></td>
                            <td align="right">{{number_format(($detalle_venta[0]->cobro_adicional), 2, ',', '.')}}</td>
                        </tr>
                        @php
                            $total_venta += $detalle_venta[0]->cobro_adicional;
                        @endphp
                        @endif
                        <tr>
                            <td colspan="3" align="right"><b>SUB TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($total_venta, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->descuento, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->importe_base, 2, ',', '.')}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><h3>Cliente: {{$detalle_venta[0]->cliente}}.</h3> </td>
            </tr>
        </table>
        <script>
            window.print();
            setTimeout(function(){
                window.close();
            }, 10000);
        </script>
    </body>
</html>

