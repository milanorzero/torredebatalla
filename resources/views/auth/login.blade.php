@extends('maindesign')

@section('title', 'Iniciar sesión')

@section('shop')
<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">

            <h2 class="text-center mb-3">
                Iniciar sesión
            </h2>

            {{-- MENSAJE DE SESIÓN (ej: contraseña reseteada) --}}
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login', [], false) }}">
                @csrf

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
                        autofocus
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
                        required
                    >
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- RECORDAR SESIÓN --}}
                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        name="remember"
                        class="form-check-input"
                        id="remember"
                    >
                    <label class="form-check-label" for="remember">
                        Recordarme
                    </label>
                </div>

                {{-- BOTÓN --}}
                <button class="btn btn-primary w-100">
                    Iniciar sesión
                </button>

                {{-- LINKS --}}
                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div class="text-center mt-2">
                    <a href="{{ route('register') }}">
                        Crear cuenta
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
