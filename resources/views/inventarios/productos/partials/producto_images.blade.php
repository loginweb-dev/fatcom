<button type="button" class="btn col-md-3" title="Agregar imagen(es)" data-toggle="modal" data-target="#dropzone_modal">
    <h1 style="font-size:40px;margin:10px"><span class="voyager-plus"></span></h1>
</button>
@foreach ($imagenes as $item)
    @php
        $img = str_replace('.', '_small.', $item->imagen);
        $img_big = $item->imagen;
    @endphp
    <div class="col-md-3" id="marco-{{$item->id}}">
        <div style="position:absolute;z-index:1;">
            <label class="label label-danger btn-delete_img" data-toggle="modal" data-id="{{$item->id}}" data-target="#modal_delete" style="cursor:pointer;@if($item->tipo=='principal') display:none @endif"><span class="voyager-x"></span></label>
        </div>
    <img src="{{url('storage').'/'.$img}}" style="width:100%;@if($item->tipo!='principal') cursor:pointer @endif;border:3px solid #2ECC71" id="image-{{$item->id}}" title="{{ ($item->tipo=='principal') ? 'Imagen principal' : 'Click para hacer imagen principal' }}" class="img-thumbnail img-sm img-gallery item-gallery" data-id="{{$item->id}}" data-img="{{url('storage').'/'.$img_big}}">
    </div>
    @php
        $style = '';
        $titulo = 'Establecer como imagen principal';
    @endphp
@endforeach

<script>
    $(document).ready(function(){
        // cambiar imagen principal
        $('.img-gallery').click(function(){
            let img_medium = $(this).data('img').replace('_small', '_medium');
            let img = $(this).data('img').replace('_small', '');

            let id = $(this).data('id');
            let producto_id = {{ $producto_id }};
            let url = "{{url('admin/productos/cambiar_imagen_principal')}}/"+producto_id+'/'+id
            change_background(img_medium, img, id, url)
        });
        // set valor de delete imagen
        $('.btn-delete_img').click(function(){
            $('#modal_delete input[name="id"]').val($(this).data('id'));
        });
    });
</script>