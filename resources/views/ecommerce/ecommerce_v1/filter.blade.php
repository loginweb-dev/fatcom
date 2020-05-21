@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Filtros | {{ setting('empresa.title') }}</title>
@endsection

@section('content')
<section class="section-content padding-y">
	<div class="container">

		<div class="row">
			<aside class="col-md-3">
				
				<div class="card">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Product type</h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_1" style="">
							<div class="card-body">
                                <div id="accordion">
                                    <ul class="list-unstyled list-lg">
                                        <li class="list-item-title text-secondary btn-search" data-tipo="subcategoria" data-id="" style="margin-bottom:0px" aria-expanded="true">Todas</li>
                                        @forelse ($categorias as $categoria)
                                            <li class="list-item-title text-secondary" style="margin-bottom:0px" id="heading{{ $categoria->id }}" data-toggle="collapse" data-target="#collapse{{ $categoria->id }}" aria-expanded="true" aria-controls="collapse{{ $categoria->id }}">
                                                {{ $categoria->nombre }}
                                            </li>
                                            <div id="collapse{{ $categoria->id }}" class="collapse sublist-body" aria-labelledby="heading{{ $categoria->id }}" data-parent="#accordion">
                                                <ul class="list-unstyled list-lg sublist">
                                                    @foreach ($categoria->subcategorias as $subcategoria)
                                                        <li><button class="btn btn-link btn-search" data-tipo="subcategoria" data-id="{{ $subcategoria->id }}" > <b>{{ $subcategoria->nombre }}</b> <span class="float-right badge badge-secondary round"></span></button></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
							</div> <!-- card-body.// -->
						</div>
					</article> <!-- filter-group  .// -->
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Brands </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_2" style="">
							<div class="card-body">
								<div class="custom-control custom-radio" style="margin:5px 0px">
                                    <input type="radio" checked name="marca" id="option" class="custom-control-input btn-search" data-tipo="marca">
                                    <label class="custom-control-label" for="option">Todas</label>
                                </div>
                                @forelse ($marcas as $marca)
                                <div class="custom-control custom-radio" style="margin:5px 0px">
                                    <input type="radio" name="marca" id="option{{ $marca->id }}" class="custom-control-input btn-search" data-tipo="marca" data-id="{{$marca->id}}">
                                    <label class="custom-control-label" for="option{{ $marca->id }}">{{ $marca->nombre }}</label>
                                    <span class="float-right badge badge-secondary round">{{ $marca->productos }}</span>
                                </div>
                                @empty
        
                                @endforelse
					        </div> <!-- card-body.// -->
						</div>
					</article> <!-- filter-group .// -->
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Price range </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_3" style="">
							<div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Min</label>
                                        <input class="form-control input-price" id="input-min" placeholder="$0" type="number" min="0" step="1">
                                    </div>
                                    <div class="form-group text-right col-md-6">
                                        <label>Max</label>
                                        <input class="form-control input-price" id="input-max" placeholder="$1.0000" type="number" min="0" step="1">
                                    </div>
                                </div>
                                <button id="btn-price" class="btn btn-block btn-outline-primary">Aplicar</button>
							</div><!-- card-body.// -->
						</div>
					</article>
					{{-- <article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_4" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Sizes </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_4" style="">
							<div class="card-body">
							<label class="checkbox-btn">
								<input type="checkbox">
								<span class="btn btn-light"> XS </span>
							</label>

							<label class="checkbox-btn">
								<input type="checkbox">
								<span class="btn btn-light"> SM </span>
							</label>

							<label class="checkbox-btn">
								<input type="checkbox">
								<span class="btn btn-light"> LG </span>
							</label>

							<label class="checkbox-btn">
								<input type="checkbox">
								<span class="btn btn-light"> XXL </span>
							</label>
						</div><!-- card-body.// -->
						</div>
					</article>
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">More filter </h6>
							</a>
						</header>
						<div class="filter-content collapse in" id="collapse_5" style="">
							<div class="card-body">
								<label class="custom-control custom-radio">
								<input type="radio" name="myfilter_radio" checked="" class="custom-control-input">
								<div class="custom-control-label">Any condition</div>
								</label>

								<label class="custom-control custom-radio">
								<input type="radio" name="myfilter_radio" class="custom-control-input">
								<div class="custom-control-label">Brand new </div>
								</label>

								<label class="custom-control custom-radio">
								<input type="radio" name="myfilter_radio" class="custom-control-input">
								<div class="custom-control-label">Used items</div>
								</label>

								<label class="custom-control custom-radio">
								<input type="radio" name="myfilter_radio" class="custom-control-input">
								<div class="custom-control-label">Very old</div>
								</label>
							</div><!-- card-body.// -->
						</div>
					</article> --}}
				</div> <!-- card.// -->

			</aside> <!-- col.// -->
            <main class="col-md-9">
                <div id="contenido"></div>
            </main>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            search(1);
        })
    </script>
@endsection