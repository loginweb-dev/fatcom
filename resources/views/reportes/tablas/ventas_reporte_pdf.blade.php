
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
        <td width="65%" align="center"><h2>Reporte de ventas - {{date('d/m/Y', strtotime($fecha))}}</h2></td>
    </tr>
</table>
<table border="1" width="100%" cellspacing="0" cellpadding="10px ">
    <thead>
        <tr>
            {{-- <th><a href="#">Id</a></th> --}}
            <th><a href="#">Fecha</a></th>
            <th><a href="#">Productos</a></th>
            <th><a href="#">Precio</a></th>
            <th><a href="#">cantidad</a></th>
            <th><a href="#">Total</a></th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @forelse ($ventas as $item)
        @php
            $total += $item->precio*$item->cantidad;
        @endphp
        <tr>
            {{-- <td>{{$item->id}}</td> --}}
            <td>{{$item->fecha}}</td>
            <td>{{$item->nombre}}</td>
            <td>{{$item->precio}}</td>
            <td>{{$item->cantidad}}</td>
            <td>{{$item->precio*$item->cantidad}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No existen ventas</td>
        </tr>
        @endforelse
        <tr>
            <td colspan="4"><b style="font-weight:bold">TOTAL</b></td>
            <td><b style="font-weight:bold">{{number_format($total, 2, ',', '')}} Bs.</b></td>
        </tr>
    </tbody>
</table>
