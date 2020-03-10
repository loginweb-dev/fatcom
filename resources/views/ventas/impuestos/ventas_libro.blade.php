@extends('voyager::master')
@section('page_title', 'Libro de ventas')

@if(auth()->user()->hasPermission('browse_ventaslibro'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-book"></i> Libro de ventas
            </h1>
        </div>
    @stop

    @section('content')
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <form id="form-search" action="{{route("ventas_libro_generar")}}" method="post">
                                @csrf
                                <div class="col-md-2 form-group" style="padding:0px">
                                    <label>Mes</label>
                                    <select name="mes" id="" class="form-control" required>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-2" style="padding:0px">
                                    <label>Año</label>
                                    <div class="input-group">
                                        <input type="number" min="2010" step="1" class="form-control" value="{{date('Y')}}" name="anio" required>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" style="margin-top:0px;padding:9px">
                                                <span class="voyager-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="detalle"></div>
        </div>
    @stop

    @section('css')

    @stop

    @section('javascript')
        <script>
            var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
            var loader_request = `  <div style="height:200px;background-color:white" class="text-center">
                                        <br><br><br>
                                        <img src="${loader}" width="100px">
                                        <p>Cargando...</p>
                                    </div>`;
            $(document).ready(function(){
                $('#form-search').on('submit', function(e){
                    $('#detalle').html(loader_request);
                    e.preventDefault();
                    let datos = $(this).serialize();
                    $.ajax({
                        url: '{{route("ventas_libro_generar")}}',
                        type: 'post',
                        data: datos,
                        success: function(data){
                            $('#detalle').html(data);
                        },
                        error: function(){
                            console.log('Error');
                        }
                    });
                });
            });
        </script>
    @stop
@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
