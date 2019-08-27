
<div class="row">
    <div class="col-md-12" style="margin:0px">
        {{-- <div class="panel">
            <div class="row"> --}}
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Código</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->codigo}}</p>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->nombre}}</p>
                            </div>
                        </div>
                    </div>
                    <hr style="margin:0;">
                    <div class="row">
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Subcategoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->subcategoria}}</p>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Marca</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->marca}}</p>
                            </div>
                        </div>
                    </div>
                    <hr style="margin:0;">
                    <div class="row">
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estante</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->estante}}</p>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin:0px">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Bloque</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$producto->bloque}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap" style="text-align:center">
                            @php
                                $img = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                                $img_big = ($producto->imagen!='') ? $producto->imagen : 'productos/default.png';
                            @endphp
                            <a id="img-slider" href="{{url('storage').'/'.$img_big}}" data-fancybox="slider1">
                                <img id="img-medium" class="img-thumbnail img-sm" src="{{url('storage').'/'.$img}}">
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        {{-- </div>
    </div> --}}
</div>


<link href="{{url('ecommerce/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
<!-- custom style -->
<link href="{{url('ecommerce/css/ui.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('ecommerce/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

<script src="{{url('ecommerce/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){

        // cambiar imagen de muestra
        $('.img-gallery').click(function(){
            let img_medium = $(this).data('img').replace('_small', '_medium');
            let img = $(this).data('img').replace('_small', '');
            $('#img-medium').attr('src', img_medium);
            $('#img-slider').attr('href', img);
        });
    });
</script>

