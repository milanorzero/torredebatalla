@extends('admin.maindesign')
@section('page_title', 'Editar Slide')
@section('content')
<div class="container">
    <h2 class="mb-4">Editar Slide</h2>
    <form action="{{ route('admin.slider.update', ['slider' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label>Imagen</label><br>
            <img src="{{ asset($slider->image) }}" style="max-width:120px;" class="mb-2"><br>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Texto</label>
            <input type="text" name="text" class="form-control" value="{{ $slider->text }}">
        </div>
        <div class="form-group mb-3">
            <label>Orden</label>
            <input type="number" name="order" class="form-control" value="{{ $slider->order }}">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="active" class="form-check-input" {{ $slider->active ? 'checked' : '' }}>
            <label class="form-check-label">Activo</label>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
