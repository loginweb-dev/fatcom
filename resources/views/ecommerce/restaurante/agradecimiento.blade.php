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
        <main class="col-md-12">
            <div class="card text-white bg-success col-md-6 offset-md-3">
                <div class="card-body">
                        <h3 class="text-center card-title">Muchas gracias!!!</h3>
                        <p class="card-text text-center">Puede pasar por nuestra tienda cuando desee para recoger su compra.</p>
                </div>
            </div>
        </main>
@endsection
<script>
    setTimeout(function(){
        window.location = "{{url('')}}";
    }, 5000);
</script>
