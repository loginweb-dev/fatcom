@extends('voyager::master')
@section('page_title', 'Editar Cliente')

@if(auth()->user()->hasPermission('edit_clientes'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-people"></i> Editar Cliente
        </h1>
    @stop

    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <form action="{{route('clientes_update')}}" method="post">
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$cliente->id}}">
                                    {{-- <input type="hidden" name="user_id" value="{{$user ? $user->id : ''}}"> --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Nombre o razón social</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre o razón social del cliente. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="razon_social" class="form-control" value="{{ $cliente->razon_social }}" placeholder="Nombre o razón social del cliente" required>
                                                    @error('razon_social')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">NIT o CI</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="NIT o CI del cliente. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="nit" class="form-control" value="{{ $cliente->nit }}" placeholder="NIT o CI">
                                                    @error('nit')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Movil</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número de celular del cliente. Este campo no es obligatorio."></span> @endif
                                                    <input type="number" name="movil" class="form-control" value="{{ $cliente->movil }}" placeholder="Número celular" maxlength="20">
                                                    @error('movil')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Dirección</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Dirección del cliente. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="direccion" class="form-control" value="{{ $cliente->direccion }}" placeholder="Dirección del cliente" maxlength="20">
                                                    @error('direccion')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel-group">
                                                        <div class="panel panel-default">
                                                          <div class="panel-heading">
                                                            <h3 class="panel-title" style="padding:5px">
                                                                <a data-toggle="collapse" href="#collapse1">Seleccionar ubicación <i class="voyager-location"></i></a>
                                                            </h3>
                                                          </div>
                                                          <div id="collapse1" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-12" id="contentMap"></div>
                                                                    <div class="col-md-12">
                                                                        <input type="hidden" name="ubicacion" value="{{ $cliente->ubicacion }}" id="input-ubicacion">
                                                                        <textarea name="descripcion" id="" class="form-control" rows="3" placeholder="Descripción">{{ $cliente->descripcion }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Email</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Email del cliente para iniciar sesión en el sistema. Este campo solo es obligatorio si se va a crear una cuenta al cliente."></span> @endif
                                                    <input type="email" name="email" class="form-control" value="{{$user ? $user->email : ''}}" placeholder="Email" maxlength="50">
                                                    @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Password</label> <small>(Dejar vacío para mantener el mismo)</small> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Contraseña del cliente para iniciar sesión en el sistema, el usuario tiene la opción de cambiar su contraseña cuando desee. Este campo solo es obligatorio si se va a crear una cuenta al cliente."></span> @endif
                                                    <input type="password" name="password" class="form-control" placeholder="Password" maxlength="20">
                                                    @error('password')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <style>
            #mapid { height: 400px; }
        </style>
    @stop

    @section('javascript')
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

            $("#collapse1").on('show.bs.collapse', function(){
                setTimeout(()=>renderMap(), 200);
            });
        });

        function renderMap(){
            
            $('#contentMap').html('<div id="mapid"></div>')
            var mymap = L.map('mapid').setView([-14.835, -64.902], 13);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 20,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(mymap);
            
            // Obtener coordanadas actuales del cliente
            let marcador = '{{ $cliente->ubicacion }}';
            let coordenadas = marcador.split(',');

            var marker = coordenadas.length > 1 ? L.marker([coordenadas[0],coordenadas[1]]).addTo(mymap) : L.marker();
            mymap.on('click', function(e) {
                marker
                    .setLatLng(e.latlng)
                    .addTo(mymap);
                    $('#input-ubicacion').val(`${e.latlng.lat},${e.latlng.lng}`)
                // console.log('Latitud: '+e.latlng.lat)
                // console.log('Longitud: '+e.latlng.lng)
            });
        }
    </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
