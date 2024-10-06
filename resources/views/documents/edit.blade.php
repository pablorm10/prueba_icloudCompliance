@extends('layouts.app')


@vite('resources/css/edit.css')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Editar Documento</h2>

    <!-- Formulario para editar el documento -->
    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Campo para el título -->
        <div class="form-group">
            <label for="title" class="labels-edit">Título</label>
            <input type="text" name="title" class="form-control select-edit" value="{{ old('title', $document->title) }}" required>
        </div>

        <!-- Campo para la descripción -->
        <div class="form-group">
            <label for="description" class="labels-edit">Descripción</label>
            <textarea name="description" class="form-control select-edit" rows="4">{{ old('description', $document->description) }}</textarea>
        </div>

        <!-- Select para la relevancia -->
        <div class="form-group">
            <label for="relevance_id" class="labels-edit">Relevancia</label>
            <select name="relevance_id" class="form-control select-edit" style="width: 40%" required>
                @foreach($relevances as $relevance)
                    <option value="{{ $relevance->id }}" {{ $document->relevance_id == $relevance->id ? 'selected' : '' }}>
                        {{ $relevance->relevance_level }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Estado de aprobación -->
        <div class="form-group">
            <label for="approval_status" class="labels-edit">Estado</label>
            <select name="approval_status" style="width: 40%" class="form-control select-edit"
            {{ !is_null($document->approval_date) || !auth()->user()->hasRole('Administrador') ? 'disabled' : '' }}>
                @if ($document->approval_date == null)
                    <option value="approved">Aprobado</option>
                    <option value="notApproved" selected>Sin Aprobar</option>
                @else
                    <option value="approved" selected>Aprobado</option>
                    <option value="notApproved">Sin Aprobar</option>
                @endif
            </select>
        </div>

        <!-- Campo para el archivo (opcional) -->
        <div class="form-group">
            <label for="document" class="labels-edit">Subir nuevo archivo (PDF)</label>
            <input type="file" name="document_file" class="form-control-file" accept="application/pdf" id="document">
            <input type="hidden" name="content" id="document_base64"> <!-- Campo oculto para almacenar el base64 -->
        </div>

        <!-- Botón para guardar -->
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>


<script>
    document.getElementById('document').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            // Obtener el resultado en base64
            const base64String = reader.result;

            // Extraer solo la parte base64 (sin el prefijo)
            const base64Content = base64String.split(',')[1]; // Tomar solo la parte después de la coma
            document.getElementById('document_base64').value = base64Content; // Almacena el contenido base64 sin el prefijo
        };

        if (file) {
            reader.readAsDataURL(file); // Lee el archivo como una URL de datos (base64)
        } else {
            document.getElementById('document_base64').value = null; // Limpiar el campo si no hay archivo
        }
    });
</script>

@endsection
