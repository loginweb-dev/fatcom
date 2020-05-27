@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Mis pedidos | {{ setting('empresa.title') }}</title>
@endsection

@section('content')
@php
    $section = Templates::section(16);
    $block = $section->blocks;
@endphp
<section class="section-pagetop bg" style="background-color: {{ $section ? $section->background : '#fff' }};">
    <div class="container">
        <h2 class="title-page" style="color: {{ $section ? $section->color : '#000' }}">{{ $block ? $block->titulo : 'Métodos de pago' }}</h2>
        <p class="lead" style="color: {{ $section ? $section->color : '#000' }}">{{ $block ? $block->descripcion : '' }}</p>
    </div>
</section>
<section class="section-content padding-y">
    <div class="container">
        <div class="row">
            @forelse (Templates::section(17)->blocks as $item)
            <div class="col-md-4">
                <div class="card-deck mb-3 text-center">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="my-0">{{ $item->titulo }}</h5>
                        </div>
                        <img src="{{ url('storage/'.$item->imagen) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3 class="card-title pricing-card-title">{{ $item->numero }}</h3>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>{{ $item->titular }}</li>
                                <li>{{ $item->tipo }}</li>
                                <li>{{ $item->cedula }}</li>
                                <li>{{ $item->moneda }}</li>
                            </ul>
                            {{-- <a href="#" class="btn  btn-block btn-outline-primary">Sign up for free</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            @empty
                    
            @endforelse
        </div>
    </div>
</section>
@endsection

@section('css')
    <style>
        
    </style>  
@endsection

@section('script')
@endsection


