<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('storage').'/'.setting('empresa.logo')}}" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('nombre_pagina')

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- jQuery -->
    {{-- <script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script> --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Font awesome 5 -->
    <link href="{{url('ecommerce_public/fonts/fontawesome/css/fontawesome-all.min.css')}}" type="text/css" rel="stylesheet">

    {{-- Select2 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <!-- custom style -->
    <link href="{{url('ecommerce_public/css/ui.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('ecommerce_public/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

    <!-- custom javascript -->
    <script src="{{url('ecommerce_public/js/script.js')}}" type="text/javascript"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- toastr --}}
    <link rel="stylesheet" href="{{url('ecommerce_public/css/toastr.min.css')}}">
    <script src="{{url('ecommerce_public/js/toastr.min.js')}}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
        toastr.options = {"positionClass": "toast-bottom-right",}
        @if(session('alerta'))
            @switch(session('alerta'))
                @case('cliente_editado')
                    toastr.success('Información actualizada exitosamente.', 'Bien hecho!');
                    @break

                @default

            @endswitch
        @endif
        });
    </script>
</head>
<body>
    <div id="app">
        @include('ecommerce.layouts.menu')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@yield('css')
@yield('script')
</html>
