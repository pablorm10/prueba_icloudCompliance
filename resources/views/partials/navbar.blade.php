<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('imagenes/genericas/logo_prm.png') }}" alt="Logo" class='navbar-logo'>
      </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    @if (Auth::check())
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <!-- Botón de Cerrar Sesión -->
        <a href="#"
           class="btn btn-login btn-light my-2 my-sm-0"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Cerrar Sesión
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    @else
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <a href="{{ route('login') }}" class="btn btn-login btn-light my-2 my-sm-0">Login</a>
        </div>
    @endif


  </nav>
