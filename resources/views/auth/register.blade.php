@extends('maindesign')

@section('title', 'Crear cuenta')

@section('shop')
<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">

            <h2 class="text-center mb-2">
                Crear cuenta
            </h2>

            <p class="text-center text-muted mb-4">
                Únete a <strong>Torre de Batalla</strong> y comienza a jugar 🃏
            </p>

            <form method="POST" action="{{ route('register', [], false) }}" id="registerForm">
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
                        autocomplete="name"
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
                        autocomplete="email"
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
                        autocomplete="new-password"
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
                        autocomplete="new-password"
                    >
                </div>

                {{-- BOTÓN --}}
                <button type="submit" class="btn btn-primary w-100" id="registerBtn">
                    Crear cuenta
                </button>

                {{-- Mensaje de carga --}}
                <div class="text-center mt-3 d-none" id="registerLoading">
                    <small class="text-muted">Creando cuenta, por favor espera...</small>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Script anti doble envío --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registerForm");
    const btn = document.getElementById("registerBtn");
    const loading = document.getElementById("registerLoading");

    let enviado = false;

    form.addEventListener("submit", function () {
        if (enviado) {
            return false;
        }

        enviado = true;
        btn.disabled = true;
        btn.innerText = "Creando cuenta...";
        loading.classList.remove("d-none");
    });
});
</script>
@endsection
