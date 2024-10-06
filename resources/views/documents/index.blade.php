@extends('layouts.app')

@vite('resources/css/document-index.css')

@section('content')



<div class="container">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <h2 class="text-center mb-4 mt-2">Listado de Documentos</h2>

    @role(['Responsable','Administrador'])
    <!-- Botón para crear un nuevo documento -->
    <div class="mb-3 text-right">
        <a href="{{ route('document.create') }}" class="btn btn-primary btn-gen1">
            Crear Nuevo Documento
        </a>
    </div>
    @endrole
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

    <!-- Paginación centrada -->
    <div class="pagination justify-content-center mt-4 pagination-documents">
        {{ $documents->links() }}
    </div>
</div>

@endsection




