@extends('admin.maindesign')
@section('page_title', 'Agregar Slide')
@section('content')
<div class="container">
    <h2 class="mb-4">Agregar Slide</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label>Imagen</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Texto</label>
            <input type="text" name="text" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Orden</label>
            <input type="number" name="order" class="form-control" value="0">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="active" class="form-check-input" checked>
            <label class="form-check-label">Activo</label>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
