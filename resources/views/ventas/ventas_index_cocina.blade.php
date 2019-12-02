@extends('voyager::master')
@section('page_title', 'Pedidos pendientes')

@if(auth()->user()->hasPermission('browse_ventascocina'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-dashboard"></i> Pedidos pendientes
        </h1>
    @stop
    @section('content')
        <div class="page-content" id="app">
            <div class="page-content browse container-fluid">
               <ventas/>
            </div>
        </div>
    @stop
    @section('css')
        <style>
            .select2{
                border: 1px solid #ddd
            }
            .btn-cambiar_estado{
                padding: 3px 10px
            }
        </style>
    @stop
    @section('javascript')
        <script src="{{asset('js/app.js')}}"></script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
