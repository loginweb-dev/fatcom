<div class="row" style="overflow-y: auto;height:320px">
    <div class="panel-group" id="accordion">
        @forelse ($subcategorias as $item0)
            @php
                $class = '';
                $cont = 0;
            @endphp
            <div class="panel panel-default" style="margin:0px">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$item0->id}}" style="cursor:pointer">
                    <h4 class="panel-title">{{$item0->nombre}}</h4>
                </div>

                {{-- <h4 class="text-primary">{{$item0->nombre}}<hr style="margin:0px"></h4> --}}
                <div id="collapse{{$item0->id}}" class="panel-collapse collapse {{$class}}">
                    <div class="panel-body">
                        @foreach ($productos as $item)
                            @if($item0->id==$item->subcategoria_id)
                                @php
                                    $imagen = (!empty($item->imagen)) ? url('storage').'/'.$item->imagen : url('storage/productos/default.png');
                                @endphp
                                <div class="card col-md-3 text-center" style="margin:5px 0px">
                                    <img class="card-img-top img-producto" id="producto-{{$item->id}}" style="width:130px;height:100px;cursor:pointer" src="{{$imagen}}" alt="Imagen del producto"
                                    onclick="combinar_producto({{$item->id}}, '{{$item->nombre}}', {{$precios[$cont]['precio']}}, 1000, '')" ondblclick="agregar_detalle_restaurante({{$item->id}}, '{{$item->nombre}}', {{$precios[$cont]['precio']}}, 1000, '', '')">

                                    <div class="card-body" style="padding: 4px">
                                        <h6 class="card-title" style="padding: 0px">{{$item->nombre}}</h6>
                                        {{-- <p class="card-text" style="padding: 0px">{{$item->descripcion}}</p> --}}
                                    </div>
                                    <div class="card-footer" style="padding: 4px">
                                        <div class="input-group">
                                            <input type="number" value="1" min="1" step="1" class="form-control" id="input_cantidad-{{$item->id}}">
                                            <div class="input-group-btn" >
                                                <button type="button" style="margin:0px;padding:5px" onclick="agregar_detalle_restaurante({{$item->id}}, '{{$item->nombre}}', {{$precios[$cont]['precio']}}, 1000, '', '')" class="btn btn-success btn-sm">{{$precios[$cont]['precio']}} Bs.</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            @php
                                $cont++;
                            @endphp
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        @empty
            <br>
            <h5 class="text-center">No existen productos en ésta categoria.</h5>
        @endforelse
    </div>
</div>
