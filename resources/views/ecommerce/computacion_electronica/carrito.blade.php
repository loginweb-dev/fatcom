@extends('ecommerce.master')

@section('meta-datos')
    <title>Carrito de compra - {{setting('empresa.title')}}</title>
@endsection

@section('banner')
    {{-- <section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">{{setting('empresa.title')}}</h2>
        </div>
    </section> --}}
@endsection

@section('content')
    <main id="contenido" class="col-md-9">
        <div class="card">
            <div class="table-responsive">
                <form id="form_carrito" name="form_carrito" action="{{route('pedidos_store')}}" method="post">
                    @csrf
                    <table class="table table-hover shopping-cart-wrap">
                        <thead class="text-muted">
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col" class="text-right" width="200">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $cont = 0;
                            @endphp
                            @forelse ($carrito as $item)
                            @php
                                $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                            @endphp
                            <tr>
                                <td>{{$item->codigo}}</td>
                                <td>
                                    <figure class="media">
                                        <div class="img-wrap"><img src="{{url('storage').'/'.$imagen}}" class="img-thumbnail img-sm"></div>
                                        <figcaption class="media-body">
                                            <h6 class="title text-truncate">{{$item->nombre}}</h6>
                                            <dl class="dlist-inline small">
                                                <dt>Marca : </dt>
                                                <dd> {{$item->marca}}</dd><br>
                                                <dt>Modelo : </dt>
                                                <dd> {{$item->modelo}}</dd><br>
                                                <dt>Garantía : </dt>
                                                <dd> {{$item->garantia}}</dd>
                                            </dl>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td><input type="number" style="width:100px" class="form-control" onchange="calcular_total()" onkeyup="calcular_total()" name="cantidad[]" id="input-cantidad{{$cont}}" value="1" min="1" step="1"></td>
                                <td>
                                    @php
                                        $precio_actual = $precios[$cont]['precio'];
                                        $precio_anterior = '';
                                        $moneda = $precios[$cont]['moneda'];
                                        if($ofertas[$cont]){
                                            if($ofertas[$cont]->tipo_descuento=='porcentaje'){
                                                $precio_actual -= ($precio_actual*($ofertas[$cont]->monto/100));
                                            }else{
                                                $precio_actual -= $ofertas[$cont]->monto;
                                            }
                                            $precio_anterior = $moneda.' '.$precios[$cont]['precio'];
                                        }
                                    @endphp
                                    <div class="price-wrap">
                                        <var class="price">{{$moneda}} {{$precio_actual}} <del class="price-old" style="font-size:15px">{{$precio_anterior}}</del></var>
                                    </div>
                                    <input type="hidden" class="form-control" name="precio[]" value="{{$precio_actual}}" id="input-precio{{$cont}}">
                                </td>
                                <td class="text-right">
                                    <a href="{{url('carrito/borrar').'/'.$item->id}}" class="btn btn-outline-danger"> <span class="fa fa-trash"></span> Borrar</a>
                                </td>
                            </tr>
                            @php
                                $total += $precio_actual;
                                $cont++;
                            @endphp
                            @empty
                            <tr>
                                <td colspan="5" class="text-center"><span>No se han agregados productos al carro.</span></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
        </div> <!-- card.// -->
    </main>
    <aside class="col-md-3">
            {{-- <dl class="dlist-align">
                <dt>Total price: </dt>
                <dd class="text-right">USD 568</dd>
            </dl>
            <dl class="dlist-align">
                <dt>Discount:</dt>
                <dd class="text-right">USD 658</dd>
            </dl> --}}
            <dl class="dlist-align h4">
                <dt>Total:</dt>
                <dd class="text-right"><strong id="label-total">Bs. {{number_format($total, 2, '.', '')}}</strong></dd>
            </dl>
            <hr>
            <div class="custom-control custom-radio">
                <input type="radio" checked id="tienda" name="customRadio" class="custom-control-input">
                <label class="custom-control-label" for="tienda">Recoger en tienda</label>
            </div><br>
            <div class="custom-control custom-radio">
                <input type="radio" disabled id="delivery" name="customRadio" class="custom-control-input">
                <label class="custom-control-label" title="No disponible en este momento" for="delivery">Entrega a domicilio</label>
            </div>
            <hr>
            <div class="text-right">
                <button type="button" onclick="enviar_carrito()" class="btn btn-outline-success">Comprar <span class="fa fa-shopping-cart"></span> </button>
            </div>
    </aside> <!-- col.// -->
@endsection
<script>
    let cantidad = parseInt('{{$cont}}');
    function calcular_total(){
        let total = 0;
        for (let i = 0; i < cantidad; i++) {
            total += parseInt($('#input-cantidad'+i).val()) * $('#input-precio'+i).val();
        }
        $('#label-total').html('Bs. '+total.toFixed(2));
    }

    function enviar_carrito(){
        document.form_carrito.submit()
    }
</script>
