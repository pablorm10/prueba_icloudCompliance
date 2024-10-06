@extends('layouts.app')

@vite('resources/css/edit.css')

@vite('resources/css/document-create.css')

@section('content')
<div class="container">


    <h2 class="text-center mb-4 mt-2">Crear Nuevo Documento</h2>

    <!-- Formulario para crear un nuevo documento -->
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Campo para el título -->
        <div class="form-group">
            <label for="title" class="labels-edit">Título</label>
            <input type="text" name="title" class="form-control select-edit" value="{{ old('title') }}" required>
        </div>

        <!-- Campo para la descripción -->
        <div class="form-group">
            <label for="description" class="labels-edit">Descripción</label>
            <textarea name="description" class="form-control select-edit" rows="4">{{ old('description') }}</textarea>
        </div>

        <!-- Select para la relevancia -->
        <div class="form-group">
            <label for="relevance_id" class="labels-edit">Relevancia</label>
            <select name="relevance_id" class="form-control select-edit" style="width: 40%" required>
                @foreach($relevances as $relevance)
                    <option value="{{ $relevance->id }}">{{ $relevance->relevance_level }}</option>
                @endforeach
            </select>
        </div>

        <!-- Estado de aprobación -->
        <div class="form-group">
            <label for="approval_status" class="labels-edit">Estado</label>
            <select name="approval_status" style="width: 40%" class="form-control select-edit"
            {{!auth()->user()->hasRole('Administrador') ? 'disabled' : '' }}>
                <option value="approved">Aprobado</option>
                <option selected value="" >Sin Aprobar</option>
            </select>
        </div>

        <!-- Campo para el archivo (opcional) -->
        <div class="form-group">
            <label for="document_file" class="labels-edit">Subir archivo (PDF)</label>
            <input type="file" name="document" class="form-control-file" accept="application/pdf" required>
        </div>

        <!-- Botón para guardar -->
        <button type="submit" class="btn btn-primary btn-gen1">Crear Documento</button>
    </form>
</div>
@endsection
