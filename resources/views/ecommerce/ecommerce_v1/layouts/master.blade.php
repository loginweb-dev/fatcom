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

        {{-- Script del chat de facebook --}}
        @yield('chat_facebook')

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
        <script src="{{ url('js/ecommerce.js') }}" type="text/javascript"></script>

        {{-- SweetAlert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script>
            count_cart();
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        </script>

        @yield('plugins')

        <style>
            #loading-mask{
                display:none;
                position:absolute;
                width:100%;
                height:100%;
                justify-content: center;
                align-items: center;
            }
            .loader-text{
                padding: 20px;
                background-color:rgba(0, 0, 0, 0.6);
                width:200px;
                color:white;
                border-radius: 5px
            }
            .main-loader{
                position: fixed;
                top:50%;
                left:50%;
                /*determinamos una anchura*/
                width:200px;
                /*indicamos que el margen izquierdo, es la mitad de la anchura*/
                margin-left:-100px;
                /*determinamos una altura*/
                height:100px;
                /*indicamos que el margen superior, es la mitad de la altura*/
                margin-top:-50px;
                padding:5px;
                z-index: 10;
                display: none;
            }
            .text-loader{
                position: relative;
                padding: 20px;
                background-color:rgba(0, 0, 0, 0.6);
                /* width:200px; */
                color:white;
                border-radius: 5px
            }
        </style>

        @yield('css')
    </head>
    <body>
        @include('ecommerce.ecommerce_v1.layouts.navbar')

        @yield('banner')

        @yield('content')

        <div class="main-loader">
            <div class="d-flex justify-content-center text-loader">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <div style="padding: 5px 10px"> Cargando...</div>
            </div>
        </div>

        <section class="section-name padding-y">
            <div class="container">
                <h3 class="mb-3">Descarga nuestra App</h3>
                <a href="#"><img src="{{ url('img/btn-google-play.png') }}" height="40"></a>
                <a href="#"><img src="{{ url('img/btn-app-store.png') }}" height="40"></a>
            </div>
            {{-- Formulario de busqueda --}}
            @include('ecommerce.layouts.form-search')
        </section>

        {{-- Footer --}}
        @include('ecommerce.ecommerce_v1.layouts.footer')

        @yield('script')
    </body>
</html>