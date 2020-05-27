<div class="card card-body">
    <div class="row">
        @foreach ($productos as $item)
        @php
            $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : '../img/default.png';
        @endphp
        <div class="col-md-3">
            <figure class="itemside mb-4">
                <div class="aside">
                    <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                        <img src="{{ url('storage/'.$img) }}" class="border img-sm">
                    </a>
                </div>
                <figcaption class="info align-self-center">
                    <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="title text-truncate" style="max-width: 180px;">{{ $item->nombre }}</a>
                    <div class="rating-wrap mb-3">
                        <ul class="rating-stars">
                            <li style="width:{{ $item->puntos*20 }}%" class="stars-active"> 
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                            </li>
                            <li>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                <i class="fa fa-star"></i> 
                            </li>
                        </ul>
                    </div>
                    <button onclick="addCart({{ $item->id }})" class="btn btn-light text-primary btn-sm"> Agregar <i class="fa fa-shopping-cart text-primary"></i> </button>
                </figcaption>
            </figure>
        </div>
        @endforeach
    </div>
    @if(count($productos)>0)
    <div class="row">
        <div id="paginador-search" class="col-md-12">
            {{$productos->links()}}
        </div>
    </div>
    @endif
</div>


<script>
    // Paginador de busqueda
    $('.page-link').click(function(){
        let page = $(this).prop('href');
        list(page.split('page=')[1], true);
        return false;
    });
</script>