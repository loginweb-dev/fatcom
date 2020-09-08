<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>N&deg;</th>
            <th>Fecha</th>
            <th>registrado por</th>
            <th>Observaciones</th>
            <th>Monto</th>
        </tr>
        @php
            $cont = 1;
        @endphp
        @foreach ($detalle as $item)
            <tr>
                <td>{{$cont}}</td>
                <td>{{date('d-m-Y', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                <td>{{$item->name}}</td>
                <td>{{$item->observacion}}</td>
                <td>{{number_format($item->monto, 2, ',', '.')}}</td>
            </tr>
            @php
                $cont++;
            @endphp
        @endforeach
        <tr>
            <td colspan="4" align="right"><b>TOTAL Bs.</b></td>
            <td><b>{{number_format(count($detalle) ? $detalle[0]->monto_recibido : 0, 2, ',', '.')}}</b></td>
        </tr>
    </table>
</div>
