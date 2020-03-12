{{-- modal de carga --}}
<div class="modal fade" tabindex="-1" id="modal_load" data-backdrop="static" role="dialog">
    <div style="display: flex;justify-content: center;align-items: center;height:100%">
        <?php $admin_logo_img = Voyager::setting('admin.img_loader', ''); ?>
        @if($admin_logo_img == '')
        <img src="{{ url('ecommerce_public/images/loader.gif') }}" width="80px" alt="">
        @else
        <img src="{{ url('storage/'.setting('admin.img_loader')) }}" width="80px" alt="">
        @endif
    </div>
</div>
