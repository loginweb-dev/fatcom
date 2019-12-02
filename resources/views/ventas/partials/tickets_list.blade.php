<div class="row">
    @foreach ($ventas as $item)
        @php
            $detalle = '';
            foreach($item->productos as $producto){
                $detalle .= intval($producto->cantidad).' '.$producto->nombre.', ';
            }
            // Quitarle la ultima coma y el espacio
            $detalle = substr($detalle, 0, -2);
            // Cortar la cadena a al menos 40 caracteres
            $detalle = substr($detalle, 0, 40);
            // Si la cadena tenía mas de 40 caracteres ponerle al final ...
            $detalle = strlen($detalle) == 40 ? $detalle.'...' : $detalle;
        @endphp
        <div class="col-md-6">
            <div class="card mb-3" id="card-{{ $item->id }}">
                <div class="row no-gutters">
                    <div class="col-md-5 text-center" style="margin-top:20px">
                        <h1 style="font-size:60px">T-{{ $item->nro_venta }}</h1>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                        {{-- <h5 class="card-title">Card title</h5> --}}
                        <p class="card-text" style=" height: 50px">{{ $detalle }}</p>
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
                    }, 900);
                }
            });
        </script>
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
        $(`#card-${id}`).css('border', '10px solid #138A3E');
    }

    function lightOut(id){
        $(`#card-${id}`).css('border', '10px solid rgba(0, 0, 0, 0.7)');
    }
</script>