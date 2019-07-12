@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-code"></i> Código de Control
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="alert alert-info">
            <strong>Información:</strong>
            <p>En el siguiente formulario podrás realizar la verificación del codigo de control de tus facturas, ingresando los creadenciales que te brinda el SIN.</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form id="form">
                            @csrf
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label>N&deg; de autorización</label>
                                    <input type="number" name="numero_autorizacion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>N&deg; de factura</label>
                                    <input type="number" name="numero_factura" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>NIT</label>
                                    <input type="number" name="nit" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number" min="1" step="0.01" name="monto" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Clave de dosificación</label>
                                    <textarea name="dosificacion" class="form-control" required></textarea>
                                </div>
                                <div class="text-right">
                                    <button type="reset" class="btn btn-default">Vaciar</button>
                                    <button type="submit" class="btn btn-primary">Generar</button>
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

@stop

@section('javascript')
    <script>
        $(document).ready(function(){
            $('#form').on('submit', function(e){
                e.preventDefault();
                let datos = $(this).serialize();
                $.ajax({
                    url: "{{route('generar_codigo_control')}}",
                    type: 'post',
                    data: datos,
                    success: function(data){
                        alert('Codigo de control: '+data)
                        $('#form')[0].reset();
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
@stop
