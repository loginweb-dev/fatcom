<div id="lista" class="row" style="overflow-y: auto;@if(setting('delivery.activo')) height:370px @else height:300px @endif">
    <div class="input-group col-md-6 pull-right">
        <input type="text" id="search_value" class="form-control" placeholder="Nombre la de sub categoría">
        <span class="input-group-btn">
            <button class="btn btn-default" id="btn-search" style="margin-top:0px;padding:8px 10px" type="button">
                <i class="voyager-search"></i>
            </button>
        </span>
    </div>
    <div class="clearfix"></div>
    <div class="panel-group" id="accordion">
        @forelse ($subcategorias as $item)
            <div class="panel panel-default" style="margin:0px">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$item->id}}" onclick="cargar_productos('{{$item->id}}')" style="cursor:pointer">
                    <h4 class="panel-title">{{ strtoupper($item->nombre) }}</h4>
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
<style>
    #load-bar-venta{
        position:relative;
        top:-15px;
        left:-15px;
        width:105%;
        z-index: 10000;
    }
</style>
<script>
    $(document).ready(function(){
        $("#btn-search").click(function() {
            search_categoria();
        });
        $('#search_value').keypress(function(e){
            if(e.which == 13) {
                search_categoria();
                return false;
            }
        });
    });

    function cargar_productos(id){
        $('#body-collapse'+id).html(` <div id="load-bar-venta">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" style="background-color:#096FA9" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>`);
        setTimeout(()=>{
            $('#load-bar-venta').css('display', 'block');
            $('#load-bar-venta .progress-bar').css('width', '97%');
        }, 50);


        $.get('{{url("admin/ventas/crear/ventas_productos_categorias")}}/'+ id, function(data){
            $('#body-collapse'+id).html(data);
        });
    }

    // Buscar texto en categoria
    function search_categoria(){
        let value = $('#search_value').val().toUpperCase();
        let posicion = $(`h4:contains('${value}')`).parent().first().offset();
        if(posicion){
            $(`h4:contains('${value}')`).parent().first().css('color', '#7E95EA');
            $("#lista").animate({
                scrollTop: posicion.top - 250
            }, 500);
        }else{
            toastr.warning('Sub categoría no encontrada', 'Advertencia');
        }
    }
</script>
