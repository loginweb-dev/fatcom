<!-- Navigation -->
  <header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav custom-scrollbar">

      <!-- Logo -->
      <li>
        <div class="logo-wrapper waves-light">
          <a href="{{ route('ecommerce_home') }}">
            <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/navbar-logo.png') }}" class="img-fluid flex-center">
          </a>
        </div>
      </li>
      <!-- Logo -->

      <!-- Social -->
      <li>
        <ul class="social">
          <li>
            <a class="fb-ic">
              <i class="fab fa-facebook-f"> </i>
            </a>
          </li>
          <li>
            <a class="pin-ic">
              <i class="fab fa-instagram"> </i>
            </a>
          </li>
          <li>
            <a class="tw-ic">
              <i class="fab fa-whatsapp"> </i>
            </a>
          </li>

        </ul>

      </li>
      <!-- Social -->

      <!-- Search Form -->
      <li>

        <form class="search-form" role="search">
          <div class="form-group md-form mt-0 pt-1 waves-light">
            <input type="text" class="form-control input-search_navbar" data-placement="result-navbar-lateral" placeholder="Buscar">
          </div>
          {{-- <div class="dropdown-wrapper"> --}}
            <ul class="list-group" id="result-navbar-lateral">
            </ul>
          {{-- </div> --}}
        </form>

      </li>
      <!-- Search Form -->

      <!-- Side navigation links -->
      <li>

        <ul class="collapsible collapsible-accordion">
          <li>
            <a href="{{ route('ecommerce_home') }}" class="collapsible-header waves-effect"><i class="fas fa-home"></i> Inicio</a>
          </li>
          <li>
            <a href="{{ route('carrito_compra') }}" class="collapsible-header waves-effect"><i class="fas fa-shopping-cart"></i> Carrito</a>
          </li>
        </ul>

      </li>

      <!-- Side navigation links -->
      <div class="sidenav-bg mask-strong"></div>

    </ul>
    <!-- Sidebar navigation -->

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg  navbar-light scrolling-navbar white">

      <div class="container">

        <!-- SideNav slide-out button -->
        <div class="float-left mr-2">
          <a href="#" data-activates="slide-out" class="button-collapse">
            <i class="fas fa-bars"></i>
          </a>
        </div>

        <a class="navbar-brand font-weight-bold" href="{{ route('ecommerce_home') }}">

          <strong> <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/logo.png') }}" alt="logo" width="40px"> {{ setting('empresa.title') }}</strong>

        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
          aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">

          <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">

          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">

                <a class="nav-link dark-grey-text font-weight-bold" href="{{ route('carrito_compra') }}">
                    <span class="badge danger-color" id="label-carrito">0</span> <i class="fas fa-shopping-cart blue-text" aria-hidden="true"></i>
                    <span class="clearfix d-none d-sm-inline-block">Carrito</span>
                </a>
              </li>
            @guest
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link waves-effect waves-light dark-grey-text font-weight-bold" href="{{ route('register') }}">
                            <i class="fas fa-edit blue-text"></i> Registrarse
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light dark-grey-text font-weight-bold" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt blue-text"></i> Login
                    </a>
                </li>
            @else
                {{-- <li class="nav-item">
                    <a class="nav-link waves-effect waves-light dark-grey-text font-weight-bold" href="{{route('pedidos_index', ['id'=>'last'])}}" title="Pedidos pendientes" id="label-pedidos">
                        <i class="fas fa-clipboard-list blue-text"></i> Mis pedidos
                    </a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle waves-effect waves-light dark-grey-text font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="far fa-address-card blue-text"></i> Cuenta <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->role_id == 1)
                        <a class="dropdown-item link-page" target="_blank" href="{{ url('admin') }}">Administración</a>
                        @endif
                        <a class="dropdown-item link-page" href="{{route('profile')}}">Perfil</a>
                        <a class="dropdown-item link-page" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest

          </ul>

        </div>

      </div>

    </nav>
    <!-- Navbar -->

  </header>
  <!-- Navigation -->