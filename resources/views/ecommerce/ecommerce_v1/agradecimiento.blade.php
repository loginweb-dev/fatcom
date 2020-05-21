@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Gracias | {{ setting('empresa.title') }}</title>
@endsection

@section('content')
<section class="section-content padding-y bg">
    <div class="container">
        <main class="col-md-12">
            <div class="card text-white bg-success col-md-6 offset-md-3">
                <div class="card-body text-center">
                    <h3 class="card-title">Muchas gracias por tu preferencia!!!</h3>
                    <p class="card-text">Tu pedido estará listo en un momento.</p>
                </div>
            </div>
            <br>
            {{-- <div class="col-md-8 offset-md-2 text-center">
                <a href="{{ route('pedidos_index', ['id'=>$venta_id]) }}" class="btn btn-primary">Ver detalles</a>
            </div> --}}
        </main>
    </div>
@endsection