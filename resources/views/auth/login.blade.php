@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@vite('resources/css/login.css')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-card card" style="width: 30rem;">
        <div class="card-body">
            <h5 class="login-titulo card-title text-center">Iniciar Sesión</h5>

            @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }} <!-- Muestra el primer error -->
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf <!-- Token CSRF para la protección -->
                <div class="form-group">
                    <label class="login-label" for="nickname">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" required>
                </div>
                <div class="form-group">
                    <label class="login-label" for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-gen1 btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>
@endsection
