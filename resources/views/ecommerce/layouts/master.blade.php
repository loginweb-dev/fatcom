<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=604800" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="author" content="Bootstrap-ecommerce by Vosidiy"> --}}
    <link rel="shortcut icon" href="{{url('storage').'/'.setting('empresa.logo')}}" type="image/x-icon">
    {{-- metadatos para facebook --}}
    @yield('meta-datos')

    <link rel="stylesheet" href="{{url('css/style.css')}}">
    
    {{-- PWA --}}
    <!-- CODELAB: Add link rel manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- CODELAB: Add iOS meta tags and icons -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{setting('admin.title')}}">
    <link rel="apple-touch-icon" href="img/icons/icon-152x152.png">
    <!-- CODELAB: Add description here -->
    <meta name="description" content="{{setting('admin.descripcion')}}">
    <!-- CODELAB: Add meta theme-color -->
    <meta name="theme-color" content="#343A40" />

    <script>
        // CODELAB: Register service worker.
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((reg) => {
                    // console.log('Service worker registered.', reg);
                });
            });
        }
    </script>
    {{-- END PWA --}}

    <!-- jQuery -->
    <script src="{{url('ecommerce_public/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>

    <!-- Bootstrap4 files-->
    <script src="{{url('ecommerce_public/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <link href="{{url('ecommerce_public/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Font awesome 5 -->
    <link href="{{url('ecommerce_public/fonts/fontawesome/css/fontawesome-all.min.css')}}" type="text/css" rel="stylesheet">

    <!-- custom style -->
    <link href="{{url('ecommerce_public/css/ui.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('ecommerce_public/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

    <!-- custom javascript -->
    <script src="{{url('ecommerce_public/js/script.js')}}" type="text/javascript"></script>

    {{-- toastr --}}
    <link rel="stylesheet" href="{{url('ecommerce_public/css/toastr.min.css')}}">
    <script src="{{url('ecommerce_public/js/toastr.min.js')}}" type="text/javascript"></script>

    <!-- plugin: fancybox  -->
    <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
    <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">

    <!-- plugin: owl carousel  -->
    <link href="{{url('ecommerce_public/plugins/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{url('ecommerce_public/plugins/owlcarousel/assets/owl.theme.default.css')}}" rel="stylesheet">
    <script src="{{url('ecommerce_public/plugins/owlcarousel/owl.carousel.min.js')}}"></script>

    <style>
        .bg-img {
            background-image: linear-gradient(135deg, rgba(87, 80, 80, 0.438), rgba(0, 0, 0, 0.589)), url("{{ url('storage').'/'.str_replace('\\', '/', setting('admin.bg_image')) }}"); }
    </style>

    <!-- Load Facebook SDK for JavaScript -->
    {{-- <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3"></script> --}}

    <script type="text/javascript">
        // jquery ready start
        $(document).ready(function() {
            toastr.options = {"positionClass": "toast-bottom-right",}
            @if(session('alerta'))
                @switch(session('alerta'))
                    @case('producto_puntuado')
                        toastr.success('Gracias por calificar nuestro productos.', 'Bien hecho!');
                        @break
                    @case('producto_eliminado')
                        toastr.info('Producto eliminado del carrito.', 'Información');
                        @break
                    @case('carrito_vacio')
                        toastr.error('El carrito de compra esta vacío.', 'Error');
                        @break
                    @case('pedido_pendiente')
                        toastr.error('No puede realizar un pedido debido a que tiene uno pendiente.', 'Error');
                        @break

                    @default

                @endswitch
            @endif

            // Colapsar paneles para pantallas pequeñas
            if($(window).width()<768){
                $('#collapse44').collapse('toggle')
                $('#collapse33').collapse('toggle')
                $('#collapse22').collapse('toggle')
                $('.link-page').click(function(){
                    $('#modal_load').modal('show');
                });
                $('#load-bar').css('display', 'none');
            }else{
                $('.link-page').click(function(){
                    $('#load-bar').css('display', 'block');
    		        $('#load-bar .progress-bar').css('width', '98%');
                });
            }

            // Realizar busqueda mediante el panel lateral
            $('.btn-search').click(function(){
                let tipo = $(this).data('tipo');
                let id = $(this).data('id');
                $(`#form-search input[name="${tipo}_id"]`).val(id);
                $(`#form-search input[name="tipo_busqueda"]`).val('click');
                // document.form.submit();
                buscar(1);
            });

            $('#btn-price').click(function(){
                let min = $(`#form-search input[name="min"]`).val();
                let max = $(`#form-search input[name="max"]`).val();
                if(min!='' || max!=''){
                    $(`#form-search input[name="tipo_busqueda"]`).val('click');
                    buscar(1);
                }else{
                    toastr.error('Debe ingresar al menos un dato en el rango de precios.', 'Error');
                }
            });

            // Realizar busqueda mediante el panel superior
            $('#form-search_string').on('submit', function(e){
                e.preventDefault();
                let tipo_dato = $(`#select-tipo`).val();
                let dato = $(`#input-dato`).val();
                $(`#form-search input[name="tipo_busqueda"]`).val('text');
                $(`#form-search input[name="tipo_dato"]`).val(tipo_dato);
                $(`#form-search input[name="dato"]`).val(dato);
                buscar(1);
            });

            // actualizar rango de precios
            $('.input-price').change(function(){
                $(`#form-search input[name="min"]`).val($('#input-min').val());
                $(`#form-search input[name="max"]`).val($('#input-max').val());
            });
            $('.input-price').keyup(function(){
                $(`#form-search input[name="min"]`).val($('#input-min').val());
                $(`#form-search input[name="max"]`).val($('#input-max').val());
            });

        });
        // jquery end

        function agregar(id){
            $.ajax({
                url: `{{url('/carrito/agregar')}}/${id}`,
                type: 'get',
                success: function(data){
                    if(data==1){
                        toastr.info('Producto agregado al carrito.', 'Información');
                        cantidad_carrito();
                    }else{
                        toastr.error('Ocurrio un error al agregar el productos.', 'Error');
                    }
                }
            });
        }

        function cantidad_carrito(){
            $.ajax({
                url: `{{route('cantidad_carrito')}}`,
                type: 'get',
                success: function(data){
                    $('#label-carrito').html(data)
                }
            });
        }

        function cantidad_pedidos(){
            $.ajax({
                url: `{{route('cantidad_pedidos')}}`,
                type: 'get',
                success: function(data){
                    if(data!=0){
                        $('#label-pedidos').html(`Mis pedidos <span class="badge badge-primary round">${data}</span>`)
                    }else{
                        $('#label-pedidos').html(`Mis pedidos`)
                    }
                }
            });
        }

        function buscar(page){
            // document.form.submit()
            $(`#form-search input[name="page"]`).val(page);
            $('#contenido').html(`  <div class="text-center" style="margin-top:120px">
                                        <img src="{{voyager_asset('images/load.gif')}}" width="100px" alt="load.gif">
                                        <h6>Cargando resultados...</h6>
                                    </div>`);
            let min = $(`#form-search input[name="min"]`).val();
            let max = $(`#form-search input[name="max"]`).val();
            if(min!='' && max!=''){
                if(min>max){
                    toastr.error('El rango de precios está mal ingresado.', 'Error');
                    return 0;
                }
            }
            let datos = $('#form-search').serialize();
            $("html,body").animate({scrollTop: $('#contenido').offset().top}, 500);
            $.ajax({
                url: "{{route('busqueda_ecommerce')}}",
                type: 'post',
                data: datos,
                success: function(data){
                    $('#contenido').html(data);
                }
            });
        }

        function categorias(page, id){
            $.ajax({
                url: "{{route('ofertas_ecommerce', ['id'=>"+id+"])}}",
                data: datos,
                success: function(data){
                    $('#contenido').html(data);
                }
            });
        }

        cantidad_carrito();
        @isset(Auth::user()->id)
        cantidad_pedidos();
        @endisset
    </script>

    <style>
        body{
            margin: 0px
        }
        #load-bar{
			position:fixed;
            top:0px;
            left:0px;
            width:100%;
            z-index: 10000;
            /* display: none; */
		}
    </style>

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
            xfbml            : true,
            version          : 'v3.3'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '314624272809898');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=314624272809898&ev=PageView&noscript=1"/></noscript>
    <!-- End Facebook Pixel Code -->

    @yield('chat_facebook')

</head>
<body>
    <!-- ========================= SECTION INTRO ========================= -->
    <header class="section-header">
        <section class="header-main bg padding-y">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="margin-bottom:10px">
                        <a class="brand-wrap link-page" href="{{url('/')}}">
                            <img class="logo" src="{{url('storage').'/'.setting('empresa.logo')}}" alt="loginWeb">
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <form id="form-search_string" class="search-wrap">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" id="input-dato" style="width:55%;" placeholder="Buscar" required>
                                <select class="custom-select"  id="select-tipo" required>
                                    <option value="all">Todos</option>
                                    <option value="p">Producto</option>
                                    <option value="c">Categoría</option>
                                    <option value="m">Marca</option>
                                </select>
                                <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                        <a href="{{url('/carrito')}}" class="widget-header float-md-right link-page">
                            <div class="icontext">
                                <div class="icon-wrap"><i class="fa fa-shopping-cart fa-2x"></i><span id="label-carrito" class="notify">0</span></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </header>

    @include('ecommerce.layouts.menu')
    <div id="load-bar">
        <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    @yield('banner')
    <!-- ========================= SECTION INTRO END// ========================= -->

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content bg padding-y">
        <div class="container">
            <div class="row" style="min-height:400px">
                @yield('content')
            </div>
        </div>
        <!-- ========================= BUSQUEDA ========================= -->
        <form name="form" id="form-search" action="{{route('busqueda_ecommerce')}}" method="post">
            @csrf
            <input type="hidden" name="tipo_busqueda">
            <input type="hidden" name="subcategoria_id">
            <input type="hidden" name="marca_id">
            <input type="hidden" name="min">
            <input type="hidden" name="max">
            <input type="hidden" name="tipo_dato">
            <input type="hidden" name="dato">
            <input type="hidden" name="page">
        </form>
        <!-- ========================= BUSQUEDA // ========================= -->
    </section>

    <!-- ========================= FOOTER ========================= -->
    <footer class="section-footer bg-dark">
        <div class="container">
            <section class="footer-bottom row border-top-white">
                <div class="col-sm-6">
                    <p class="text-white"> Desarrollado por la empresa de tecnolog&iacute;a <a style="font-weight:bold;font-size:18px" class="link-page" target="_blank" href="https://loginweb.net">LoginWeb</a></p>
                </div>
            </section>
        </div>
    </footer>
    <!-- ========================= FOOTER END // ========================= -->

    @include('partials.modal_load')

    {{-- boton de whatsapp--}}
    {{-- <div id="btn-whatsapp"></div> --}}
    <link rel="stylesheet" href="{{url('whatsapp/floating-wpp.css')}}">
    <script src="{{url('whatsapp/floating-wpp.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btn-whatsapp').floatingWhatsApp({
                phone: '591{{setting('empresa.telefono')}}',
                popupMessage: 'Tienes alguna duda?',
                message: "",
                showPopup: true,
                showOnIE: false,
                size: '50px',
                position: 'right',
                headerTitle: '{{setting('empresa.title')}}',
                zIndex: 1111111
            });
        });
    </script>
</body>
</html>
