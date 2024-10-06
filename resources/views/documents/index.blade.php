@extends('layouts.app')

@vite('resources/css/document-index.css')

@section('content')

<div class="container">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <h2 class="text-center mb-4 mt-2">Listado de Documentos</h2>

    @role(['Responsable','Administrador'])
    <div class="mb-3 text-right">
        <a href="{{ route('document.create') }}" class="btn btn-primary btn-gen1">
            Crear Nuevo Documento
        </a>
    </div>
    @endrole

    <!-- Filtros de Fecha y Relevancia -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="filterDate" class="form-label label-index">Filtrar por Fecha</label>
            <select id="filterDate" class="form-select select-index" onchange="applyFilters()">
                <option value="asc" {{ request('filterDate') == 'asc' ? 'selected' : '' }}>Fecha más antigua</option>
                <option value="desc" {{ request('filterDate') == 'desc' ? 'selected' : '' }}>Fecha más reciente</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="filterRelevance" class="form-label label-index">Filtrar por Relevancia</label>
            <select id="filterRelevance" class="form-select select-index" onchange="applyFilters()">
                <option value="">Selecciona una opción</option>
                @foreach ($relevances as $relevance)
                    <option value="{{ $relevance->id }}" {{ request('filterRelevance') == $relevance->id ? 'selected' : '' }}>
                        {{ $relevance->relevance_level }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="document-list">
        @foreach ($documents as $document)
        <div class="document-item d-flex justify-content-between align-items-center mb-3 p-3 {{ $document->approval_date ? 'approved-document' : '' }}">

            <span class="document-title">{{ $document->title }}</span>

            <div class="document-actions">
                <!-- Ver Documento -->
                <a href="{{ route('documents.show', $document->id) }}" class="action-icon">
                    <span class="material-icons">visibility</span>
                </a>

                <!-- Editar Documento -->
                @role(['Responsable','Administrador'])
                <a href="{{ route('documents.edit', $document->id) }}" class="action-icon">
                    <span class="material-icons">edit</span>
                </a>
                @endauth
                <!-- Borrar Documento -->
                @role(['Administrador'])
                <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este documento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-icon btn btn-link p-0 justify-content-center btn-delete icon-delete">
                        <span class="material-icons" style="font-size: 24px;">delete</span>
                    </button>
                </form>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination justify-content-center mt-4 pagination-documents">
        {{ $documents->links() }}
    </div>
</div>

<script>
    function applyFilters() {
        const filterDate = document.getElementById('filterDate').value;
        const filterRelevance = document.getElementById('filterRelevance').value;

        let query = '?';
        if (filterDate) query += `filterDate=${filterDate}&`;
        if (filterRelevance) query += `filterRelevance=${filterRelevance}&`;

        window.location.href = query;
    }
</script>

@endsection
