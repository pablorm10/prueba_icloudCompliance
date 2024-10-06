@vite('resources/css/sidebar.css')


<div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar-cuerpo">
    <div class="text-white mb-3">
        <strong class=" sidebar-textoUser">{{ Auth::user()->nick_name }}</strong>
    </div>
    <hr class="bg-white">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white sidebar-textos-enlace" aria-current="page">
                Inicio
            </a>
        </li>
        <li>
            <a href="{{ route('documents.store') }}" class="nav-link text-white sidebar-textos-enlace">
                Documentos
            </a>
        </li>
        <li>
            <a href="{{ route('documents.chart') }}" class="nav-link text-white sidebar-textos-enlace">
                Gráfico Relevancia
            </a>
        </li>
        <li>
            <a href="{{ route('documents.approved.chart') }}" class="nav-link text-white sidebar-textos-enlace">
                Gráfico Aprobados
            </a>
        </li>
    </ul>

</div>
