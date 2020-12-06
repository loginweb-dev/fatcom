@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>Políticas de privacidad - {{ setting('empresa.title') }}</title>
@endsection

@section('navigation')
    @include('ecommerce.restaurante_v1.layouts.nav')
@endsection

@section('content')
    <main class="col-md-12" style="margin-bottom: 50px; margin-top: 50px">
        <div class="col-md-8 offset-md-2 text-justify">
            @include('ecommerce.partials.policies')
        </div>
    </main>
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection