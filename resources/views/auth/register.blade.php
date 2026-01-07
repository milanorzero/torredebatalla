@extends('maindesign')

@section('title', 'Crear cuenta')

@section('shop')
<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2 class="text-center mb-2">
                Crear cuenta
            </h2>

            <p class="text-center text-muted mb-4">
                Únete a <strong>Torre de Batalla</strong> y comienza a jugar 🃏
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- NOMBRE --}}
                <div class="form-group mb-3">
                    <label>Nombre completo</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control"
                        placeholder="Tu nombre completo"
                        required
                    >
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="form-group mb-3">
                    <label>Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control"
                        placeholder="correo@ejemplo.com"
                        required
                    >
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- CONTRASEÑA --}}
                <div class="form-group mb-3">
                    <label>Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Mínimo 8 caracteres"
                        required
                    >
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- CONFIRMAR CONTRASEÑA --}}
                <div class="form-group mb-4">
                    <label>Confirmar contraseña</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repite tu contraseña"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Crear cuenta
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
