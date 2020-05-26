<div class="input-group-prepend" id="icon-{{ $id }}">
  <span class="input-group-text"><i class="{{ $value }}"></i></span>
</div>
<input type="text" id="input-{{ $id }}" data-id="{{ $id }}" data-type="{{ $type }}" class="form-control input-block" aria-label="Texto" value="{{ $value }}" title="{{ $name }}" aria-describedby="btn-{{ $id }}">
<div class="input-group-prepend">
    <button class="btn btn-success btn-edit-input" data-id="input-{{ $id }}" type="button" id="btn-{{ $id }}" style="display: none"><i class="fa fa-edit"></i></button>
</div>