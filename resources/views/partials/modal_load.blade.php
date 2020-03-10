{{-- modal de carga --}}
<div class="modal fade" tabindex="-1" id="modal_load" data-backdrop="static" role="dialog">
    <div style="display: flex;justify-content: center;align-items: center;height:100%">
        <img src="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}" width="80px" alt="">
    </div>
</div>
