<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand link-page" href="{{url('/')}}">{{setting('empresa.title')}} </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link link-page" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link link-page" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link link-page" href="{{route('pedidos_index', ['id'=>'last'])}}" title="Pedidos pendientes" id="label-pedidos">Mis pedidos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role_id != 2)
                            <a class="dropdown-item link-page" href="{{ url('admin') }}">Administración</a>
                            @else
                            <a class="dropdown-item link-page" href="#">Perfil</a>
                            @endif
                            <a class="dropdown-item link-page" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Salir
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        @php
                            $user = App\User::find(Auth::user()->id);
                            if($user->tipo_login == 'facebook' || $user->tipo_login == 'google'){
                                $imagen = Auth::user()->avatar;
                            }else{
                                $imagen = url('storage').'/'.Auth::user()->avatar;
                            }
                        @endphp
                        <img src="{{$imagen}}" alt="user_profile" style="width:30px">
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
