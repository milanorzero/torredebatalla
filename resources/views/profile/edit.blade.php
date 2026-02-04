@extends('maindesign')

@section('title', 'Mi perfil')

@section('shop')
<div class="container" style="max-width: 600px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">

            <h2 class="text-center mb-3">
                Mi perfil
            </h2>

            {{-- MENSAJE DE ESTADO --}}
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    Perfil actualizado correctamente.
                </div>
            @endif

            {{-- ACTUALIZAR PERFIL --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- NOMBRE --}}
                <div class="form-group mb-3">
                    <label>Nombre</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control"
                        required
                    >
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="form-group mb-4">
                    <label>Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="form-control"
                        required
                    >
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary w-100">
                    Guardar cambios
                </button>
            </form>

            <hr class="my-4">

            {{-- ELIMINAR CUENTA --}}
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <h5 class="text-danger">Eliminar cuenta</h5>
                <p class="text-muted">
                    Esta acción no se puede deshacer.
                </p>

                <div class="form-group mb-3">
                    <label>Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                    @error('password', 'userDeletion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-outline-danger w-100">
                    Eliminar cuenta
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
