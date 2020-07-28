@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>Políticas de privacidad - {{ setting('empresa.title') }}</title>
@endsection

@section('content')
    <main class="col-md-12" style="margin-bottom: 50px">
        <div class="col-md-8 offset-md-2 text-justify">
            @include('ecommerce.partials.policies')
        </div>
    </main>
@endsection