<div class="row" style="overflow-y: auto;height:320px">
    @php
        $cont = 0;
    @endphp
    @forelse ($productos as $item)
    <div class="card col-md-3 text-center">
        <img class="card-img-top img-producto" style="width:130px;height:100px;cursor:pointer" src="{{url('storage').'/'.$item->imagen}}" alt="Imagen del producto"
        onclick="agregar_detalle_restaurante({{$item->id}}, '{{$item->nombre}}', {{$precios[$cont]['precio']}}, 1000)">

        <div class="card-body" style="padding: 4px">
            <h6 class="card-title" style="padding: 0px">{{$item->nombre}}</h6>
            {{-- <p class="card-text" style="padding: 0px">{{$item->descripcion}}</p> --}}
        </div>
        <div class="card-footer" style="padding: 4px">
            <div class="input-group">
                <input type="number" value="1" min="1" step="1" class="form-control" id="input_cantidad-{{$item->id}}">
                <div class="input-group-btn" >
                    <button type="button" style="margin:0px;padding:5px" onclick="agregar_detalle_restaurante({{$item->id}}, '{{$item->nombre}}', {{$precios[$cont]['precio']}}, 1000)" class="btn btn-success btn-sm">{{$precios[$cont]['precio']}} Bs.</button>
                </div>
            </div>

        </div>
    </div>
    @php
        $cont++;
    @endphp
    @empty
        <br>
        <h5 class="text-center">No existen productos en ésta categoria.</h5>
    @endforelse
</div>
