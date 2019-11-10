<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
        <title>Proforma de venta</title>
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
                        <td width="30%" align="center" style="font-size:7px">
                            <img src="{{url('storage').'/'.setting('empresa.logo')}}" alt="loginweb" width="60px"><br>
                            <b>{{setting('empresa.nombre')}}</b><br>

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
                        <td width="40%" align="center"><span style="margin-bottom:0px;font-weight:bold;font-size:25px">HOJA DE TRABAJO</span></td>
                        <td width="30%" align="right"><span style="font-weight:bold;color:red;font-size:15px;">N&deg; {{ $hoja_trabajo[0]->codigo }}</span></td>
                    </tr>
                </table>
                <table width="90%" align="center">
                    <tr>
                        <td><b>Chofer</b></td>
                        <td>: {{ $hoja_trabajo[0]->empleado }}</td>
                        <td><b>Fecha</b></td>
                        <td>: {{ $hoja_trabajo[0]->fecha }}</td>
                    </tr>
                </table><br>
                <table width="100%" border="1px" cellspacing="0" cellpadding="2">
                    <tr style="background-color:#022A81;color:#fff">
                        <td align="center" width="40px"><b>N&deg;</b></td>
                        {{-- <td align="center" width="80px"><b>Código</b></td> --}}
                        <td align="center"><b>Detalle</b></td>
                        <td align="center" width="50px"><b>Cantidad</b></td>
                        <td align="center" width="100px"><b>Precio unitario</b></td>
                        <td align="center" width="100px"><b>Subtotal</b></td>
                    </tr>
                    @php
                        $cont = 1;
                        $total_venta = 0;
                    @endphp
                    @foreach ($hoja_trabajo as $item)
                        <tr>
                            <td align="center">{{$cont}}</td>
                            {{-- <td>{{$item->codigo}}</td> --}}
                            <td>{{$item->producto}}</td>
                            <td align="center">{{$item->cantidad}}</td>
                            <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td>
                            <td align="center">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
                        </tr>
                        @php
                            $cont++;
                            $total_venta += $item->precio*$item->cantidad;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="4" align="right"><b>TOTAL Bs.</b></td>
                        <td align="center"><b>{{number_format($monto_total, 2, ',', '.')}}</b></td>
                    </tr>
                </table>
                {{-- datos de dosificacion --}}
                <div style="height:10px"></div>
                <table width="90%" align="center">
                    <tr>
                        <td><b>Son : </b> {{$total_literal}}</td>
                    </tr>
                </table>
                <div style="margin:80px 0px; text-align:center">
                    <p>_____________________________<br>Firma</p>
                </div>
                
        <script>
            // window.print();
            // setTimeout(function(){
            //     window.close();
            // }, 10000);
        </script>
    </body>
</html>

