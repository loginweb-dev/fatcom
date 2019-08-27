@foreach ($productos as $item)
        @if (!$item->se_almacena || ($item->se_almacena && $item->stock > 0))
            @php
                $imagen = (!empty($item->imagen)) ? url('storage').'/'.str_replace('.', '_small.', $item->imagen) : url('storage/productos/default.png');
            @endphp
            <div class="card col-md-3 text-center" style="margin:5px 0px">
                <img class="card-img-top img-producto" id="producto-{{$item->id}}" style="width:130px;height:100px;cursor:pointer" src="{{$imagen}}" alt="{{$item->nombre}}"
                @if(!$item->se_almacena) onclick="combinar_producto({{$item->id}}, '{{$item->nombre}}')" @endif
                ondblclick="agregar_producto({{$item->id}})">

                <div class="card-body" style="padding: 4px">
                    <h4 class="card-title" style="padding: 0px"> <label class="label label-primary">{{$item->nombre}}</label> </h4>
                </div>
            </div>
        @endif
@endforeach
