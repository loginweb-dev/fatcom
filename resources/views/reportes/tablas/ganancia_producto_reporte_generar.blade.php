
<div class="panel panel-bordered">
    <div class="panel-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th><a href="#"></a></th>
                        <th><a href="#">Producto</a></th>
                        <th><a href="#">Precio de venta</a></th>
                        <th><a href="#">Precio de compra</a></th>
                        <th><a href="#">Cantidad vendida</a></th>
                        <th><a href="#">Ganancia por producto</a></th>
                        <th><a href="#">Ganancia Total</a></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont = 0;
                        $total = 0;
                    @endphp
                    @forelse ($datos as $item)
                    @php
                        $cont++;
                        $ganancia = 0;
                        if($item[0]['precio_compra']!=''){
                            $ganancia = $item[0]['precio_venta'] - $item[0]['precio_compra'];
                        }
                        $total += $ganancia * $item[0]['cantidad_venta'];
                    @endphp
                        @if($item[0]['precio_compra']!='')
                        <tr>
                            <td>{{$cont}}</td>
                            <td>{{$item[0]['producto']}}</td>
                            <td>{{number_format($item[0]['precio_venta'], 2, ',', '')}}</td>
                            @if($item[0]['precio_compra']!='')
                            <td>{{number_format($item[0]['precio_compra'], 2, ',', '')}}</td>
                            @else
                            <td>No definido</td>
                            @endif
                            <td>{{$item[0]['cantidad_venta']}}</td>
                            @if($item[0]['precio_compra']!='')
                            <td>{{number_format($ganancia, 2, ',', '')}}</td>
                            @else
                            <td>No definido</td>
                            @endif
                            <td>{{number_format($ganancia * $item[0]['cantidad_venta'], 2, ',', '')}}</td>
                        </tr>
                    @endif
                    @empty

                    @endforelse
                    <tr>
                        <td colspan="6" align="right" style="font-weight:bold">TOTAL Bs.</td>
                        <td style="font-weight:bold">{{number_format($total, 2, ',', '')}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>