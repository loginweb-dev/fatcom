<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- <meta name="author" content="Bootstrap-ecommerce by Vosidiy"> --}}
    <link rel="shortcut icon" href="{{ url('storage').'/'.setting('empresa.logo')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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

    {{-- Sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Material Design Bootstrap -->
    <link href="{{ url('ecommerce_public/templates/restaurante_v1/css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ url('ecommerce_public/templates/restaurante_v1/css/style.css') }}" rel="stylesheet">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
        .principal-color{
            background-color: #FBBC00 !important;
        }
        .text-principal-color{
            color: #FBBC00 !important;
        }
        .result-item-search{
            text-decoration: none
        }
        @media (min-width: 768px) {
            .movil-show {
                display: none !important;
            }
            .movil-hidden {
                display: show !important;
            }
        }
        @media (max-width: 768px) {
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

    {{-- Float ShoppingCart --}}
    
        <a href="{{ route('carrito_compra') }}">
            <div class="principal-color movil-show" style="position: fixed; bottom: 10px; left: 10px; z-index: 100; width: 60px; height: 60px; border-radius: 30px; border: 1px solid #D49F00">
                <div style="margin-top: 15px; margin-left: 5px">
                    <i class="fas fa-shopping-cart black-text" style="font-size: 25px"></i>
                    <span class="badge danger-color label-count-cart">0</span>
                </div>
            </div>
        </a>

    <!-- ========================= BUSQUEDA ========================= -->
    <form name="form" id="form-search" action="{{route('busqueda_ecommerce')}}" method="post">
        @csrf
        <input type="hidden" name="tipo_busqueda" value="click">
        <input type="hidden" name="categoria_id">
        <input type="hidden" name="subcategoria_id">
        <input type="hidden" name="marca_id">
        <input type="hidden" name="min">
        <input type="hidden" name="max">
        <input type="hidden" name="tipo_dato">
        <input type="hidden" name="dato">
        <input type="hidden" name="page">
        {{-- <button type="submit">ok</button> --}}
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

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="{{ url('js/rich_select.js') }}"></script>
    <script src="{{ url('js/ecommerce.js') }}"></script>

    <script type="text/javascript">
        /* WOW.js init */
        new WOW().init();
        // Tooltips Initialization
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        // Material Select Initialization
        $(document).ready(function () {
            $('.mdb-select').material_select();

            $('.btn-info-ios').click(function(e){
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'App en desarrollo',
                    text: 'La versión para IOS de nuestra aplicación aún no se encuentra disponible, agradecemos su paciencia!',
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> Entendido!',
                    footer: '<a href="mailto: {{ setting('empresa.email') }}" target="_blank">Envíanos tus recomendaciones</a>'
                });
            });
        });

        // SideNav Initialization
        $(".button-collapse").sideNav();

        count_cart();

        // search(1);

    </script>

    @yield('script')
</body>

</html>
