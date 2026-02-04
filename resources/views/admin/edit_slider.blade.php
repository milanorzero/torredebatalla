@extends('admin.maindesign')

@section('content')
<div class="container mt-4">
    <h2>Imagen del Slider</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.slider.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="slider_image">Imagen actual:</label><br>
            @if($slider)
                <img src="{{ asset('front_end/images/' . $slider) }}" alt="Slider" style="max-width: 400px;" class="mb-2">
            @else
                <span class="text-muted">No hay imagen cargada</span>
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="slider_image">Subir nueva imagen</label>
            <input type="file" name="slider_image" class="form-control">
            <small class="form-text text-muted">Tamaño recomendado: 1200x400px. Máx 4MB.</small>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar imagen</button>
    </form>
</div>
@endsection
