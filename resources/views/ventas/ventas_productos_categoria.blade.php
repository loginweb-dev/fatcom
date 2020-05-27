@foreach ($productos as $item)
        @if (!$item->se_almacena || ($item->se_almacena && $item->stock > 0))
            @php
                $imagen = (!empty($item->imagen)) ? url('storage').'/'.str_replace('.', '_small.', $item->imagen) : url('../img/default.png');
            @endphp
            <div class="card col-md-3 col-sm-4 text-center" style="margin:5px 0px">
                <img class="card-img-top img-producto" id="producto-{{$item->id}}" style="width:130px;height:100px;cursor:pointer" src="{{$imagen}}" alt="{{$item->nombre}}"
                @if(!$item->se_almacena) onclick="combinar_producto({{$item->id}}, '{{$item->nombre}}')" @endif
                ondblclick="agregar_producto({{$item->id}})">

                <div class="card-body" style="padding: 4px">
                    <h4 class="card-title" style="padding: 0px"> <label class="label label-primary">{{$item->nombre}}</label> </h4>
                    {{-- Detalles del producto --}}
                    @if (setting('admin.modo_sistema') == 'boutique')
                    <table width="100%" style="align:leftfont-size:12px">
                        <tr>
                            <td>Marca</td><td>:</td><td><b>{{ $item->marca }}</b></td>
                        </tr>
                        <tr>
                            <td>Talla</td><td>:</td><td><b>{{ $item->talla }}</b></td>
                        </tr>
                        <tr>
                            <td>Genero</td><td>:</td><td><b>{{ $item->genero }}</b></td>
                        </tr>
                        <tr>
                            <td>Código</td><td>:</td><td><b>{{ $item->codigo_interno }}</b></td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
        @endif
@endforeach
