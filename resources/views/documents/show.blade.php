@extends('layouts.app')

@vite('resources/css/document-show.css')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">{{ $document->title }}</h2>

    <div class="row">
        <!-- Visor de PDF -->
        <div class="col-md-8 content-pdf">
            <div class="pdf-viewer">
                <!-- Mostrar el PDF desde base64 con tamaño reducido -->
                <embed src="data:application/pdf;base64,{{ $base64PDF }}" type="application/pdf" width="100%" height="500px" />
            </div>
        </div>

        <!-- Tarjeta con los datos del documento -->
        <div class="col-md-4">
            <div class="card card-data">
                <div class="card-header">
                    <h3 class="title-card">Detalles del Documento</h3>
                </div>
                <div class="card-body">
                    <p><strong>Título:</strong> {{ $document->title }}</p>
                    <p><strong>Descripción:</strong> {{ $document->description }}</p>
                    <p><strong>Relevancia:</strong> {{ $document->relevance->relevance_level ?? 'No definida' }}</p>
                    <p><strong>Estado de aprobación:</strong>
                        @if($document->approval_date)
                            <span class="text-approved">Aprobado el {{ \Carbon\Carbon::parse($document->approval_date)->format('d/m/Y') }}</span>
                        @else
                            <span class="text-notApproved">Sin aprobar</span>
                        @endif
                    </p>
                    <p><strong>Subido por:</strong> {{ $document->user->nick_name }}</p>
                    <p><strong>Fecha de subida:</strong> {{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y') }}</p>
                </div>

                <!-- Botón para aprobar el documento -->
                @if(auth()->user()->hasRole(['Administrador']) && !$document->approval_date)
                <div class="card-footer">
                    <form action="{{ route('document.approve', $document->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Aprobar Documento</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-gen2 mt-3">Volver al Listado</a>
</div>
@endsection
