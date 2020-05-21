<div class="div-img-preview" id="div-img-preview-{{ $id }}" data-id="{{ $id }}" data-toggle="tooltip" title="Click para cambiar {{ $name }}">
    <div id="div-img-current-{{ $id }}">
        @if (!empty($value))
            <img src="{{ url('storage/'.$value) }}" alt="" height="65px">
        @else
            <i class="fa fa-image fa-4x"></i>
        @endif
    </div>
    <img style="display: none" id="img-preview-{{ $id }}" src="#" alt="your image" height="65px" />
</div>
<div style="display: none" id="img-preview-actions-{{ $id }}">
    <button class="btn btn-link btn-upload-img" data-id="{{ $id }}"><i class="fa fa-check text-success"></i></button>
    <br>
    <button class="btn btn-link"><i class="fa fa-close text-danger"></i></button>
</div>