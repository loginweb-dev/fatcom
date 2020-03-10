
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="col-md-12 text-right" style="text-align:center">
                <table width="100%">
                    <tr>
                        <td width="30%" align="center" style="font-size:8px">
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
                        <td width="70%" align="center"><h3>Reporte de ventas generado desde {{ date('d-m-Y', strtotime($inicio)) }} hasta {{ date('d-m-Y', strtotime($fin)) }}</h3></td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="panel-body">
                <div class="table-responsive">
                    <table width="100%" border="1" cellspacing="0" cellpadding="5">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Detalle</th>
                                <th>Importe</th>
                                <th>Adicional</th>
                                <th>Descuento</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @forelse ($ventas as $item)
                            <tr>
                                <td>{{ $item->fecha }}</td>
                                <td>{{ $item->cliente }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->detalle as $detail)
                                            <li>
                                                {{ explode('.',$detail->cantidad)[1] == '00' ? intval($detail->cantidad) : number_format($detail->cantidad, 1, '.', '') }} 
                                                {{ $detail->nombre }} 
                                                {{ $detail->precio }} Bs.</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $item->importe }}</td>
                                <td>{{ $item->cobro_adicional }}</td>
                                <td>{{ $item->descuento }}</td>
                                <td>{{ number_format($item->importe_base, 2, ',', '') }}</td>
                            </tr>
                            @php
                                $total += $item->importe_base;
                            @endphp
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No existen ventas</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="6"><h4>TOTAL</h4></td>
                                <td><h4>{{ number_format($total, 2, ',', '') }} Bs.</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    th{
        font-size: 20px
    }
    table td{
        font-family: Sans-serif;
        font-size: 15px
    }
</style>