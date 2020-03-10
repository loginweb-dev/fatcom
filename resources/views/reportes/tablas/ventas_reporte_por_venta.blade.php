
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="col-md-12 text-right">
                <button type="button" data-value="excel" class="btn btn-success btn-export">Excel</button>
                @if(count($ventas)<=200)
                <button type="button" data-value="pdf" class="btn btn-danger btn-export">PDF</button>
                @endif
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>N&deg;</th>
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
                                $cont = 1;
                            @endphp
                            @forelse ($ventas as $item)
                            <tr>
                                <td>{{ $cont }}</td>
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
                                $cont++;
                            @endphp
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No existen ventas</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="7"><h4>TOTAL</h4></td>
                                <td><h4>{{ number_format($total, 2, ',', '') }} Bs.</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.btn-export').click(function(){
            let value = $(this).data('value');
            $('#report_type').val(value);
            $('#form_report').attr('target', 'blank');
            document.form_report.submit();
            setTimeout(() => {
                $('#form_report').removeAttr('target');
                $('#report_type').val('');
            }, 0);
        });
    });
</script>