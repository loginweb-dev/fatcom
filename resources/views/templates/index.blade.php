<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <title>Administrador de plantillas</title>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <?php $admin_logo_img = Voyager::setting('empresa.logo', ''); ?>
        @if($admin_logo_img == '')
        <link rel="shortcut icon" href="{{ url('ecommerce_public/images/icon.png') }}" type="image/x-icon">
        @else
        <link rel="shortcut icon" href="{{ url('storage/'.setting('empresa.logo')) }}" type="image/x-icon">
        @endif
    </head>
    <body>
        <div class="content" style="margin: 10px">
            <div class="row mt-3 mb-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                @foreach ($templates as $template)
                                <a class="nav-link nav-template @if($template->id == \Session::get('template_id')) active @endif" id="v-pills-tab-{{ $template->id }}" data-id="{{ $template->id }}" data-toggle="pill" href="#v-pills-tab{{ $template->id }}" role="tab" aria-controls="v-pills-home1" aria-selected="true">{{ $template->name }}</a>
                                @endforeach
                                <br>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-create-template">Nuevo <i class="fa fa-plus"></i></button>
                            </div>
                            </div>
                            <div class="col-10">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($templates as $template)
                                    <div class="tab-pane fade @if($template->id == \Session::get('template_id')) show active @endif" id="v-pills-tab{{ $template->id }}" role="tabpanel" aria-labelledby="v-pills-tab-{{ $template->id }}">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            @foreach ($template->pages as $page)
                                            <li class="nav-item">
                                                <a class="nav-link nav-page @if($page->id == \Session::get('page_id')) active @endif" data-id="{{ $page->id }}" id="pills-tab{{ $page->id }}-tab" data-toggle="pill" href="#pills-tab{{ $page->id }}" role="tab" aria-controls="pills-tab{{ $page->id }}" aria-selected="true">{{ $page->name }}</a>
                                            </li>
                                            @endforeach
                                            <li class="nav-item" style="margin: 0px 10px">
                                                <a class="nav-link btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-create-page"><i class="fa fa-plus"></i></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            @foreach ($template->pages as $page)
                                            <div class="tab-pane fade @if($page->id == \Session::get('page_id')) show active @endif" id="pills-tab{{ $page->id }}" role="tabpanel" aria-labelledby="pills-tab{{ $page->id }}-tab">
                                                @foreach ($page->sections as $section)
                                                <div class="card mb-5">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                ID:{{ $section->id }} {{ ucfirst($section->name) }} <br> <small>{{ $section->description }}</small>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="card-header bg-transparent text-right" style="padding: 0px; border:0px">
                                                                    <div class="dropdown">
                                                                        <a class="btn btn-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink-{{ $section->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-{{ $section->id }}">
                                                                            <a class="dropdown-item btn-update-section" href="#" data-toggle="modal" data-target="#modal-update-section" data-id="{{ $section->id }}" data-name="{{ $section->name }}" data-description="{{ $section->description }}">
                                                                                <i class="fa fa-edit"></i> Editar
                                                                            </a>
                                                                            <a class="dropdown-item text-danger" href="{{ url('admin/templates/pages/sections/delete/'.$section->id.'/'.$template->id.'/'.$page->id) }}"><i class="fa fa-trash"></i> Borrar</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @forelse ($section->blocks as $block)
                                                            <div class="col-md-4">
                                                                <div class="card mb-3">
                                                                    <div class="card-header bg-transparent text-right" style="padding: 0px">
                                                                        <div class="dropdown">
                                                                            <a class="btn btn-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink-{{ $block->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-{{ $block->id }}">
                                                                                <a class="dropdown-item" href="{{ url('admin/templates/pages/sections/blocks/duplicate/'.$block->id.'/'.$template->id.'/'.$page->id) }}"><i class="fa fa-clone"></i> Duplicar</a>
                                                                                <a class="dropdown-item text-danger" href="{{ url('admin/templates/pages/sections/blocks/delete/'.$block->id.'/'.$template->id.'/'.$page->id) }}"><i class="fa fa-trash"></i> Borrar</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        @foreach ($block->inputs as $input)
                                                                            @switch($input->type)
                                                                                @case('text')
                                                                                    <div class="input-group mb-3">
                                                                                        @include('templates.partials.inputs.text', ['id'=>$input->id,'type'=>$input->type,'value'=>"$input->value",'name'=>"$input->name"])
                                                                                    </div>
                                                                                    @break
                                                                                @case('long_text')
                                                                                    <div class="input-group mb-3">
                                                                                        @include('templates.partials.inputs.long_text', ['id'=>$input->id,'type'=>$input->type,'value'=>"$input->value",'name'=>"$input->name"])
                                                                                    </div>
                                                                                    @break
                                                                                @case('icon')
                                                                                    <div class="input-group mb-3">
                                                                                        @include('templates.partials.inputs.icon', ['id'=>$input->id,'type'=>$input->type,'value'=>"$input->value",'name'=>"$input->name"])
                                                                                    </div>
                                                                                    @break
                                                                                @case('image')
                                                                                    <div class="input-group mb-3">
                                                                                        @include('templates.partials.inputs.image', ['id'=>$input->id,'type'=>$input->type,'value'=>"$input->value",'name'=>"$input->name"])
                                                                                    </div>
                                                                                    @break
                                                                                @default
                                        
                                                                            @endswitch
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            <div class="col-md-12 text-center">
                                                                <h5>Aún no has creado ningún bloque</h5>
                                                                <button type="button" data-section_id="{{ $section->id }}" data-toggle="modal" data-target="#modal-create-block" class="btn btn-warning btn-sm btn-create-block"><i class="fa fa-plus"></i> Crear bloque</button>
                                                            </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="row mt-5">
                                                    <div class="col-md-12 text-center">
                                                        @if (count($page->sections)==0)
                                                        <h5>Aún no has creado ningún sección</h5>
                                                        @endif
                                                        <button type="button" data-template_id="{{ $template->id }}" data-toggle="modal" data-target="#modal-create-section" class="btn btn-info btn-sm btn-create-section"><i class="fa fa-plus"></i> Crear sección</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        
        {{-- Modales --}}
        <form action="{{ route('templates.create') }}" method="post">
            <div class="modal fade" id="modal-create-template" tabindex="-1" role="dialog" aria-labelledby="modal-create-templateLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-create-templateLabel">Nuevo template</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre del template" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" placeholder="Descripción breve del template"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('templates.pages.create') }}" method="post">
            <div class="modal fade" id="modal-create-page" tabindex="-1" role="dialog" aria-labelledby="modal-page-createLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-create-createLabel">Nueva página</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="template_id" value="{{ \Session::get('template_id') }}">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la página" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" placeholder="Descripción breve de la página"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('templates.pages.sections.create') }}" method="post">
            <div class="modal fade" id="modal-create-section" tabindex="-1" role="dialog" aria-labelledby="modal-create-sectionLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-create-sectionLabel">Nueva sección</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="template_id" value="{{ \Session::get('template_id') }}">
                            <input type="hidden" name="page_id" value="{{ \Session::get('page_id') }}">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la sección" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" placeholder="Descripción breve de la sección"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('templates.pages.sections.update') }}" method="post">
            <div class="modal fade" id="modal-update-section" tabindex="-1" role="dialog" aria-labelledby="modal-update-sectionLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-update-sectionLabel">Editar sección</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="template_id" value="{{ \Session::get('template_id') }}">
                            <input type="hidden" name="page_id" value="{{ \Session::get('page_id') }}">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre de la sección" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="description" class="form-control" placeholder="Descripción breve de la sección"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('templates.pages.sections.blocks.create') }}" method="post">
            <div class="modal fade" id="modal-create-block" tabindex="-1" role="dialog" aria-labelledby="modal-create-blockLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-create-blockLabel">Nueva página</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="template_id" value="{{ \Session::get('template_id') }}">
                            <input type="hidden" name="page_id" value="{{ \Session::get('page_id') }}">
                            <input type="hidden" name="section_id">
                            <div class="form-group">
                                <select name="input" id="select-input-add" class="form-control">
                                    <option data-color="primary" value="">Seleccione el tipo de dato</option>
                                    <option data-color="success" value="text">Texto</option>
                                    <option data-color="warning" value="long_text">Párrafo</option>
                                    <option data-color="info" value="icon">Icono</option>
                                    <option data-color="dark" data-icon="fa fa-image fa-3x" value="image">Imagen</option>
                                </select>
                            </div>
                            <table class="table table-bordered" id="input-add-list"></table>
                            <div class="text-center">
                                <button type="button" id="btn-clear" class="btn btn-link">Limpiar <i class="fa fa-close"></i></button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id="form-edit" action="{{ route('templates.pages.sections.blocks.inputs.update') }}" method="post" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" name="id">
            <input type="hidden" name="value">
            <input type="hidden" name="type">
            <div style="display:none">
                <input type='file' name="value-img" id="input-value-img" accept="image/*"/>
            </div>
            {{-- <button type="submit">ok</button> --}}
        </form>

        <style>
            .div-img-preview:hover{
                cursor: pointer;
            }
        </style>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip()
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

                // Enviar valor de input block para actualizar
                $('.btn-edit-input').click(function(){
                    let id = $(`#${$(this).data('id')}`).data('id');
                    let value = $(`#${$(this).data('id')}`).val();
                    let type = $(`#${$(this).data('id')}`).data('type');

                    $('#form-edit input[name=id]').val(id)
                    $('#form-edit input[name=value]').val(value)
                    $('#form-edit input[name=type]').val(type)
                    $.post($('#form-edit').attr('action'), $('#form-edit').serialize(), function(res){
                        Toast.fire({
                            icon: 'success',
                            title: 'Dato actualizado'
                        });
                        $(`#btn-${res.id}`).css('display', 'none');
                        $(`#form-edit`).trigger( "reset" );
                    })
                });

                $('.btn-upload-img').click(function(){
                    let id = $(this).data('id');
                    $('#form-edit input[name=id]').val(id);
                    $('#form-edit input[name=type]').val('image');
                    let formData = new FormData(document.getElementById("form-edit"));
                    formData.append("dato", "valor");
                    $.ajax({
                        url: $('#form-edit').attr('action'),
                        dateType: 'script',
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $(`#div-img-preview-${id}`).append('<div class="progress" style="height: 3px"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>');
                        },
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                $('.progress-bar').attr('aria-valuenow', percentComplete)
                                $('.progress-bar').css('width', `${percentComplete}%`)
                            }
                            }, false);

                            return xhr;
                        },
                    }).done(function( data, textStatus, jqXHR ) {
                        if(!data.error){
                            Toast.fire({
                                icon: 'success',
                                title: 'Dato actualizado'
                            });
                            $(`#form-edit`).trigger( "reset" );
                            $(`#img-preview-actions-${img_preview}`).css('display', 'none');
                            setTimeout(() => {
                                $('.progress').remove();
                            }, 1200);
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            });
                        }
                    }).fail(function( jqXHR, settings, exception ) {
                        console.log('could not load');
                    });

                })

                $('.btn-update-section').click(function(){
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let description = $(this).data('description');
                    $('#modal-update-section input[name="id"]').val(id);
                    $('#modal-update-section input[name="name"]').val(name);
                    $('#modal-update-section textarea[name="description"]').val(description);
                });

                // Pasar id del template al modal de creación de nuevo bloque
                $('.nav-template').click(function(){
                    let template_id = $(this).data('id');
                    $('#modal-create-section input[name="template_id"]').val(template_id);
                    $('#modal-create-page input[name="template_id"]').val(template_id);
                    $('#modal-update-section input[name="template_id"]').val(template_id);
                    $('#modal-create-block input[name="template_id"]').val(template_id);
                });

                // Pasar id del template al modal de creación de nuevo bloque
                $('.nav-page').click(function(){
                    let page_id = $(this).data('id');
                    $('#modal-create-section input[name="page_id"]').val(page_id);
                    $('#modal-update-section input[name="page_id"]').val(page_id);
                    $('#modal-create-block input[name="page_id"]').val(page_id);
                });

                // Pasar id de la section al modal de creación de nuevo bloque
                $('.btn-create-block').click(function(){
                    let section_id = $(this).data('section_id');
                    $('#modal-create-block input[name="section_id"]').val(section_id);
                });

                // Agregar input al seleccionar select de tipos
                $('#select-input-add').change(function(){
                    let value = $(this).val();
                    let text = $('#select-input-add option:selected').text();
                    let icon = $('#select-input-add option:selected').data('icon');
                    let color = $('#select-input-add option:selected').data('color');
                    if(value){
                        $('#input-add-list').append(`
                            <tr>
                                <td>
                                    <input type="hidden" name="types[]" value="${value}" />
                                    ${icon ? `<i class="${icon} text-${color}"></i>` : `<span class="badge badge-${color}">${text}</span>`}
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="name[]" placeholder="Nombre" pattern="[a-z]{1,15}" title="El nombre debe tener solo letras Ej: titulo" required>
                                </td>
                            </tr>
                        `);
                        $(this).val('');
                    }
                });

                $('#btn-clear').click(function(){
                    $('#input-add-list').html('');
                });

                // Activar boton de edición al poner el foco en su input
                $(".input-block").focus(function() {
                    let id = $(this).data('id');
                    $(`#btn-${id}`).css('display', 'block');
                });

                // Si el input es icono renderizar el icono
                $(".input-block").keyup(function() {
                    let id = $(this).data('id');
                    let type = $(this).data('type');
                    let value = $(this).val();
                    if(type=='icon'){
                        $(`#icon-${id}`).html(`<span class="input-group-text"><i class="${value }"></i></span>`);
                    }
                });

                // Mostrar alerta que retorna el controlador
                @if(\Session::has('type'))
                    Toast.fire({
                        icon: "{{ \Session::get('type') }}",
                        title: "{{ \Session::get('message') }}"
                    });
                @endif
            });

            var img_preview = 0
            function readURL(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(`#img-preview-${img_preview}`).attr('src', e.target.result);
                        $(`#div-img-current-${img_preview}`).css('display', 'none');
                        $(`#img-preview-${img_preview}`).css('display', 'block');
                        $(`#img-preview-actions-${img_preview}`).css('display', 'block');
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#input-value-img").change(function() {
                readURL(this);
            });

            $('.div-img-preview').click(function(){
                let id = $(this).data('id');
                img_preview = id;
                $(`#input-value-img`).trigger( "click" );
            });
        </script>
    </body>
</html>