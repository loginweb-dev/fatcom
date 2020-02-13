
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="col-md-12 text-right">
                <form action="{{route('ventas_reporte_pdf')}}" method="post" target="_blank">
                    @csrf
                    {{-- <input type="hidden" name="fecha" value="{{$fecha}}"> --}}
                    {{-- <button type="submit" href="" class="btn btn-danger">PDF</button> --}}
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Precio</th>
                                <th>cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @forelse ($ventas as $item)
                            @php
                                $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                                $imagen = ($item->imagen!='') ? $item->imagen : 'productos/default.png';
                                $total += $item->precio*$item->cantidad;
                            @endphp
                            <tr>
                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td rowspan="6" width="105px"><a href="{{ url('storage').'/'.$imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{ url('storage').'/'.$img }}" width="100px" alt=""></a></td></td>
                                        </tr>
                                        <tr><td><h4>{{ $item->nombre }}</h4></td></tr>
                                        <tr><td><small><b>Categoría</b> : {{ $item->subcategoria }}</td></small></tr>
                                        @if(setting('admin.modo_sistema')!='restaurante')
                                        <tr><td><small><b>Marca</b> : {{ $item->subcategoria }}</td></small></tr>
                                        @endif
                                        @if(setting('admin.modo_sistema')=='boutique')
                                        <tr><td><small><b>Talla</b> : {{ $item->subcategoria }}</td></small></tr>
                                        <tr><td><small><b>Color</b> : {{ $item->subcategoria }}</td></small></tr>
                                        @endif
                                    </table>
                                </td>
                                <td>{{ $item->precio }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ number_format($item->precio*$item->cantidad, 2, ',', '') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No existen ventas</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="3"><h4>TOTAL</h4></td>
                                <td><h4>{{ number_format($total, 2, ',', '') }} Bs.</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>