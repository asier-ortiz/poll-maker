<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        @if(Auth::user()->role == "admin")
            <a href=" {{ route('admins.index') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" width="45" alt="" class="d-inline-block align-middle mr-2">
            </a>
        @elseif(Auth::user()->role == "creator")
            <a href=" {{ route('polls.index') }} " class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" width="45" alt="" class="d-inline-block align-middle mr-2">
            </a>
        @else
            <a href=" {{ route('users.index') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" width="45" alt="" class="d-inline-block align-middle mr-2">
            </a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto text-secondary">
                <li>
                    @if(Auth::user()->role == "admin")
                        Poll Maker - Administrador
                    @elseif(Auth::user()->role == "creator")
                        Poll Maker - Creador
                    @else
                        Poll Maker - Votante
                    @endif
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if(Auth::user()->role == "admin")
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admins.index') }}"> <strong>Usuarios</strong></a>
                    </li>
                    <li class="nav-item mr-5">
                        <a class="nav-link" href="{{ route('polls.index') }}"> <strong>Encuestas</strong></a>
                    </li>
                @endif
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Cerrar sesión
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
