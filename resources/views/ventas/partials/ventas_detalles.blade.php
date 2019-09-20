<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <td align="center" width="40px"><b>N&deg;</b></td>
            {{-- <td align="center" width="80px"><b>Código</b></td> --}}
            <td align="center"><b>Detalle</b></td>
            <td align="center" width="50px" ><b>Cantidad</b></td>
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
                <td align="center" >{{$item->cantidad}}</td>
                <td align="center">{{number_format($item->precio, 2, ',', '.')}}</td>
                <td align="center">{{number_format(($item->precio*$item->cantidad), 2, ',', '.')}}</td>
            </tr>
            @php
                $cont++;
                $total_venta += $item->precio*$item->cantidad;
            @endphp
        @endforeach
        <tr>
            <td colspan="4" align="right"><b>DESCUENTO Bs.</b></td>
            <td align="center"><b>{{number_format($detalle_venta[0]->descuento, 2, ',', '.')}}</b></td>
        </tr>
        <tr>
            <td colspan="4" align="right"><b>TOTAL Bs.</b></td>
            <td align="center"><b>{{number_format($detalle_venta[0]->importe_base, 2, ',', '.')}}</b></td>
        </tr>
    </table>
</div>
