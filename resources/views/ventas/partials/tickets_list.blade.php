<div class="row">
    @php
        // Vaiable para controlar que no se desforme el CSS
        $pedido_visualizado = true;
    @endphp
    @foreach ($ventas as $item)
        @php
            $detalle = '';
            foreach($item->productos as $producto){
                $detalle .= intval($producto->cantidad).' '.$producto->nombre.', ';
            }
            // Quitarle la ultima coma y el espacio
            $detalle = substr($detalle, 0, -2).'.';
        @endphp
        <div    class="
                        @if($pedido_visualizado)
                        col-md-12
                        @else
                        col-md-6
                        @endif
                    "
        >
            <div class="card mb-3 @if($item->venta_estado_id==3) ticket-active @endif" id="card-{{ $item->id }}">
                <div class="row no-gutters" style="@if($pedido_visualizado) margin-top:20px @endif">
                    <div class="col-md-12" style="@if($pedido_visualizado) height:420px @endif">
                        <h1 class="text-center" style="@if($pedido_visualizado) font-size:250px @else font-size:80px @endif">T-{{ $item->nro_venta }}</h1>
                        @if($pedido_visualizado)
                        <p class="card-text" style="margin:10px;font-size:30px;white-space: nowrap;"><small>{{ $detalle }}</small></p>
                        <p class="card-text text-right" style="margin:10px;font-size:25px"><small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></p>
                        @else
                        <p class="card-text text-right" style="margin-right:10px;font-size:20px"><small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @php
            // Se creo una variable auxiliar para evitar que varios tickets se pogan en tamaño grande al mismo tiempo y no desformar el CSS
            $pedido_visualizado = false;
        @endphp
    @endforeach
</div>

<style>
    .card{
        background-color:rgba(0, 0, 0, 0.7);
        color:white;
        border: 10px solid rgba(0, 0, 0, 0.7);
    }
    .ticket-active{
        animation: colorchange 3s infinite; /* animation-name followed by duration in seconds*/
         /* you could also use milliseconds (ms) or something like 2.5s */
        -webkit-animation: colorchange 3s infinite; /* Chrome and Safari */
    }
    @keyframes colorchange
    {
        0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        20%   {border: 10px solid #FB3532;}
        80%  {border: 10px solid rgba(0, 0, 0, 0.7);}
    }

    @-webkit-keyframes colorchange /* Safari and Chrome - necessary duplicate */
    {
        0%  {border: 10px solid rgba(0, 0, 0, 0.7);}
        25%   {border: 10px solid #FB3532;}
        75%  {border: 10px solid rgba(0, 0, 0, 0.7);}
    }
</style>