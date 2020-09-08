
<div class="row">
    <div class="col-md-12" style="margin-top:-30px">
        <div class="panel panel-bordered">
            <div class="panel-body">
                @if(count($ventas)>0)
                <div class="text-right">
                    <a href="{{url('admin/reporte/ventas/formulario/400/pdf/'.$mes.'/'.$anio)}}" target="_blank" class="btn btn-warning">Formulario 400</a>
                    <a href="{{url('admin/reporte/ventas/formulario/200/pdf/'.$mes.'/'.$anio)}}" target="_blank" class="btn btn-info">Formulario 200</a>
                    <a href="{{url('admin/reporte/ventas/libro/generar/pdf/'.$mes.'/'.$anio)}}" target="_blank" class="btn btn-danger">PDF</a>
                    <a href="{{url('admin/reporte/ventas/libro/generar/excel/'.$mes.'/'.$anio)}}" class="btn btn-success">Excel</a>
                </div><br>
                @endif
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>N&deg;</th>
                                <th>Fecha factura</th>
                                <th>Nro de factura</th>
                                <th>Autorización</th>
                                <th>Estado</th>
                                <th>NIT/CI Clientes</th>
                                <th>Nombre o Razón social</th>
                                <th>Importe total de Venta</th>
                                <th>Importe ICE/IEDH/tasas</th>
                                <th>Importaciones y operaciones exentas</th>
                                <th>Ventas gravadas tasa cero</th>
                                <th>Sub total</th>
                                <th>Descuentos y bonificaciones rebajasdas otorgadas</th>
                                <th>Importe base para débito fiscal</th>
                                <th>Débito fiscal</th>
                                <th>Código de control</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                <td>{{$item->fecha}}</td>
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
                            <tr>
                                <td colspan="16" align="center"><span>No existen ventas registradas en el periodo ingresado.</span></td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="7">TOTAL</td>
                                <td style="background-color:#EEEAEA">{{number_format($importe_venta, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($importe_ice, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($importe_exento, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($tasa_cero, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($sub_total, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($descuento, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($importe_base, 2, ',', '.')}}</td>
                                <td style="background-color:#EEEAEA">{{number_format($debito_fiscal, 2, ',', '.')}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
