@extends('layouts.app')

@section('title', 'Inicio')


@vite('resources/css/home.css')

@section('content')
<div class="contenedor-home container d-flex flex-column justify-content-center align-items-center vh-75"> <!-- Cambiado a vh-75 -->
    <h1 class="h1-home text-center">PRUEBA TÉCNICA <br> PABLO REBOLLO</h1>
    <p class="p-home text-center">Crea, sube y gestiona tus documentos</p>
    @if (Auth::check())
        <a href="{{ route('documents.store') }}" class="btn-home btn btn-primary btn-lg mt-4">Acceso a Documentos</a>
    @else
        <a href="{{ route('login') }}" class="btn-home btn btn-primary btn-lg mt-4">Accede ahora</a>
    @endif

</div>
@endsection
