<div class="row">
    @php
        // Vaiable para controlar que no se desforme el CSS
        $pedido_visualizado = false;
    @endphp
    @foreach ($ventas as $item)
        @php
            $detalle = '';
            foreach($item->productos as $producto){
                $detalle .= intval($producto->cantidad).' '.$producto->nombre.', ';
            }
            // Quitarle la ultima coma y el espacio
            $detalle = substr($detalle, 0, -2);
            // Cortar la cadena a al menos 40 caracteres
            $detalle = substr($detalle, 0, 50);
            // Si la cadena tenía mas de 40 caracteres ponerle al final ...
            $detalle = strlen($detalle) == 50 ? $detalle.'...' : $detalle;
        @endphp
        <div    class="
                        @if($item->venta_estado_id == 3 && !$pedido_visualizado)
                        col-md-12
                        @else
                        col-md-6
                        @endif
                    "
        >
            <div class="card mb-3" id="card-{{ $item->id }}" style="@if($item->venta_estado_id == 3 && !$pedido_visualizado) height:400px @endif">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center" style="margin-top:20px">
                        <h1 style="@if($item->venta_estado_id == 3 && !$pedido_visualizado) font-size:250px @else font-size:80px @endif">T-{{ $item->nro_venta }}</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                        {{-- <h5 class="card-title">Card title</h5> --}}
                        <p class="card-text" style="@if($item->venta_estado_id == 3 && !$pedido_visualizado) font-size:40px @else height: 50px @endif">{{ $detalle }}</p>
                        <p class="card-text"><small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                if('{{ $item->venta_estado_id }}' == 3){
                    light('{{ $item->id }}');
                    setTimeout(() => {
                        lightOut('{{ $item->id }}');
                    }, 2000);
                }
            });
        </script>
        @php
            // Se creo una variable auxiliar para evitar que varios tickets se pogan en tamaño grande al mismo tiempo y no desformar el CSS
            if($item->venta_estado_id == 3){
                $pedido_visualizado = true; 
            }
        @endphp
    @endforeach
</div>

<style>
    .card{
        background-color:rgba(0, 0, 0, 0.7);
        color:white;
        border: 10px solid rgba(0, 0, 0, 0.7);
    }
</style>

<script>
    function light(id){
        $(`#card-${id}`).css('border', '10px solid #FB3532');
    }

    function lightOut(id){
        $(`#card-${id}`).css('border', '10px solid rgba(0, 0, 0, 0.7)');
    }
</script>