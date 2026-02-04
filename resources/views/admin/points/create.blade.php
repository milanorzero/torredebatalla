@extends('admin.maindesign')

@section('page_title', 'Asignar puntos')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid">

    <div class="card w-100">
        <div class="card-header">
            <strong>Asignar puntos a jugador</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.points.store') }}">
                @csrf

                {{-- JUGADOR --}}
                <div class="form-group mb-3">
                    <label>Jugador</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Seleccione jugador</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} — {{ $user->points_balance }} pts
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PUNTOS --}}
                <div class="form-group mb-3">
                    <label>Puntos (positivos o negativos)</label>
                    <input type="number"
                           name="points"
                           class="form-control"
                           placeholder="Ej: 100 o -50"
                           required>
                </div>

                {{-- MOTIVO --}}
                <div class="form-group mb-4">
                    <label>Motivo</label>
                    <input type="text"
                           name="description"
                           class="form-control"
                           placeholder="Ej: Torneo semanal, premio, corrección"
                           required>
                </div>

                <button class="btn btn-success">
                    Asignar puntos
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
