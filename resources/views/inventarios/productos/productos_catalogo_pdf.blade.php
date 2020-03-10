<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ voyager_asset('images/icono.png') }}" type="image/x-icon">
    <title>Cátalogo de Productos</title>
    <style>
        body{
            font: sans-serif;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="30%" align="center" style="font-size:8px">
                <img src="{{ url('storage/'.setting('empresa.logo')) }}" alt="loginweb" width="100px"><br>
                <b>{{ setting('empresa.direccion') }}</b><br>
                <b>{{ setting('empresa.ciudad') }}</b><br>
            </td>
            <td width="70%" align="center"><h2>Catálogo de Productos <br><small>{{ setting('empresa.nombre') }}</small></h2></td>
        </tr>
    </table>
    <table border="1px" cellspacing="0" cellpadding="3" width="100%" style="font-size:12px">
        <thead>
            <tr align="center" style="font-size:10px">
                {{-- <th>N&deg;</th> --}}
                <th>CODIGO</th>
                <th>PRODUCTO</th>
                <th>CATEGORIA</th>
                <th>PRECIO</th>
                <th>UBICACION</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php
                $cont = 1;
            @endphp --}}
            @forelse ($productos as $item)
            <tr>
                {{-- <td>{{ $cont }}</td> --}}
                <td>{{ $item->id }} - {{ $item->codigo }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->categoria }}</td>
                <td>{{ $item->precio }}</td>
                <td align="center">{{ $item->ubicacion }}</td>
            </tr>
            {{-- @php
                $cont++;
            @endphp --}}
            @empty

            @endforelse
        </tbody>
    </table>
</body>
</html>
