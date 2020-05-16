<header class="section-header">
    <section class="header-main border-bottom">
        <div class="container">
    <div class="row align-items-center">
        <div class="col-lg-2 col-6">
            <a class="brand-wrap link-page" href="{{ url('/') }}">
                <?php $admin_logo_img = Voyager::setting('empresa.logo', ''); ?>
                @if($admin_logo_img == '')
                <img class="logo" src="{{ url('ecommerce_public/images/icon.png') }}" alt="loginWeb">
                @else
                <img class="logo" src="{{ url('storage/'.setting('empresa.logo')) }}" alt="loginWeb">
                @endif
            </a>
        </div>
        <div class="col-lg-6 col-12 col-sm-12">
            <form action="#" class="search">
                <div class="input-group w-100">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="widgets-wrap float-md-right">
                <div class="widget-header  mr-3">
                    <a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-shopping-cart"></i></a>
                    <span class="badge badge-pill badge-danger notify">0</span>
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
                          <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong>Hola, {{ Auth::user()->name }} <i class="fa fa-caret-down"></i></strong></a>
                          <div class="dropdown-menu">
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
    <nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
        <div class="container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
              @foreach ($categorias as $category)
              <li class="nav-item dropdown">
                <a class="nav-link pl-0" data-toggle="dropdown" href="#">{{ $category->nombre }} <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-menu">
                  @forelse ($category->subcategorias as $subcategoria)
                  <a class="dropdown-item" href="#">{{ $subcategoria->nombre }}</a>
                  @empty
                  <a class="dropdown-item" href="#">Ninguno</a>
                  @endforelse
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </nav>
</header>