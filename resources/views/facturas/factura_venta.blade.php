<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
        <title>Factura</title>
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
                font-size: 10px;
                font-family: 'Noto Sans', sans-serif;
                /* border: 1px solid black;
                border-radius: 1px; */
                padding: 5px 10px
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
                    <br>
                    <!-- no se puede acceder a ruta del setting, hay q concatenar "../../storage/" -->
                    {{-- <img src="../../storage/{{setting('empresa.logo')}}" alt="loginweb" width="80px"><br> --}}
                    <h2>{{setting('empresa.title')}}</h2>

                    @if(setting('empresa.telefono')!='')
                    <b>Telf: {{setting('empresa.telefono')}}</b>
                    @endif
                    @if(setting('empresa.telefono')!='' && setting('empresa.celular')!='')
                        -
                    @endif
                    @if(setting('empresa.celular')!='')
                    <b>Cel: {{setting('empresa.celular')}}</b>
                    @endif
                    <br>
                    <b>{{setting('empresa.direccion')}}</b><br>
                    <b>{{setting('empresa.ciudad')}}</b><br>
                </td>
            </tr>
            <tr>
                {{-- consulta para saber si es factura o recibo --}}
                <td colspan="2" align="center">
                    <h3>
                        TICKET DE VENTA #{{$detalle_venta[0]->id}}<br>
                        Atendido por: {{ Auth::user()->name}}<br>
                        {{date('d/m/Y H:i:s')}}
                    </h3>
                    <hr>
                </td>
            </tr>
            {{-- datos de la factura --}}

            {{-- datos de la venta --}}
            <tr>
                <td><b>Razón social</b></td>
                <td>: {{$detalle_venta[0]->cliente}}</td>
            </tr>
            <tr>
                <td><b>NIT/CI</b></td>
                <td>: {{$detalle_venta[0]->nit}}</td>
            </tr>
            <tr>
                <td><b>Fecha</b></td>
                <td>: {{$detalle_venta[0]->fecha}}</td>
            </tr>
            {{-- <tr>
                <td><b>Ubicación</b></td>
                <td>: {{setting('empresa.ciudad')}}</td>
            </tr> --}}
            <tr>
                {{-- detalle de la venta --}}
                <td colspan="2">
                    <table width="100%">
                        <tr>
                           <th style="@if(setting('empresa.tipo_actividad')=='servicios') display:none @endif">CANTIDAD</th>
                           <th>DETALLE</th>
                           {{-- <th>P. UNITARIO</th> --}}
                           <th>SUB TOTAL</th>
                        </tr>
                        @php
                            $total_venta = 0;
                            $indice = 0;
                        @endphp
                        @foreach ($detalle_venta as $item)
                            <tr>
                                <td align="center">{{$item->cantidad}}</td>
                                <td>{{$item->producto}} {{$producto_adicional[$indice]['nombre']}}</td>
                                {{-- <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td> --}}
                                <td align="right">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                            </tr>
                            @php
                                $total_venta += $item->precio*$item->cantidad;
                                $indice++;
                            @endphp
                        @endforeach
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
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td colspan="2">Gracias por su preferencia, vuelva pronto.</td>
            </tr>
        </table>

        <div style="height:50px"></div>

        <table width="300px">
            <tr>
                {{-- consulta para saber si es factura o recibo --}}
                <td colspan="2" align="center"><h3>ORDEN #{{$detalle_venta[0]->id}}<br>{{date('d/m/Y H:i:s')}}</h3><hr></td>
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
                           <th>SUB TOTAL</th>
                        </tr>
                        @php
                            $total_venta = 0;
                            $indice = 0;
                        @endphp
                        @foreach ($detalle_venta as $item)
                            <tr>
                                <td align="center">{{$item->cantidad}}</td>
                                <td>{{$item->producto}}  {{$producto_adicional[$indice]['nombre']}}</td>
                                <td>{{$item->observaciones}}</td>
                                {{-- <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td> --}}
                                <td align="right">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                            </tr>
                            @php
                                $total_venta += $item->precio*$item->cantidad;
                                $indice++;
                            @endphp
                        @endforeach
                        <tr>
                            <td @if(setting('empresa.tipo_actividad')=='servicios') colspan="2" @else colspan="3" @endif align="right"><b>DESCUENTO Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->descuento, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td @if(setting('empresa.tipo_actividad')=='servicios') colspan="2" @else colspan="3" @endif align="right"><b>TOTAL Bs.</b></td>
                            <td align="right"><b>{{number_format($detalle_venta[0]->importe_base, 2, ',', '.')}}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <script>
            window.print();
        </script>
    </body>
</html>

