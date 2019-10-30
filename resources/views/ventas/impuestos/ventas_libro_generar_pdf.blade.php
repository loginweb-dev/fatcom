<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ voyager_asset('images/icono.png') }}" type="image/x-icon">
    <title>Libro de Ventas</title>
    <style>
        body{
            font: sans-serif;
        }
    </style>
</head>
<body>
    @php setlocale(LC_ALL, 'es_ES'); @endphp
    <h4 style="text-align:center">LIBRO DE VENTAS <br> ESTANDAR</h4>
    <table cellspacing="0" cellpadding="10" width="100%" style="font-size:14px">
        <tr>
            <td><b>PERIODO</b></td>
            <td> <b>AÑO :</b> {{$anio}} <b>MES : </b> {{strftime('%B', strtotime($anio.'-'.$mes.'-01'))}}</td>
        </tr>
        <tr>
            <td><b>NOMBRE O RAZÓN SOCIAL</b></td>
            <td> {{setting('empresa.nombre')}}</td>
            <td><b>NIT</b></td>
            <td> {{setting('empresa.nit')}}</td>
        </tr>
    </table>
    <table border="1px" cellspacing="0" cellpadding="3" width="100%" style="font-size:12px">
        <thead>
            <tr align="center" style="font-size:10px">
                <th>N&deg;</th>
                <th width="80px">FECHA DE LA FACTURA</th>
                <th>N&deg; DE LA FACTURA</th>
                <th>N&deg; DE LA AUTORIZACIÓN</th>
                <th>ESTADO</th>
                <th>NIT/CI CLIENTE</th>
                <th width="100px">NOMBRE O RAZÓN SOCIAL</th>
                <th>IMPORTE TOTAL DE LA VENTA<br>A</th>
                <th>IMPORTE ICE/IEDH/TASAS/OTROS NO SUJETOS AL IVA<br>B</th>
                <th>EXPORTACIONES Y OPERACIONES EXENTAS<br>C</th>
                <th>VENTAS GRABADAS A TASA CERO<br>D</th>
                <th>SUB TOTAL<br>E = A - B - C - D</th>
                <th>DESCUENTOS, BONIFICACIONES Y REBAJAS SUJETAS AL IVA<br>F</th>
                <th>IMPORTE BASE PARA DEBITO FISCAL<br>G = E - F</th>
                <th>DÉBITO FISCAL<br>H = G * 13%</th>
                <th width="100px">CÓDIGO DE CONTROL</th>
            </tr>
        </thead>
        <tbody align="center">
            @php
                $cont = 1;
                $importe_venta = 0;
                $importe_ice = 0;
                $importe_exento = 0;
                $tasa_cero = 0;
                $sub_total = 0;
                $descuento = 0;
                $importe_base = 0;
                $debito_fiscal = 0;
            @endphp
            @forelse ($ventas as $item)
            <tr>
                <td>{{$cont}}</td>
                <td>{{date('d-m-Y', strtotime($item->fecha))}}</td>
                <td>{{$item->nro_factura}}</td>
                <td>{{$item->nro_autorizacion}}</td>
                <td>{{$item->estado}}</td>
                <td>{{$item->nit}}</td>
                <td>{{$item->cliente}}</td>
                <td>{{$item->importe}}</td>
                <td>{{$item->importe_ice}}</td>
                <td>{{$item->importe_exento}}</td>
                <td>{{$item->tasa_cero}}</td>
                <td>{{$item->subtotal}}</td>
                <td>{{$item->descuento}}</td>
                <td>{{$item->importe_base}}</td>
                <td>{{$item->debito_fiscal}}</td>
                <td>{{$item->codigo_control}}</td>
            @php
                $cont++;
                $importe_venta += $item->importe;
                $importe_ice += $item->importe_ice;
                $importe_exento += $item->importe_exento;
                $tasa_cero += $item->tasa_cero;
                $sub_total += $item->subtotal;
                $descuento += $item->descuento;
                $importe_base += $item->importe_base;
                $debito_fiscal += $item->debito_fiscal;
            @endphp
            </tr>
            @empty

            @endforelse
            <tr>
                <td colspan="7" align="left">TOTAL</td>
                <td style="background-color:#EEEAEA">{{number_format($importe_venta, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($importe_ice, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($importe_exento, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($tasa_cero, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($sub_total, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($descuento, 2, ',', '')}}</td>
                {{-- <td style="background-color:#EEEAEA">{{number_format($importe_base, 2, ',', '')}}</td>
                <td style="background-color:#EEEAEA">{{number_format($debito_fiscal, 2, ',', '')}}</td> --}}
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
