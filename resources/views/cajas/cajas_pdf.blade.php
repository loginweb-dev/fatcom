<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle de la caja</title>
    <style>
        body{
            margin: 0px;
            font-family: Arial, Helvetica, sans-serif
        }
        .header{
            margin: 0px;
            margin-bottom: 20px;
        }
        table{
            width: 100%;
        }
        th{
            font-weight: bold;
            font-size: 16px;
            
        }
        .table-detail{
            border-spacing: 0px;
            border-collapse: separate;
        }
        .table-detail th, .table-detail td{
            border: 1px solid #aaa;
            padding: 2px 10px;
            
        }
        .table-detail thead{
            background-color: #EFEFEF
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="table-header">
            <tr>
                <td align="center" style="font-size:7px" width="200px">
                    <img src="{{ url('storage').'/'.str_replace('\\', '/', setting('empresa.logo')) }}" alt="{{ setting('empresa.nombre') }}" width="60px"><br>
                    <b>{{ setting('empresa.nombre') }}</b><br>
                    @if(setting('empresa.telefono')!='')
                    <b>Telf: {{setting('empresa.telefono')}}</b>
                    @endif
                    @if(setting('empresa.telefono')!='' && setting('empresa.celular')!='')-@endif
                    @if(setting('empresa.celular')!='')
                    <b>Cel: {{setting('empresa.celular')}}</b><br>
                    @endif
                    <b>{{setting('empresa.direccion')}}</b><br>
                    <b>{{setting('empresa.ciudad')}}</b><br>
                </td>
                <td align="right">
                    <h2>Reporte de Caja</h2>
                    <small>{{ count($registros) ? $registros[0]['nombre'].' de fecha '.date('d-m-Y', strtotime($registros[0]['created_at'])) : 'No definida' }}</small>
                </td>
            </tr>
        </table>
    </div>
    <div class="description">
        @if (count($registros))
            <br>
            <table>
                <tr>
                    <td>Monto inicial</td>
                    <td>:</td>
                    <td style="text-align:center"><b>{{ $registros[0]['monto_inicial'] }}</b></td>
                    <td>Monto de cierre</td>
                    <td>:</td>
                    <td style="text-align:center"><b>{{ $registros[0]['monto_final'] }}</b></td>
                </tr>
                <tr>
                    <td>Ingresos</td>
                    <td>:</td>
                    <td style="text-align:center"><b>{{ $registros[0]['total_ingresos'] }}</b></td>
                    <td>Egresos</td>
                    <td>:</td>
                    <td style="text-align:center"><b>{{ $registros[0]['total_egresos'] }}</b></td>
                </tr>
                <tr>
                    <td>Monto entregado</td>
                    <td>:</td>
                    <td style="text-align:center"><b>{{ $registros[0]['monto_real'] }}</b></td>
                    <td>Faltante</td>
                    <td>:</td>
                    @php
                        $faltante = $registros[0]['monto_final'] - $registros[0]['monto_real'];
                    @endphp
                    <td style="text-align:center"><b>{{ number_format( $faltante > 0 ? $faltante : 0, 2, '.', '') }}</b></td>
                </tr>
            </table>
            <br>
        @endif
    </div>
    <div class="content">
        <table class="table-detail">
            <thead>
                <tr>
                    <td colspan="5">
                        <h3 style="text-align:center;padding:-10px">Detalle del movimiento de caja</h3>
                    </td>
                </tr>
                <tr style="text-align:center">
                    <th width="40px">N&deg;</th>
                    <th>Descripción</th>
                    <th width="80px">tipo</th>
                    <th>Detalle</th>
                    <th width="100px">Monto</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @forelse ($registros as $item)
                    @php
                        $detalle_compra = '';
                        $detalle_venta = '';
                    @endphp
                    {{-- Recorrer detalle de compra por si el registro pertenece a una compra --}}
                    @foreach ($item['detalle_compra'] as $compra)
                        @php
                            $detalle_compra .= number_format($compra->cantidad, 0).' '.$compra->nombre.', ';
                        @endphp
                    @endforeach

                    {{-- Recorrer detalle de venta por si el registro pertenece a una venta --}}
                    @foreach ($item['detalle_venta'] as $compra)
                        @php
                            $detalle_venta .= number_format($compra->cantidad, 0).' '.$compra->nombre.', ';
                        @endphp
                    @endforeach
                    @php
                        $detalle_compra = substr($detalle_compra, 0, -2);
                        $detalle_venta = substr($detalle_venta, 0, -2);
                    @endphp
                    <tr>
                        <td>{{ $cont }}</td>
                        <td>{{ $item['concepto'] }}</td>
                        <td>{{ $item['tipo'] }}</td>
                        <td>
                            @if (count($item['detalle_compra']))
                            <b>Compra de: </b>
                            {{ $detalle_compra }}
                            @endif

                            @if (count($item['detalle_venta']))
                            <b>Venta de: </b>
                            {{ $detalle_venta }}
                            @endif
                        </td>
                        <td style="text-align:right">{{ $item['monto'] }}</td>
                    </tr>
                    @php
                        $cont++;
                    @endphp
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center">No existen registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>