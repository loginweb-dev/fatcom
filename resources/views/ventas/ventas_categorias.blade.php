<div class="row" style="overflow-y: auto;height:370px">
    <div class="panel-group" id="accordion">
        @forelse ($subcategorias as $item)
            <div class="panel panel-default" style="margin:0px">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$item->id}}" onclick="cargar_productos('{{$item->id}}')" style="cursor:pointer">
                    <h4 class="panel-title">{{$item->nombre}}</h4>
                </div>
                <div id="collapse{{$item->id}}" class="panel-collapse collapse">
                    <div class="panel-body" id="body-collapse{{$item->id}}"></div>
                </div>
            </div>
        @empty
            <br>
            <h5 class="text-center">No existen productos en ésta categoria.</h5>
        @endforelse
    </div>
</div>

<script>
    $(document).ready(function(){
        
    });

    function cargar_productos(id){
        $.get('{{url("admin/ventas/crear/ventas_productos_categorias")}}/'+ id, function(data){
            $('#body-collapse'+id).html(data);
        });
    }
</script>
