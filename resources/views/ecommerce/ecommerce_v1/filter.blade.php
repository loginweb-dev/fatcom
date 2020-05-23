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
								<h6 class="title">Categorías</h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_1" style="">
							<div class="card-body">
                                <div id="accordion">
									<article class="filter-group">
										<header class="card-header" >
											<a href="#" class="btn-search" data-tipo="subcategoria" data-id="">
												<h6 class="title text-dark">Todas </h6>
											</a>
										</header>
									</article>
									@forelse ($categorias as $categoria)
										<article class="filter-group">
											<header class="card-header" style="padding-bottom: 5px">
												<a href="#" data-toggle="collapse" data-target="#collapse_category{{ $categoria->id }}" aria-expanded="true" class="">
													<i class="icon-control text-dark fa fa-chevron-down"></i>
													<h6 class="title text-dark">{{ $categoria->nombre }} </h6>
												</a>
											</header>
											<div class="filter-content collapse @if($subcategoria_filtro && $subcategoria_filtro->categoria_id==$categoria->id) show @endif" id="collapse_category{{ $categoria->id }}" style="">
												<div class="card-body" style="padding-top: 0px">
													<ul class="list-unstyled list-lg sublist">
														@foreach ($categoria->subcategorias as $subcategoria)
															<li><button class="btn btn-link text-muted btn-search" data-tipo="subcategoria" data-id="{{ $subcategoria->id }}" > <b>{{ $subcategoria->nombre }}</b> <span class="float-right badge badge-secondary round"></span></button></li>
														@endforeach
													</ul>
												</div>
											</div>
										</article>
									@empty
									@endforelse
                                </div>
							</div>
						</div>
					</article>
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Marcas </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_2" style="">
							<div class="card-body">
								<div class="custom-control custom-radio" style="margin:5px 0px">
                                    <input type="radio" @if(!$marca_filtro) checked @endif name="marca" id="option" class="custom-control-input btn-search" data-tipo="marca">
                                    <label class="custom-control-label" for="option">Todas</label>
                                </div>
                                @forelse ($marcas as $marca)
                                <div class="custom-control custom-radio" style="margin:5px 0px">
                                    <input type="radio" @if($marca_filtro && $marca_filtro->id==$marca->id) checked @endif name="marca" id="option{{ $marca->id }}" class="custom-control-input btn-search" data-tipo="marca" data-id="{{$marca->id}}">
                                    <label class="custom-control-label" for="option{{ $marca->id }}">{{ $marca->nombre }}</label>
                                    <span class="float-right badge badge-secondary round">{{ $marca->productos }}</span>
                                </div>
                                @empty
        
                                @endforelse
					        </div>
						</div>
					</article>
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Rango de precios </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_3" style="">
							<div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Min</label>
                                        <input class="form-control input-price" id="input-min" placeholder="0" type="number" min="0" step="1">
                                    </div>
                                    <div class="form-group text-right col-md-6">
                                        <label>Max</label>
                                        <input class="form-control input-price" id="input-max" placeholder="1000" type="number" min="0" step="1">
                                    </div>
                                </div>
                                <button id="btn-price" class="btn btn-block btn-outline-primary">Aplicar</button>
							</div>
						</div>
					</article>
				</div>

			</aside>
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
			// Set de datos marca al form de filtros (si existe)
			@if($marca_filtro)
			$(`#form-search input[name="marca_id"]`).val('{{ $marca_filtro->id }}');
        	$(`#form-search input[name="tipo_busqueda"]`).val('click');
			@endif

		// Set datos de categoria al form de filtros (si existe)
			@if($subcategoria_filtro)
			$(`#form-search input[name="subcategoria_id"]`).val('{{ $subcategoria_filtro->id }}');
        	$(`#form-search input[name="tipo_busqueda"]`).val('click');
			@endif
            search(1);
        })
    </script>
@endsection