@php
  $section = Templates::section(1);
  $block = $section->blocks;
@endphp
@if ($section->count > 0)
<nav class="navbar navbar-dark navbar-expand p-0" style="background-color: {{ $section->background }}; color: {{ $section->color }}">
  <div class="container">
      <div class="col-md-12 mt-3 mb-3 text-center">
        <h6>{{ $block->titulo }}</h6>
        <p>{{ $block->descripcion }}<br><small>{{ $block->footer }}</small></p>
      </div>
  </div>
</nav>
@endif

@php
  $section = Templates::section(12);
@endphp
<nav class="navbar navbar-dark navbar-expand p-0" style="background-color: {{ $section ? $section->background : '#fff' }}; }}">
  <div class="container">
      <ul class="navbar-nav d-none d-md-flex mr-auto">
      <li class="nav-item"><a class="nav-link" href="{{ url('/') }}" style="color: {{ $section ? $section->color : '#000' }}">Inicio</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('/filtro') }}" style="color: {{ $section ? $section->color : '#000' }}">Busqueda</a></li>
      {{-- <li class="nav-item"><a class="nav-link" href="#">Delivery</a></li> --}}
      <li class="nav-item"><a class="nav-link" href="{{ route('payments_index') }}" style="color: {{ $section ? $section->color : '#000' }}">Formas de pago</a></li>
      </ul>
      <ul class="navbar-nav">
      <li  class="nav-item"><a href="tel:75199157" class="nav-link" style="color: {{ $section ? $section->color : '#000' }}">{!! setting('empresa.celular') ? 'Llamar: '.setting('empresa.celular').' <i class="fa fa-phone"></i>' : '' !!} </a></li>
      {{-- <li class="nav-item dropdown">
         <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> English </a>
          <ul class="dropdown-menu dropdown-menu-right" style="max-width: 100px;">
          <li><a class="dropdown-item" href="#">Arabic</a></li>
          <li><a class="dropdown-item" href="#">Russian </a></li>
          </ul>
      </li> --}}
    </ul>
    </div>
  </div>
</nav>

<header class="section-header">
  <section class="header-main border-bottom">
    <div class="container">
      <div class="row align-items-center">
          <div class="col-lg-2 col-6">
              @php
                $section = Templates::section(2);
                $block = $section->blocks;
              @endphp
              <a class="brand-wrap link-page" href="{{ url('/') }}">
                <img class="logo" src="{{ $block ? url('storage/'.$block->logo) : '' }}" alt="{{ $block ? $block->nombre : '' }}">
              </a>
          </div>
          <div class="col-lg-7 col-12 col-sm-12">
              <select name="" id="select-main-search" class="form-control"></select>
          </div>
          <div class="col-lg-3 col-sm-6 col-12">
              <div class="widgets-wrap float-md-right">
                  <div class="widget-header  mr-3">
                      <a href="{{ route('carrito_compra') }}" class="icon icon-sm rounded-circle border" data-toggle="tooltip" title="Carrito"><i class="fa fa-shopping-cart"></i></a>
                      <span class="badge badge-pill badge-danger notify" id="label-count-cart">0</span>
                  </div>
                  <div class="widget-header icontext">
                      @guest
                          <a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></a>
                          <div class="text">
                            <div> 
                              <a href="{{ route('login') }}">Login</a> |  
                              <a href="{{ route('register') }}"> Registrarse</a>
                            </div>
                          </div>
                      @else
                        <img class="icon icon-sm rounded-circle border" src="{{ strpos(Auth::user()->avatar, 'https') === false ? Voyager::Image(Auth::user()->avatar) : Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                        <ul class="navbar-nav">
                          <li class="nav-item dropdown">
                            <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong>Hola, {{ explode(' ', Auth::user()->name)[0] }} <i class="fa fa-caret-down"></i></strong></a>
                            <div class="dropdown-menu">
                              @if(Auth::user()->role_id != 2)
                              <a class="dropdown-item" target="_blank" href="{{ url('admin') }}">Administración</a>
                              @endif
                              <a class="dropdown-item" href="{{ route('pedidos_index', ['id'=>'last']) }}" title="Pedidos pendientes" id="label-count-pedidos">Mis pedidos</a>
                              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                              </form>
                            </div>
                          </li>
                        </ul>
                      @endguest
                  </div>
              </div>
          </div>
      </div>
    </div>
  </section>
  @isset($categorias)
  <nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="main_nav">
        <ul class="navbar-nav">
          @php
              $cont = 1; 
          @endphp
          @foreach ($categorias as $category)
          @if ($cont <= 5)
            <li class="nav-item dropdown">
              <a class="nav-link pl-0" data-toggle="dropdown" href="#">{{ $category->nombre }}</a>
              <div class="dropdown-menu">
                @forelse ($category->subcategorias as $subcategoria)
                <a class="dropdown-item" href="{{ url('/filtro?subcategory='.$subcategoria->slug) }}">{{ $subcategoria->nombre }}</a>
                @empty
                <a class="dropdown-item" href="#">Ninguno</a>
                @endforelse
              </div>
            </li>
          @endif
          @php
              $cont++; 
          @endphp
          @endforeach
        </ul>
      </div>
    </div>
  </nav>
  @endisset
</header>