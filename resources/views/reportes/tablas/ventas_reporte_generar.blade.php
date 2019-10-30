
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="col-md-12 text-right">
                <form action="{{route('ventas_reporte_pdf')}}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="fecha" value="{{$fecha}}">
                    <button type="submit" href="" class="btn btn-danger">PDF</button>
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
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
                                <td colspan="5" class="text-center">No existen ventas</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="4"><b style="font-weight:bold">TOTAL</b></td>
                                <td><b style="font-weight:bold">{{number_format($total, 2, ',', '')}} Bs.</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
