@extends('admin.maindesign')

@section('page_title', 'Calendario semanal')

@section('content')

@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mb-3">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-header">
            <strong>Subir imagen de calendario</strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.events.calendar.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label>Imagen (jpg/png/webp, max 10MB)</label>
                    <input type="file" name="calendar_image" class="form-control" required>
                </div>

                <button class="btn btn-primary">
                    Guardar calendario
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Vista previa</strong>
        </div>

        <div class="card-body text-center">
            @if($calendarImageUrl)
                <img src="{{ $calendarImageUrl }}" alt="Calendario semanal" class="img-fluid" style="max-height: 600px;">
            @else
                <div class="text-muted">Aún no hay imagen cargada.</div>
            @endif
        </div>
    </div>

</div>
@endsection
