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
		</style>
    </head>
    <body>
        <div style="text-align:right" id="print">
            <button onclick="javascript:window.print()" class="btn-print">Imprimir</button>
        </div>

        <table width="100%">
                    <tr>
                        <td width="33%" align="center" style="font-size:7px">
                            <img src="{{url('storage').'/'.setting('empresa.logo')}}" alt="loginweb" width="100px"><br>
                            {{-- <b style="font-size:14px">{{setting('empresa.title')}}</b><br> --}}
                            <b style="font-size:10px"> De: {{ setting('empresa.propietario') }}</b><br>

                            @if(setting('empresa.telefono')!='')
                            <b>Telf: {{setting('empresa.telefono')}}</b>
                            @endif
                            @if(setting('empresa.telefono')!='' && setting('empresa.celular')!='')
                                -
                            @endif
                            @if(setting('empresa.celular')!='')
                            <b>Cel: {{setting('empresa.celular')}}</b><br>
                            @endif

                            <b>{{setting('empresa.direccion')}}</b><br>
                            <b>{{setting('empresa.ciudad')}}</b><br>
                        </td>
                        <td width="33%" align="center"><span style="margin-bottom:0px;font-weight:bold;font-size:25px">FACTURA</span></td>
                        <td width="33%" align="center">
                            <table border="1px" cellspacing="0" cellpadding="1">
                                <tr>
                                    <td>NIT</td>
                                    <td> <b>{{setting('empresa.nit')}}</b> </td>
                                </tr>
                                <tr>
                                    <td>Nro. Factura</td>
                                    <td style="color:red"> <b>{{str_pad($detalle_venta[0]->nro_factura, 5, "0", STR_PAD_LEFT)}}</b> </td>
                                </tr>
                                <tr>
                                    <td>Autorización</td>
                                    <td> <b>{{ $detalle_venta[0]->nro_autorizacion }}</b> </td>
                                </tr>
                            </table>
                            <small><b>@if($original) ORIGINAL @else COPIA @endif</b><br>{{setting('empresa.actividad_economica')}}</small>
                        </td>
                    </tr>
                </table>
                {{-- datos de la venta --}}
                {{-- <div style="height:20px"></div> --}}
                <table width="90%" align="center">
                    <tr>
                        <td><b>Razón social</b></td>
                        <td>: {{$detalle_venta[0]->cliente}}</td>
                        <td align="right"><b>NIT/CI</b></td>
                        <td>: {{$detalle_venta[0]->nit}}</td>
                    </tr>
                    <tr>
                        <td><b>Fecha</b></td>
                        <td>: {{$detalle_venta[0]->fecha}}</td>
                        <td align="right"><b>Ubicación</b></td>
                        <td>: {{setting('empresa.ciudad')}}</td>
                    </tr>
                </table>
                {{-- detalles de la venta --}}
                {{-- <div style="height:10px"></div> --}}
                <table width="100%" border="1px" cellspacing="0" cellpadding="2">
                    <tr style="background-color:#022A81;color:#fff">
                        <td align="center" width="40px"><b>N&deg;</b></td>
                        {{-- <td align="center" width="80px"><b>Código</b></td> --}}
                        <td align="center"><b>Detalle</b></td>
                        <td align="center" width="50px" style="@if(setting('empresa.tipo_actividad')=='servicios') display:none @endif"><b>Cantidad</b></td>
                        <td align="center" width="100px"><b>Precio unitario</b></td>
                        <td align="center" width="100px"><b>Subtotal</b></td>
                    </tr>
                    @php
                        $cont = 1;
                        $total_venta = 0;
                    @endphp
                    @foreach ($detalle_venta as $item)
                        <tr>
                            <td align="center">{{$cont}}</td>
                            {{-- <td>{{$item->codigo}}</td> --}}
                            <td>{{$item->producto}}</td>
                            <td align="center" style="@if(setting('empresa.tipo_actividad')=='servicios') display:none @endif">{{$item->cantidad}}</td>
                            <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td>
                            <td align="center">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                        </tr>
                        @php
                            $cont++;
                            $total_venta += $item->precio*$item->cantidad;
                        @endphp
                    @endforeach
                    <tr>
                        <td @if(setting('empresa.tipo_actividad')=='servicios') colspan="3" @else colspan="4" @endif align="right"><b>DESCUENTO Bs.</b></td>
                        <td align="center"><b>{{number_format($detalle_venta[0]->descuento, 2, ',', '.')}}</b></td>
                    </tr>
                    <tr>
                        <td @if(setting('empresa.tipo_actividad')=='servicios') colspan="3" @else colspan="4" @endif align="right"><b>TOTAL Bs.</b></td>
                        <td align="center"><b>{{number_format($detalle_venta[0]->importe_base, 2, ',', '.')}}</b></td>
                    </tr>
                </table>
                {{-- datos de dosificacion --}}
                <div style="height:10px"></div>
                <table width="90%" align="center">
                    <tr>
                        <td><b>Son : </b> {{$total_literal}}</td>
                        <td align="right"><b>Fecha limite de emisión : </b> {{date('d-m-Y', strtotime($detalle_venta[0]->fecha_limite))}}</td>
                    </tr>
                    <tr>
                        <td><b>Código de control : </b>{{$detalle_venta[0]->codigo_control}}</td>
                    </tr>
                </table>
                <center style="margin: 0px 110px">{!! setting('empresa.leyenda_factura') !!}</center>
                <div style="text-align:right; margin-top:-30px">
                        {{-- nit empresa | nro_factura | Autorización | fecha / | monto | monto | codigo de control | nit | 0.00 | 0.00 | 0.00 | 0.00 --}}
                        @php
                            $qr = setting('empresa.nit').'|'.$detalle_venta[0]->nro_factura.'|'.$detalle_venta[0]->nro_autorizacion.'|'.$detalle_venta[0]->fecha.'|'.number_format($total_venta, 2, '.', '').'|'.number_format($total_venta, 2, '.', '').'|'.$detalle_venta[0]->codigo_control.'|'.$detalle_venta[0]->nit.'|0.00|0.00|0.00|0.00';
                        @endphp
                        <br>
                        {!! QrCode::size(100)->generate("$qr"); !!}
                </div>
        <script>
            window.print();
            setTimeout(function(){
                window.close();
            }, 10000);
        </script>
    </body>
</html>

