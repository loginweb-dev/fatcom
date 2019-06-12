<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ voyager_asset('images/icono.png') }}" type="image/x-icon">
    <title>Proforma</title>
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="35%" align="center" style="font-size:8px">
                <!-- no se puede acceder a ruta del setting, hay q concatenar "../../storage/" -->
                <img src="{{url('storage').'/'.setting('empresa.logo')}}" alt="loginweb" width="100px"><br>
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
            <td width="65%" align="center"><h2>Proforma</h2></td>
        </tr>
    </table>
    <table border="1px" cellspacing="0" cellpadding="3" width="100%" style="font-size:12px">
        <thead>
            <tr align="center" style="font-size:10px">
                <th>Código</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $cont = 0;
            @endphp
            @forelse ($carrito as $item)
            <tr>
                <td>{{$item->codigo}}</td>
                <td>
                    <table width="100%">
                        <tr>
                            <td rowspan="4">
                                @if($item->imagen!='')
                                    <img src="{{url('storage').'/'.$item->imagen}}" width="80px">
                                @else
                                    <span>Sin Imagen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span>{{$item->nombre}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Categoría:</b></td>
                            <td>{{$item->categoria}}</td>
                        </tr>
                        <tr>
                            <td><b>Marca:</b></td>
                            <td>{{$item->marca}}</td>
                        </tr>
                    </table>
                </td>
                <td>{{$cantidades[$cont]}}</td>
                <td>{{$item->precio}} Bs.</td>
                <td>{{$cantidades[$cont] * $item->precio}} Bs.</td>
            </tr>
            @php
                $total += $item->precio;
                $cont++;
            @endphp
            @empty
            <tr>
                <td colspan="5" class="text-center"><span>No se han agregados productos al carro.</span></td>
            </tr>
            @endforelse
            <tr>
                <td colspan="4">TOTAL</td>
                <td><b>{{$total}} Bs.</b></td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- <div style="text-align:right">
        {{$fecha}}
    </div> --}}
</body>
</html>
