@if(auth()->user()->hasPermission('browse_ventastickets'))
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tickets</title>

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background: url("{{ url('storage/'.setting('admin.tickets_image')) }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y:hidden
            /* margin: 0;
            padding: 0; */
        }
        .title{
            font-size: 50px;
            color: white;
            margin-top: 20px
        }
        .footer{
            position:fixed;
            bottom:0px;
            left:0px;
            background-color:rgba(0, 0, 0, 0.6);
            width: 100%
        }
        .footer-content{
            margin: 10px 20px;
            color: white
        }
        iframe{
            background-color: white
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-12" id="data" style="margin-top:20px;overflow-y:hidden"></div>
            </div>
            <div class="col-md-4 text-right">
                <div class="row">
                    <h1 class="title">{{ setting('empresa.title') }} <img src="{{ url('storage').'/'.setting('empresa.logo') }}" width="100px" alt=""></h1>
                </div>
                <div class="row" style="margin-top:20px" id="data-posts"></div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-content">
                Powered By <b>Loginweb</b>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        var ventana_alto = $(window).height();
        $(document).ready(function(){
            $('#data').css('height', ventana_alto-30)
            get_data();
            get_post();
        });

        // Obtener tickets
        function get_data(){
            $.get('{{ url("admin/ventas/tickets/list") }}', function(data){
                $('#data').html(data);
            });
        }

        // Obtener publicaciones
        function get_post(){
            // Numero aleatorio entre 0 y 99
            let randon_number = parseInt(Math.random().toFixed(2)*100);
            
            let url = randon_number === 10 ? '' : '{{ url("admin/ventas/tickets/posts") }}';
            if(url){
                $.get(url, function(data){
                    $('#data-posts').html(data.contenido);
                    setTimeout(() => {
                        get_post();
                    }, data.duracion*1000);
                });
            }else{
                console.log('Get API LoginWeb')
            }
            
        }
    </script>

    {{-- Laravel Echo --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Echo.channel('ticketSucursal{{ $sucursal_id }}')
        .listen('ticketsSucursal', (e) => {
            get_data()
        });
    </script>
</body>
</html>

@else
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Error</title>
    </head>
    <body>
        <h1>Acceso denegado!</h1>
    </body>
    </html>
@endif