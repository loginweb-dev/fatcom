
<div class="panel panel-bordered">
    <div class="panel-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th><a href="#"></a></th>
                        <th><a href="#">User</a></th>
                        <th><a href="#">Producto</a></th>
                        <th><a href="#">Cantidad</a></th>
                        <th><a href="#">Motivo</a></th>
                        <th><a href="#">Depósito</a></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cont = 0;
                        $total = 0;
                    @endphp
                    @forelse ($productos as $item)
                    @php
                        $cont++;
                        $total += $item->cantidad;
                    @endphp
                        <tr>
                            <td>{{$cont}}</td>
                            <td>{{$item->user->name}}</td>
                            <td>{{$item->producto->codigo}}</td>
                            <td>{{$item->cantidad}}</td>
                            <td>{{$item->motivo}}</td>
                            <td>{{$item->deposito->nombre}}</td>
                        </tr>
                    @empty

                    @endforelse
                    <tr>
                        <td colspan="5" align="right" style="font-weight:bold">TOTAL ANULADOS.</td>
                        <td style="font-weight:bold">{{$total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>