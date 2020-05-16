<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <?php $admin_logo_img = Voyager::setting('empresa.logo', ''); ?>
        @if($admin_logo_img == '')
        <link rel="shortcut icon" href="{{ url('ecommerce_public/images/icon.png') }}" type="image/x-icon">
        @else
        <link rel="shortcut icon" href="{{ url('storage/'.setting('empresa.logo')) }}" type="image/x-icon">
        @endif

        {{-- metadatos para facebook --}}
        @yield('meta-datos')

        {{-- PWA --}}
        @include('ecommerce.layouts.pwa-config')

        <!-- jQuery -->
        <script src="{{ url('ecommerce_public/templates/ecommerce_v1/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

        <!-- Bootstrap4 files-->
        <script src="{{ url('ecommerce_public/templates/ecommerce_v1/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <link href="{{ url('ecommerce_public/templates/ecommerce_v1/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Font awesome 5 -->
        <link href="{{ url('ecommerce_public/templates/ecommerce_v1/fonts/fontawesome/css/all.min.css') }}" type="text/css" rel="stylesheet">

        <!-- custom style -->
        <link href="{{ url('ecommerce_public/templates/ecommerce_v1/css/ui.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('ecommerce_public/templates/ecommerce_v1/css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

        <!-- custom javascript -->
        <script src="{{ url('ecommerce_public/templates/ecommerce_v1/js/script.js') }}" type="text/javascript"></script>

        @yield('plugins')

        @yield('css')
    </head>
    <body>
        @include('ecommerce.ecommerce_v1.layouts.navbar')

        @yield('banner')

        @yield('content')

        <section class="section-name padding-y">
            <div class="container">
                <h3 class="mb-3">Descarga nuestra App</h3>
                <a href="#"><img src="{{ url('img/btn-google-play.png') }}" height="40"></a>
                <a href="#"><img src="{{ url('img/btn-app-store.png') }}" height="40"></a>
            </div>
        </section>

        {{-- Footer --}}
        @include('ecommerce.ecommerce_v1.layouts.footer')

        @yield('script')
    </body>
</html>