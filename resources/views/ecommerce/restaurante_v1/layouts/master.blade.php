<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- <meta name="author" content="Bootstrap-ecommerce by Vosidiy"> --}}
    <link rel="shortcut icon" href="{{ url('storage').'/'.setting('empresa.logo')}}" type="image/x-icon">
    {{-- metadatos para facebook --}}
    @yield('meta-datos')

    {{-- PWA --}}
    @include('ecommerce.layouts.pwa-config')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="{{ url('ecommerce_public/templates/restaurante_v1/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{ url('ecommerce_public/templates/restaurante_v1/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ url('ecommerce_public/templates/restaurante_v1/css/style.css') }}" rel="stylesheet">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
        .principal-color{
            background-color: #312347 !important;
        }
        .text-principal-color{
            color: #312347 !important;
        }
        .result-item-search{
            text-decoration: none
        }
        @media (min-width: 700px) {
            .movil-show {
                display: none !important;
            }
            .movil-hidden {
                display: show !important;
            }
        }
        @media (max-width: 700px) {
            .movil-show {
                display: flex !important;
            }
            .movil-hidden {
                display: none !important;
            }
        }

        /* Alertas ohsanp */
        .oh-alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #eed3d7;
            border-radius: 4px;
            position: fixed;
            bottom: 0px;
            right: 21px;
            /* Each alert has its own width */
            float: right;
            clear: right;
            background-color: white;
            z-index: 1000000;
        }
        .oh-alert-red {
            color: white;
            background-color: #DA4453;
        }
        .oh-alert-green {
            color: white;
            background-color: #37BC9B;
        }
        .oh-alert-blue {
            color: white;
            background-color: #4A89DC;
        }
        .oh-alert-yellow {
            color: white;
            background-color: #F6BB42;
        }
        .oh-alert-orange {
            color:white;
            background-color: #E9573F;
        }
    </style>

  @yield('css')

</head>

<body class="homepage-v1 hidden-sn white-skin animated">

    @yield('navigation')

    @yield('content')

    @yield('footer')

    <!-- ========================= BUSQUEDA ========================= -->
    <form name="form" id="form-search" action="{{route('busqueda_ecommerce')}}" method="post">
        @csrf
        <input type="hidden" name="tipo_busqueda">
        <input type="hidden" name="categoria_id">
        <input type="hidden" name="subcategoria_id">
        <input type="hidden" name="marca_id">
        <input type="hidden" name="min">
        <input type="hidden" name="max">
        <input type="hidden" name="tipo_dato">
        <input type="hidden" name="dato">
        <input type="hidden" name="page">
    </form>
    <!-- ========================= BUSQUEDA // ========================= -->

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="{{ url('ecommerce_public/templates/restaurante_v1/js/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ url('ecommerce_public/templates/restaurante_v1/js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ url('ecommerce_public/templates/restaurante_v1/js/bootstrap.min.js') }}">
    </script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ url('ecommerce_public/templates/restaurante_v1/js/mdb.min.js') }}"></script>

    <script src="{{ url('js/ecommerce.js') }}"></script>

    <script type="text/javascript">
        /* WOW.js init */
        new WOW().init();
        // Tooltips Initialization
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // Material Select Initialization
        $(document).ready(function () {
            $('.mdb-select').material_select();
        });

        // SideNav Initialization
        $(".button-collapse").sideNav();

        count_cart();

    </script>

    @yield('script')
</body>

</html>
